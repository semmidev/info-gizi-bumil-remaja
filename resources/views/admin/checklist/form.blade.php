<div class="field">
  <label for="label">Tulisan target</label>
  <input id="label" name="label" type="text" value="{{ old('label', $item->label) }}" required>
</div>

<div class="field">
  <label for="position">Urutan</label>
  <input id="position" name="position" type="number" min="0" value="{{ old('position', $item->position) }}" required>
</div>

<div class="form-actions">
  <button type="submit" class="btn-primary">{{ $item->exists ? 'Simpan perubahan' : 'Tambah target' }}</button>
  <a class="btn ghost" href="{{ route('admin.target.index') }}" style="text-align:center">Batal</a>
</div>
