<div class="field">
  <label for="content_category_id">Kategori</label>
  <select id="content_category_id" name="content_category_id" required>
    @forelse ($categories as $category)
      <option value="{{ $category->id }}" @selected((string) old('content_category_id', $content->content_category_id) === (string) $category->id)>{{ $category->name }}</option>
    @empty
      <option value="" disabled>Belum ada kategori — buat dulu di Manajemen Kategori</option>
    @endforelse
  </select>
  @error('content_category_id')<span class="err">{{ $message }}</span>@enderror
</div>

<div class="field">
  <label for="title">Judul</label>
  <input id="title" name="title" type="text" value="{{ old('title', $content->title) }}" maxlength="150" required>
  @error('title')<span class="err">{{ $message }}</span>@enderror
</div>

<div class="field">
  <label for="description">Deskripsi (opsional)</label>
  <textarea id="description" name="description" rows="3" style="width:100%; font:inherit; font-weight:700; padding:13px 14px; border-radius:14px; border:2px solid var(--line); background:var(--bg); color:var(--ink)">{{ old('description', $content->description) }}</textarea>
  @error('description')<span class="err">{{ $message }}</span>@enderror
</div>

<div class="field">
  <label for="position">Urutan</label>
  <input id="position" name="position" type="number" min="0" value="{{ old('position', $content->position) }}" required>
  @error('position')<span class="err">{{ $message }}</span>@enderror
</div>

<div class="field">
  <label for="cover">Sampul (opsional, maks 2MB)</label>
  @if ($content->coverUrl())
    <div style="margin-bottom:8px; text-align:center"><img src="{{ $content->coverUrl() }}" alt="Sampul" style="width:240px; max-width:100%; border-radius:14px"></div>
  @endif
  <input id="cover" name="cover" type="file" accept="image/*">
  @error('cover')<span class="err">{{ $message }}</span>@enderror
</div>

<div class="form-actions">
  <button type="submit" class="btn-primary">{{ $content->exists ? 'Simpan perubahan' : 'Tambah konten' }}</button>
  <a class="btn ghost" href="{{ route('admin.contents.index') }}" style="text-align:center">Batal</a>
</div>
