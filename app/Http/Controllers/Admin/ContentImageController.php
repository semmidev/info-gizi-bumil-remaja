<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Content;
use App\Models\ContentImage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ContentImageController extends Controller
{
    public function store(Request $request, Content $content): RedirectResponse
    {
        $data = $request->validate([
            'image' => ['required', 'image', 'max:2048'],
            'position' => ['required', 'integer', 'min:0'],
        ]);

        $content->images()->create([
            'image' => $request->file('image')->store('slides', 'public'),
            'position' => $data['position'],
        ]);

        return back()->with('sukses', 'Slide ditambahkan.');
    }

    public function update(Request $request, ContentImage $slide): RedirectResponse
    {
        $data = $request->validate([
            'position' => ['required', 'integer', 'min:0'],
        ]);

        $slide->update($data);

        return back()->with('sukses', 'Urutan slide diperbarui.');
    }

    public function destroy(ContentImage $slide): RedirectResponse
    {
        Storage::disk('public')->delete($slide->image);
        $slide->delete();

        return back()->with('sukses', 'Slide dihapus.');
    }
}
