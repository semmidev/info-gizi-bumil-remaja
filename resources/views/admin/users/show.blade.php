@extends('layouts.admin')

@section('title', $user->username)
@section('heading', $user->username)
@section('subtitle', 'Detail pengguna')

@section('content')
  <div class="section-head">
    <h2>Profil</h2>
    <div style="display:flex; gap:6px; align-items:center">
      <span class="pill {{ $user->role }}">{{ $user->role === 'admin' ? 'Admin' : 'Pengguna' }}</span>
      <a class="btn ghost small" href="{{ route('admin.users.edit', $user) }}">Edit</a>
    </div>
  </div>

  <div class="stat-grid">
    <div class="stat"><b>{{ $user->lila_measurements_count }}</b><small>Pengukuran LILA</small></div>
    <div class="stat c"><b>{{ $user->quiz_attempts_count }}</b><small>Pengerjaan kuis</small></div>
    <div class="stat g"><b>{{ $user->daily_target_logs_count }}</b><small>Log target</small></div>
    <div class="stat d"><b>{{ $user->activity_logs_count }}</b><small>Aktivitas</small></div>
  </div>

  <div class="panel">
    <h3>Informasi</h3>
    <div class="akun-row"><span>Nama pengguna</span><b>{{ $user->username }}</b></div>
    <div class="akun-row"><span>Peran</span><b>{{ $user->role === 'admin' ? 'Admin' : 'Pengguna' }}</b></div>
    <div class="akun-row"><span>Nomor bidan</span><b>{{ $user->bidan_phone ?: '–' }}</b></div>
    <div class="akun-row"><span>Bergabung</span><b>{{ $user->created_at->translatedFormat('d F Y') }}</b></div>
  </div>

  <div class="panel">
    <h3>LILA terakhir</h3>
    @if ($latestLila)
      <div class="list-item">
        <div class="li-main"><b>{{ number_format((float) $latestLila->value_cm, 1, ',', '.') }} cm</b><small>{{ $latestLila->measured_at->translatedFormat('d M Y') }}</small></div>
        <div class="li-side">
          <span class="pill {{ $latestLila->value_cm < 23.5 ? 'risk' : 'ok' }}">{{ $latestLila->value_cm < 23.5 ? 'Berisiko KEK' : 'Normal' }}</span>
        </div>
      </div>
    @else
      <p class="empty">Belum ada pengukuran.</p>
    @endif
  </div>

  <div class="panel">
    <h3>Hasil kuis terakhir</h3>
    <div class="table-scroll">
      <table class="atable">
        <thead><tr><th>Jenis</th><th>Skor</th><th>Tanggal</th></tr></thead>
        <tbody>
          @foreach (['pengetahuan' => 'Pengetahuan', 'sikap' => 'Sikap', 'tindakan' => 'Tindakan'] as $key => $label)
            @php $a = $latestQuiz->get($key); @endphp
            <tr>
              <td>{{ $label }}</td>
              <td>{{ $a ? $a->percentage . '%' : '–' }}</td>
              <td>{{ $a ? $a->taken_at->translatedFormat('d M Y') : '–' }}</td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>

  <div class="panel">
    <h3>Target harian</h3>
    @forelse ($targetsByDate as $date => $logs)
      @php $doneCount = $logs->where('is_done', true)->count(); @endphp
      <div class="list-item" style="align-items:flex-start">
        <div class="li-main" style="width:100%">
          <b>{{ \Illuminate\Support\Carbon::parse($date)->translatedFormat('d M Y') }} · {{ $doneCount }}/{{ $targetTotal }}</b>
          <div style="margin-top:6px; display:grid; gap:4px">
            @foreach ($logs as $log)
              <small style="white-space:normal">{{ $log->is_done ? '✓' : '○' }} {{ $log->checklistItem?->label ?? '–' }}</small>
            @endforeach
          </div>
        </div>
      </div>
    @empty
      <p class="empty">Belum ada log target.</p>
    @endforelse
  </div>

  <div class="panel">
    <div class="section-head">
      <h3>Log aktivitas</h3>
      <a class="pill user" href="{{ route('admin.data.activity', ['q' => $user->username]) }}">Lihat semua</a>
    </div>
    @forelse ($activity as $log)
      <div class="list-item">
        <div class="li-main">
          <b>{{ str_replace('_', ' ', $log->event) }}</b>
          <small>{{ $log->description ?: '–' }}{{ $log->duration_seconds ? ' · ' . $log->duration_seconds . ' dtk' : '' }}</small>
        </div>
        <div class="li-side"><small>{{ $log->created_at->translatedFormat('d M H:i') }}</small></div>
      </div>
    @empty
      <p class="empty">Belum ada aktivitas.</p>
    @endforelse
  </div>

  <div class="panel">
    <div class="section-head">
      <h3>Riwayat LILA</h3>
      <a class="pill user" href="{{ route('admin.data.lila', ['q' => $user->username]) }}">Lihat semua</a>
    </div>
    @forelse ($lilaHistory as $m)
      <div class="list-item">
        <div class="li-main"><b>{{ number_format((float) $m->value_cm, 1, ',', '.') }} cm</b><small>{{ $m->measured_at->translatedFormat('d M Y') }}</small></div>
        <div class="li-side"><span class="pill {{ $m->value_cm < 23.5 ? 'risk' : 'ok' }}">{{ $m->value_cm < 23.5 ? 'Berisiko' : 'Normal' }}</span></div>
      </div>
    @empty
      <p class="empty">Belum ada pengukuran.</p>
    @endforelse
  </div>

  <div class="panel">
    <div class="section-head">
      <h3>Riwayat kuis</h3>
      <a class="pill user" href="{{ route('admin.data.quiz', ['q' => $user->username]) }}">Lihat semua</a>
    </div>
    @forelse ($quizHistory as $attempt)
      <div class="list-item">
        <div class="li-main"><b>{{ ucfirst($attempt->type) }}</b><small>{{ $attempt->raw_score }}/{{ $attempt->max_score }} · {{ $attempt->taken_at->translatedFormat('d M Y') }}</small></div>
        <div class="li-side"><span class="pill {{ $attempt->percentage >= 76 ? 'ok' : ($attempt->percentage >= 56 ? 'user' : 'risk') }}">{{ $attempt->percentage }}%</span></div>
      </div>
    @empty
      <p class="empty">Belum ada pengerjaan kuis.</p>
    @endforelse
  </div>

  <a class="btn ghost" href="{{ route('admin.users.index') }}" style="display:block; text-align:center">‹ Kembali</a>
@endsection
