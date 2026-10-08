<div class="field">
  <label for="type">Jenis kuis</label>
  <select id="type" name="type" data-quiz-type>
    <option value="pengetahuan" @selected(old('type', $question->type ?? 'pengetahuan') === 'pengetahuan')>Pengetahuan</option>
    <option value="sikap" @selected(old('type', $question->type) === 'sikap')>Sikap</option>
    <option value="tindakan" @selected(old('type', $question->type) === 'tindakan')>Tindakan</option>
  </select>
</div>

<div class="field" data-for-type="pengetahuan tindakan">
  <label for="indicator">Indikator</label>
  <span class="hint">Contoh: Pengertian KEK, Pencegahan: TTD.</span>
  <input id="indicator" name="indicator" type="text" value="{{ old('indicator', $question->indicator) }}">
</div>

<div class="field">
  <label for="text">Tulis soal / pernyataan</label>
  <textarea id="text" name="text" required>{{ old('text', $question->text) }}</textarea>
</div>

<div class="field" data-for-type="pengetahuan tindakan">
  <label for="position">Urutan</label>
  <input id="position" name="position" type="number" min="0" value="{{ old('position', $defaultPosition) }}" required>
</div>

{{-- Pengetahuan --}}
<div data-for-type="pengetahuan">
  <div class="field">
    <label>Pilihan jawaban</label>
    <span class="hint">Tandai bulatan untuk jawaban yang benar.</span>
    <div id="options-box">
      @php $opts = $question->exists ? $question->options : collect([null, null, null]); @endphp
      @foreach ($opts as $i => $opt)
        <div class="opt-row">
          <input type="radio" name="correct" value="{{ $i }}" @checked(old('correct', optional($opt)->is_correct) == true || ($opt && $opt->is_correct))>
          <input type="text" name="options[]" value="{{ old('options.' . $i, optional($opt)->label) }}" placeholder="Tulis pilihan…">
          <button type="button" class="btn ghost small" data-remove>✕</button>
        </div>
      @endforeach
    </div>
    <button type="button" class="btn ghost small" id="add-option" style="margin-top:4px">+ Tambah opsi</button>
  </div>
  <div class="field">
    <label for="explanation">Penjelasan jawaban</label>
    <textarea id="explanation" name="explanation">{{ old('explanation', $question->explanation) }}</textarea>
  </div>
</div>

{{-- Sikap --}}
<div data-for-type="sikap">
  <div class="field">
    <label for="aspect">Aspek</label>
    <select id="aspect" name="aspect">
      <option value="Kognitif" @selected(old('aspect', $question->aspect) === 'Kognitif')>Kognitif</option>
      <option value="Afektif" @selected(old('aspect', $question->aspect) === 'Afektif')>Afektif</option>
      <option value="Konatif" @selected(old('aspect', $question->aspect) === 'Konatif')>Konatif</option>
    </select>
  </div>
  <label class="field-row"><input type="checkbox" name="is_favorable" value="1" @checked(old('is_favorable', $question->is_favorable))> Pernyataan bersifat positif (favorable)</label>
  <div class="field">
    <label for="good_feedback">Penjelasan bila sesuai</label>
    <textarea id="good_feedback" name="good_feedback">{{ old('good_feedback', $question->good_feedback) }}</textarea>
  </div>
  <div class="field">
    <label for="bad_feedback">Penjelasan bila belum sesuai</label>
    <textarea id="bad_feedback" name="bad_feedback">{{ old('bad_feedback', $question->bad_feedback) }}</textarea>
  </div>
  <p class="tip">Skala jawaban (Sangat setuju … Sangat tidak setuju) dibuat otomatis.</p>
</div>

{{-- Tindakan --}}
<div data-for-type="tindakan">
  <div class="field">
    <label for="tip">Saran bila belum rutin</label>
    <textarea id="tip" name="tip">{{ old('tip', $question->tip) }}</textarea>
  </div>
  <p class="tip">Skala jawaban (Setiap hari … Tidak pernah) dibuat otomatis.</p>
</div>

<div class="form-actions">
  <button type="submit" class="btn-primary">{{ $question->exists ? 'Simpan perubahan' : 'Tambah soal' }}</button>
  <a class="btn ghost" href="{{ route('admin.quiz.index') }}" style="text-align:center">Batal</a>
</div>
