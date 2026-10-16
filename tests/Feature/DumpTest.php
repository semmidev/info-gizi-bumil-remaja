<?php
namespace Tests\Feature;
use App\Models\Content; use App\Models\ContentCategory; use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase; use Tests\TestCase;
class DumpTest extends TestCase {
  use RefreshDatabase;
  public function test_dump(): void {
    $cat = ContentCategory::create(['name'=>'Gizi','position'=>0]);
    $c = Content::create(['content_category_id'=>$cat->id,'position'=>0,'title'=>'Menu Sehat','description'=>'desc']);
    $u = User::create(['username'=>'r_1','password'=>'rahasia123','role'=>'user']);
    $html = $this->actingAs($u)->get(route('layanan'))->getContent();
    file_put_contents('/var/folders/0j/fchpc4gs1ynfh6qzjm_zhjw40000gn/T/opencode/kcard/index.html', $html);
    $this->assertTrue(true);
  }
}
