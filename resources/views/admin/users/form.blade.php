<div class="field">
  <label for="username">Nama pengguna</label>
  <span class="hint">Huruf, angka, atau garis bawah. Contoh: rina_17</span>
  <input id="username" name="username" type="text" value="{{ old('username', $user->username) }}" autocomplete="off" required>
</div>

<div class="field">
  <label for="role">Peran</label>
  <select id="role" name="role">
    <option value="user" @selected(old('role', $user->role) === 'user')>Pengguna</option>
    <option value="admin" @selected(old('role', $user->role) === 'admin')>Admin</option>
  </select>
</div>

<div class="field">
  <label for="bidan_phone">Nomor bidan (opsional)</label>
  <input id="bidan_phone" name="bidan_phone" type="text" value="{{ old('bidan_phone', $user->bidan_phone) }}" placeholder="Contoh: 0812…">
</div>

<div class="field">
  <label for="password">Kata sandi</label>
  <span class="hint">{{ $isEdit ? 'Biarkan kosong bila tidak ingin diubah. Minimal 6 karakter.' : 'Minimal 6 karakter.' }}</span>
  <div class="pass-wrap">
    <input id="password" name="password" type="password" autocomplete="new-password" @required(! $isEdit)>
    @include('partials.toggle-eye', ['target' => 'password'])
  </div>
</div>

<div class="form-actions">
  <button type="submit" class="btn-primary">{{ $isEdit ? 'Simpan perubahan' : 'Tambah pengguna' }}</button>
  <a class="btn ghost" href="{{ route('admin.users.index') }}" style="text-align:center">Batal</a>
</div>
