<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContentCategory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ContentCategoryController extends Controller
{
    public function index(): View
    {
        $categories = ContentCategory::withCount('contents')->orderBy('position')->get();

        return view('admin.categories.index', compact('categories'));
    }

    public function create(): View
    {
        return view('admin.categories.create', [
            'category' => new ContentCategory(['position' => (int) ContentCategory::max('position') + 1]),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        ContentCategory::create($this->validated($request));

        return redirect()->route('admin.categories.index')->with('sukses', 'Kategori ditambahkan.');
    }

    public function edit(ContentCategory $category): View
    {
        return view('admin.categories.edit', compact('category'));
    }

    public function update(Request $request, ContentCategory $category): RedirectResponse
    {
        $category->update($this->validated($request));

        return redirect()->route('admin.categories.index')->with('sukses', 'Kategori diperbarui.');
    }

    public function destroy(ContentCategory $category): RedirectResponse
    {
        if ($category->contents()->exists()) {
            return back()->withErrors(['category' => 'Kategori masih dipakai konten, pindahkan dulu kontennya.']);
        }

        $category->delete();

        return redirect()->route('admin.categories.index')->with('sukses', 'Kategori dihapus.');
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'position' => ['required', 'integer', 'min:0'],
        ]);
    }
}
