@extends('layouts.admin')

@section('title', 'Beranda')
@section('heading', 'Ringkasan')
@section('subtitle', 'Pantau aplikasi sekilas')

@section('content')
  <div class="stat-grid">
    <div class="stat d"><b>{{ $stats['users'] }}</b><small>Total pengguna</small></div>
    <div class="stat g"><b>{{ $stats['new_users'] }}</b><small>Pengguna baru (7 hari)</small></div>
    <div class="stat"><b>{{ $stats['lila'] }}</b><small>Pengukuran LILA</small></div>
    <div class="stat c"><b>{{ $stats['quiz_avg'] }}%</b><small>Rata-rata skor kuis</small></div>
    <div class="stat r"><b>{{ $stats['risky'] }}</b><small>Berisiko KEK (LILA terakhir)</small></div>
    <div class="stat d"><b>{{ $stats['activity_today'] }}</b><small>Aktivitas hari ini</small></div>
  </div>

  <div class="panel">
    <h3>Hasil kuis per jenis</h3>
    <div class="table-scroll">
      <table class="atable">
        <thead><tr><th>Jenis</th><th>Jumlah</th><th>Rata-rata</th></tr></thead>
        <tbody>
          @foreach (['pengetahuan' => 'Pengetahuan', 'sikap' => 'Sikap', 'tindakan' => 'Tindakan'] as $key => $label)
            @php $row = $quizByType->get($key); @endphp
            <tr>
              <td>{{ $label }}</td>
              <td>{{ $row->total ?? 0 }}</td>
              <td>{{ $row->avg_score ?? 0 }}%</td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>

  <div class="panel">
    <div class="section-head"><h3>Pengguna terbaru</h3><a class="pill user" href="{{ route('admin.users.index') }}">Lihat semua</a></div>
    @forelse ($recentUsers as $user)
      <a class="list-item" href="{{ route('admin.users.show', $user) }}" style="text-decoration:none;color:inherit">
        <div class="li-main"><b>{{ $user->username }}</b><small>Bergabung {{ $user->created_at->translatedFormat('d M Y') }}</small></div>
        <div class="li-side"><span class="pill {{ $user->role }}">{{ $user->role === 'admin' ? 'Admin' : 'Pengguna' }}</span></div>
      </a>
    @empty
      <p class="empty">Belum ada pengguna.</p>
    @endforelse
  </div>

  <div class="panel">
    <h3>Aktivitas terbaru</h3>
    @forelse ($recentActivity as $log)
      <div class="list-item">
        <div class="li-main">
          <b>{{ str_replace('_', ' ', $log->event) }}</b>
          <small>{{ $log->user?->username ?? '–' }}{{ $log->description ? ' · ' . $log->description : '' }}</small>
        </div>
        <div class="li-side"><small>{{ $log->created_at->translatedFormat('d M H:i') }}</small></div>
      </div>
    @empty
      <p class="empty">Belum ada aktivitas.</p>
    @endforelse
  </div>
@endsection
