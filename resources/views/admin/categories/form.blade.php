<div class="field">
  <label for="name">Nama kategori</label>
  <input id="name" name="name" type="text" value="{{ old('name', $category->name) }}" maxlength="100" required>
</div>

<div class="field">
  <label for="position">Urutan</label>
  <input id="position" name="position" type="number" min="0" value="{{ old('position', $category->position) }}" required>
</div>

<div class="form-actions">
  <button type="submit" class="btn-primary">{{ $category->exists ? 'Simpan perubahan' : 'Tambah kategori' }}</button>
  <a class="btn ghost" href="{{ route('admin.categories.index') }}" style="text-align:center">Batal</a>
</div>
