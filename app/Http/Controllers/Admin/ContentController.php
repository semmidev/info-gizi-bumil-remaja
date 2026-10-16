<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Content;
use App\Models\ContentCategory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ContentController extends Controller
{
    public function index(): View
    {
        $contents = Content::with(['category', 'images'])->orderBy('position')->get();

        return view('admin.contents.index', compact('contents'));
    }

    public function create(): View
    {
        return view('admin.contents.create', [
            'content' => new Content(['position' => (int) Content::max('position') + 1]),
            'categories' => ContentCategory::orderBy('position')->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validated($request);
        $data['cover'] = $request->hasFile('cover')
            ? $request->file('cover')->store('covers', 'public')
            : null;

        $content = Content::create($data);

        return redirect()
            ->route('admin.contents.edit', $content)
            ->withFragment('slides')
            ->with('sukses', 'Konten ditambahkan. Tambahkan slide gambar di bawah.');
    }

    public function edit(Content $content): View
    {
        $content->load(['category', 'images']);

        return view('admin.contents.edit', [
            'content' => $content,
            'categories' => ContentCategory::orderBy('position')->get(),
            'nextPosition' => (int) $content->images()->max('position') + 1,
        ]);
    }

    public function update(Request $request, Content $content): RedirectResponse
    {
        $data = $this->validated($request);

        if ($request->hasFile('cover')) {
            if ($content->cover) {
                Storage::disk('public')->delete($content->cover);
            }
            $data['cover'] = $request->file('cover')->store('covers', 'public');
        } else {
            unset($data['cover']);
        }

        $content->update($data);

        return redirect()->route('admin.contents.index')->with('sukses', 'Konten diperbarui.');
    }

    public function destroy(Content $content): RedirectResponse
    {
        foreach ($content->images as $image) {
            Storage::disk('public')->delete($image->image);
        }
        if ($content->cover) {
            Storage::disk('public')->delete($content->cover);
        }
        $content->delete();

        return redirect()->route('admin.contents.index')->with('sukses', 'Konten beserta slidenya dihapus.');
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'content_category_id' => ['required', 'exists:content_categories,id'],
            'position' => ['required', 'integer', 'min:0'],
            'title' => ['required', 'string', 'max:150'],
            'description' => ['nullable', 'string'],
            'cover' => ['nullable', 'image', 'max:2048'],
        ]);
    }
}
