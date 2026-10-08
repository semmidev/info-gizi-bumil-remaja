<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ChecklistItem;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ChecklistItemController extends Controller
{
    public function index(): View
    {
        $items = ChecklistItem::orderBy('position')->get();

        return view('admin.checklist.index', compact('items'));
    }

    public function create(): View
    {
        return view('admin.checklist.create', ['item' => new ChecklistItem(['position' => (int) ChecklistItem::max('position') + 1])]);
    }

    public function store(Request $request): RedirectResponse
    {
        ChecklistItem::create($this->validated($request));

        return redirect()->route('admin.target.index')->with('sukses', 'Target ditambahkan.');
    }

    public function edit(ChecklistItem $target): View
    {
        return view('admin.checklist.edit', ['item' => $target]);
    }

    public function update(Request $request, ChecklistItem $target): RedirectResponse
    {
        $target->update($this->validated($request));

        return redirect()->route('admin.target.index')->with('sukses', 'Target diperbarui.');
    }

    public function destroy(ChecklistItem $target): RedirectResponse
    {
        $target->delete();

        return redirect()->route('admin.target.index')->with('sukses', 'Target dihapus.');
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'label' => ['required', 'string', 'max:255'],
            'position' => ['required', 'integer', 'min:0'],
        ]);
    }
}
