<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\DailyTargetLog;
use App\Models\LilaMeasurement;
use App\Models\QuizAttempt;
use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ExportController extends Controller
{
    public function index(): View
    {
        $onlyUsers = $this->onlyRegularUsers();

        return view('admin.ekspor', [
            'counts' => [
                'users' => User::where('role', '!=', 'admin')->count(),
                'quiz' => QuizAttempt::whereHas('user', $onlyUsers)->count(),
                'lila' => LilaMeasurement::whereHas('user', $onlyUsers)->count(),
                'activity' => ActivityLog::whereHas('user', $onlyUsers)->count(),
                'target' => DailyTargetLog::whereHas('user', $onlyUsers)->count(),
            ],
        ]);
    }

    public function download(Request $request, string $dataset): StreamedResponse
    {
        $onlyUsers = $this->onlyRegularUsers();

        return match ($dataset) {
            'users' => $this->stream(
                'pengguna',
                ['ID', 'Nama Pengguna', 'Nama Lengkap', 'Umur (tahun)', 'Kelompok Umur', 'Alamat', 'Usia Kehamilan (bulan)', 'Trimester', 'Nomor Bidan', 'Terakhir Masuk', 'Bergabung'],
                User::where('role', '!=', 'admin')->orderBy('id')->cursor(),
                fn (User $u) => [
                    $u->id,
                    $u->username,
                    $u->full_name,
                    $u->age,
                    $this->kelompokUmur($u->age),
                    $u->address,
                    $u->pregnancy_month,
                    $this->trimester($u->pregnancy_month),
                    $u->bidan_phone,
                    $this->datetime($u->last_login_at),
                    $this->datetime($u->created_at),
                ],
            ),
            'quiz' => $this->stream(
                'hasil-kuis',
                ['ID', 'Nama Pengguna', 'Nama Lengkap', 'Jenis Kuis', 'Skor', 'Skor Maksimal', 'Nilai (%)', 'Kategori', 'Tanggal', 'Waktu Dicatat'],
                QuizAttempt::with('user')->whereHas('user', $onlyUsers)->orderBy('id')->cursor(),
                fn (QuizAttempt $a) => [
                    $a->id,
                    $a->user?->username,
                    $a->user?->full_name,
                    ucfirst($a->type),
                    $a->raw_score,
                    $a->max_score,
                    $a->percentage,
                    $this->kategoriNilai($a->percentage),
                    $this->date($a->taken_at),
                    $this->datetime($a->created_at),
                ],
            ),
            'lila' => $this->stream(
                'pengukuran-lila',
                ['ID', 'Nama Pengguna', 'Nama Lengkap', 'Nilai LILA (cm)', 'Status', 'Tanggal Ukur', 'Waktu Dicatat'],
                LilaMeasurement::with('user')->whereHas('user', $onlyUsers)->orderBy('id')->cursor(),
                fn (LilaMeasurement $m) => [
                    $m->id,
                    $m->user?->username,
                    $m->user?->full_name,
                    (float) $m->value_cm,
                    $this->statusLila($m->value_cm),
                    $this->date($m->measured_at),
                    $this->datetime($m->created_at),
                ],
            ),
            'activity' => $this->stream(
                'aktivitas',
                ['ID', 'Nama Pengguna', 'Nama Lengkap', 'Perangkat', 'Kegiatan', 'Keterangan', 'Durasi (detik)', 'Durasi (menit)', 'Waktu'],
                ActivityLog::with('user')->whereHas('user', $onlyUsers)->orderBy('id')->cursor(),
                fn (ActivityLog $l) => [
                    $l->id,
                    $l->user?->username,
                    $l->user?->full_name,
                    $l->device_id,
                    $l->event,
                    $l->description,
                    $l->duration_seconds,
                    $l->duration_seconds ? round($l->duration_seconds / 60, 2) : '',
                    $this->datetime($l->created_at),
                ],
            ),
            'target' => $this->stream(
                'target-harian',
                ['ID', 'Nama Pengguna', 'Nama Lengkap', 'Tanggal', 'Target', 'Status', 'Waktu Dicatat'],
                DailyTargetLog::with(['user', 'checklistItem'])->whereHas('user', $onlyUsers)->orderBy('id')->cursor(),
                fn (DailyTargetLog $t) => [
                    $t->id,
                    $t->user?->username,
                    $t->user?->full_name,
                    $this->date($t->log_date),
                    $t->checklistItem?->label,
                    $t->is_done ? 'Selesai' : 'Belum',
                    $this->datetime($t->created_at),
                ],
            ),
        };
    }

    /**
     * Constraint to keep only regular users (excludes admin accounts).
     */
    private function onlyRegularUsers(): Closure
    {
        return fn ($query) => $query->where('role', '!=', 'admin');
    }

    private function kelompokUmur(?int $age): string
    {
        return match (true) {
            $age === null => '',
            $age <= 14 => 'Remaja awal (10-14)',
            $age <= 19 => 'Remaja akhir (15-19)',
            default => 'Dewasa (20+)',
        };
    }

    private function trimester(?int $month): string
    {
        return match (true) {
            $month === null => '',
            $month <= 3 => 'Trimester I',
            $month <= 6 => 'Trimester II',
            $month <= 9 => 'Trimester III',
            default => '',
        };
    }

    private function kategoriNilai(?int $percentage): string
    {
        return match (true) {
            $percentage === null => '',
            $percentage >= 76 => 'Baik',
            $percentage >= 56 => 'Cukup',
            default => 'Perlu ditingkatkan',
        };
    }

    private function statusLila($valueCm): string
    {
        return (float) $valueCm < 23.5 ? 'Berisiko KEK' : 'Normal';
    }

    private function date($value): string
    {
        return $value ? $value->format('Y-m-d') : '';
    }

    private function datetime($value): string
    {
        return $value ? $value->format('Y-m-d H:i:s') : '';
    }

    private function stream(string $name, array $header, iterable $rows, callable $map): StreamedResponse
    {
        return response()->streamDownload(function () use ($header, $rows, $map) {
            $out = fopen('php://output', 'w');
            fwrite($out, "\xEF\xBB\xBF");
            fputcsv($out, $header, ',', '"', '');
            foreach ($rows as $row) {
                fputcsv($out, $map($row), ',', '"', '');
            }
            fclose($out);
        }, $name.'-'.now()->format('Ymd-His').'.csv', ['Content-Type' => 'text/csv; charset=UTF-8']);
    }
}
