<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\LilaMeasurement;
use App\Models\QuizAttempt;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ExportController extends Controller
{
    public function index(): View
    {
        return view('admin.ekspor', [
            'counts' => [
                'users' => User::count(),
                'quiz' => QuizAttempt::count(),
                'lila' => LilaMeasurement::count(),
                'activity' => ActivityLog::count(),
            ],
        ]);
    }

    public function download(Request $request, string $dataset): StreamedResponse
    {
        return match ($dataset) {
            'users' => $this->stream('pengguna', ['id', 'username', 'role', 'bidan_phone', 'created_at'], User::query()->orderBy('id')->cursor(), fn (User $u) => [$u->id, $u->username, $u->role, $u->bidan_phone, $u->created_at]),
            'quiz' => $this->stream('hasil-kuis', ['id', 'username', 'type', 'raw_score', 'max_score', 'percentage', 'taken_at'], QuizAttempt::with('user')->orderBy('id')->cursor(), fn (QuizAttempt $a) => [$a->id, $a->user?->username, $a->type, $a->raw_score, $a->max_score, $a->percentage, $a->taken_at?->toDateString()]),
            'lila' => $this->stream('pengukuran-lila', ['id', 'username', 'value_cm', 'measured_at'], LilaMeasurement::with('user')->orderBy('id')->cursor(), fn (LilaMeasurement $m) => [$m->id, $m->user?->username, $m->value_cm, $m->measured_at?->toDateString()]),
            'activity' => $this->stream('aktivitas', ['id', 'username', 'device_id', 'event', 'description', 'duration_seconds', 'created_at'], ActivityLog::with('user')->orderBy('id')->cursor(), fn (ActivityLog $l) => [$l->id, $l->user?->username, $l->device_id, $l->event, $l->description, $l->duration_seconds, $l->created_at]),
        };
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
