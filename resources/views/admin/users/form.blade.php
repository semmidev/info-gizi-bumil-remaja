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
  <label for="full_name">Nama lengkap (opsional)</label>
  <input id="full_name" name="full_name" type="text" value="{{ old('full_name', $user->full_name) }}" maxlength="100">
</div>

<div class="field">
  <label for="age">Umur, tahun (opsional)</label>
  <input id="age" name="age" type="number" inputmode="numeric" min="10" max="60" value="{{ old('age', $user->age) }}">
</div>

<div class="field">
  <label for="pregnancy_month">Usia kehamilan, bulan (opsional)</label>
  <input id="pregnancy_month" name="pregnancy_month" type="number" inputmode="numeric" min="1" max="9" value="{{ old('pregnancy_month', $user->pregnancy_month) }}">
</div>

<div class="field">
  <label for="address">Alamat (opsional)</label>
  <input id="address" name="address" type="text" value="{{ old('address', $user->address) }}" maxlength="255">
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
