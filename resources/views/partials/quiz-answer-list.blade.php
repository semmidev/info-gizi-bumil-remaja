@php
  $sorted = $attempt->answers->sortBy(fn ($a) => $a->question?->position);
@endphp
<div style="display:grid; gap:10px">
  @forelse ($sorted as $ans)
    @php $q = $ans->question; @endphp
    <div style="padding:10px 0; border-bottom:1px dashed var(--line)">
      <div style="display:flex; gap:8px; align-items:flex-start">
        <span class="pill {{ $ans->is_correct ? 'ok' : 'risk' }}">{{ $ans->is_correct ? 'Benar' : 'Perlu belajar' }}</span>
        <b style="font-weight:700; font-size:.95rem">{{ $q?->text ?? 'Soal sudah dihapus' }}</b>
      </div>
      <small style="color:var(--muted); font-weight:700; display:block; margin-top:4px">
        Jawabanmu: {{ $ans->option?->label ?? '–' }}
        @if ($q?->type === 'pengetahuan')
          · Kunci: {{ $q->options->firstWhere('is_correct', true)?->label ?? '–' }}
        @endif
      </small>
      @if ($q?->type === 'pengetahuan' && $q?->explanation)
        <div class="explain on" style="margin-top:6px">{{ $q->explanation }}</div>
      @elseif ($q?->type === 'sikap')
        <div class="explain on" style="margin-top:6px">{{ $ans->is_correct ? $q->good_feedback : $q->bad_feedback }}</div>
      @elseif ($q?->type === 'tindakan' && $q?->tip)
        <div class="explain on" style="margin-top:6px">{{ $ans->is_correct ? 'Hebat! Pertahankan kebiasaan ini setiap hari.' : $q->tip }}</div>
      @endif
    </div>
  @empty
    <p class="empty">Detail jawaban tidak tersedia.</p>
  @endforelse
</div>
