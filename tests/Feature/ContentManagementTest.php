<?php

namespace Tests\Feature;

use App\Models\Content;
use App\Models\ContentCategory;
use App\Models\ContentImage;
use App\Models\User;
use Illuminate\Foundation\Http\Middleware\ValidateCsrfToken;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ContentManagementTest extends TestCase
{
    use RefreshDatabase;

    private ?User $adminUser = null;

    private ?User $regularUser = null;

    private function admin(): User
    {
        return $this->adminUser ??= User::create(['username' => 'admin', 'password' => 'admin123', 'role' => 'admin']);
    }

    private function user(): User
    {
        return $this->regularUser ??= User::create(['username' => 'rina_17', 'password' => 'rahasia123', 'role' => 'user']);
    }

    public function test_admin_can_manage_categories(): void
    {
        $this->withoutMiddleware(ValidateCsrfToken::class);

        $this->actingAs($this->admin())->post(route('admin.categories.store'), [
            'name' => 'Gizi', 'position' => 1,
        ])->assertRedirect(route('admin.categories.index'));

        $category = ContentCategory::where('name', 'Gizi')->firstOrFail();

        $this->actingAs($this->admin())->put(route('admin.categories.update', $category), [
            'name' => 'Gizi Ibu', 'position' => 2,
        ])->assertRedirect(route('admin.categories.index'));

        $this->assertSame('Gizi Ibu', $category->fresh()->name);

        $this->actingAs($this->admin())->delete(route('admin.categories.destroy', $category))
            ->assertRedirect(route('admin.categories.index'));

        $this->assertDatabaseMissing('content_categories', ['id' => $category->id]);
    }

    public function test_category_with_contents_cannot_be_deleted(): void
    {
        $this->withoutMiddleware(ValidateCsrfToken::class);
        $category = ContentCategory::create(['name' => 'Gizi', 'position' => 0]);
        Content::create(['content_category_id' => $category->id, 'position' => 0, 'title' => 'Menu Sehat']);

        $this->actingAs($this->admin())->delete(route('admin.categories.destroy', $category))
            ->assertSessionHasErrors('category');

        $this->assertDatabaseHas('content_categories', ['id' => $category->id]);
    }

    public function test_admin_can_manage_content_with_cover_and_slides(): void
    {
        Storage::fake('public');
        $this->withoutMiddleware(ValidateCsrfToken::class);
        $category = ContentCategory::create(['name' => 'Gizi', 'position' => 0]);

        $this->actingAs($this->admin())->post(route('admin.contents.store'), [
            'content_category_id' => $category->id,
            'position' => 1,
            'title' => 'Menu Sehat',
            'description' => 'Contoh menu harian.',
            'cover' => UploadedFile::fake()->image('cover.jpg'),
        ])->assertRedirect(route('admin.contents.edit', Content::where('title', 'Menu Sehat')->firstOrFail()).'#slides');

        $content = Content::where('title', 'Menu Sehat')->firstOrFail();
        Storage::disk('public')->assertExists($content->cover);

        $this->actingAs($this->admin())->post(route('admin.contents.slides.store', $content), [
            'image' => UploadedFile::fake()->image('slide1.jpg'),
            'position' => 0,
        ])->assertRedirect();

        $slide = $content->images()->firstOrFail();
        Storage::disk('public')->assertExists($slide->image);

        $this->actingAs($this->admin())->put(route('admin.contents.slides.update', $slide), [
            'position' => 3,
        ])->assertRedirect();
        $this->assertSame(3, $slide->fresh()->position);

        $this->actingAs($this->admin())->delete(route('admin.contents.slides.destroy', $slide))
            ->assertRedirect();
        Storage::disk('public')->assertMissing($slide->image);
        $this->assertDatabaseMissing('content_images', ['id' => $slide->id]);
    }

    public function test_replacing_cover_deletes_old_file(): void
    {
        Storage::fake('public');
        $this->withoutMiddleware(ValidateCsrfToken::class);
        $category = ContentCategory::create(['name' => 'Gizi', 'position' => 0]);
        $content = Content::create([
            'content_category_id' => $category->id, 'position' => 0, 'title' => 'Menu',
            'cover' => UploadedFile::fake()->image('lama.jpg')->store('covers', 'public'),
        ]);

        $this->actingAs($this->admin())->put(route('admin.contents.update', $content), [
            'content_category_id' => $category->id,
            'position' => 0,
            'title' => 'Menu',
            'cover' => UploadedFile::fake()->image('baru.jpg'),
        ])->assertRedirect(route('admin.contents.index'));

        Storage::disk('public')->assertMissing('covers/lama.jpg');
        Storage::disk('public')->assertExists($content->fresh()->cover);
    }

    public function test_menarik_shows_managed_contents(): void
    {
        $category = ContentCategory::create(['name' => 'Gizi', 'position' => 0]);
        $content = Content::create([
            'content_category_id' => $category->id, 'position' => 0,
            'title' => 'Menu Sehat Bumil', 'description' => 'Makan beragam.',
        ]);
        ContentImage::create(['content_id' => $content->id, 'image' => 'slides/a.jpg', 'position' => 0]);

        $this->actingAs($this->user())->get(route('menarik'))
            ->assertOk()
            ->assertSee('Menu Sehat Bumil')
            ->assertSee('Gizi')
            ->assertSee('slides/a.jpg');
    }

    public function test_admin_content_pages_render(): void
    {
        $this->actingAs($this->admin())->get(route('admin.categories.index'))->assertOk();
        $this->actingAs($this->admin())->get(route('admin.contents.index'))->assertOk();
    }
}
