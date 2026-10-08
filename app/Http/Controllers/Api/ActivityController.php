<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ActivityController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'device_id' => ['nullable', 'string', 'max:40'],
            'events' => ['required', 'array'],
            'events.*.event' => ['required', 'string', 'max:50'],
            'events.*.description' => ['nullable', 'string'],
            'events.*.duration_seconds' => ['nullable', 'integer', 'min:0'],
        ]);

        $now = now();
        $rows = collect($data['events'])->map(fn (array $event) => [
            'user_id' => $request->user()->id,
            'device_id' => $data['device_id'] ?? null,
            'event' => $event['event'],
            'description' => $event['description'] ?? null,
            'duration_seconds' => $event['duration_seconds'] ?? null,
            'created_at' => $now,
            'updated_at' => $now,
        ])->all();

        $request->user()->activityLogs()->insert($rows);

        return response()->json(['stored' => count($rows)]);
    }

    public function index(Request $request): JsonResponse
    {
        // ponytail: tally in memory for the research panel; move to SQL aggregates if log volume grows.
        $logs = $request->user()->activityLogs()->latest('id')->get();

        $summary = [
            'user' => $request->user()->username,
            'kunjungan' => $logs->where('event', 'kunjungan')->count(),
            'minutes' => (int) round($logs->where('event', 'baca_menu')->sum('duration_seconds') / 60),
            'last' => optional($logs->first())->created_at?->format('Y-m-d H:i:s') ?? '–',
        ];

        $rows = $logs->take(300)->map(fn ($log) => [
            'waktu' => $log->created_at->format('Y-m-d H:i:s'),
            'kegiatan' => $log->event,
            'keterangan' => $log->description,
            'durasi_detik' => $log->duration_seconds,
        ])->values();

        return response()->json(['summary' => $summary, 'rows' => $rows]);
    }
}
