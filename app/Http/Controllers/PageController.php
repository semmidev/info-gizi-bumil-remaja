<?php

namespace App\Http\Controllers;

use App\Models\ChecklistItem;
use App\Models\QuizQuestion;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PageController extends Controller
{
    public function informasi(Request $request): View
    {
        $today = now()->toDateString();

        $done = $request->user()->dailyTargetLogs()
            ->whereDate('log_date', $today)
            ->where('is_done', true)
            ->pluck('checklist_item_id')
            ->all();

        $targets = ChecklistItem::orderBy('position')->get()->map(fn (ChecklistItem $item) => [
            'id' => $item->id,
            'label' => $item->label,
            'done' => in_array($item->id, $done, true),
        ])->values();

        return view('pages.informasi', ['data' => ['targets' => $targets]]);
    }

    public function kuis(Request $request): View
    {
        $user = $request->user();

        $questions = QuizQuestion::with('options')->orderBy('position')->get();

        $quiz = [
            'pengetahuan' => $questions->where('type', 'pengetahuan')->map(fn (QuizQuestion $q) => [
                'id' => $q->id,
                'indicator' => $q->indicator,
                'text' => $q->text,
                'explanation' => $q->explanation,
                'options' => $q->options->map(fn ($o) => ['label' => $o->label, 'correct' => $o->is_correct])->values(),
            ])->values(),
            'sikap' => $questions->where('type', 'sikap')->map(fn (QuizQuestion $q) => [
                'id' => $q->id,
                'aspect' => $q->aspect,
                'text' => $q->text,
                'favorable' => $q->is_favorable,
                'good' => $q->good_feedback,
                'bad' => $q->bad_feedback,
                'options' => $q->options->map(fn ($o) => ['label' => $o->label])->values(),
            ])->values(),
            'tindakan' => $questions->where('type', 'tindakan')->map(fn (QuizQuestion $q) => [
                'id' => $q->id,
                'indicator' => $q->indicator,
                'text' => $q->text,
                'tip' => $q->tip,
                'options' => $q->options->map(fn ($o) => ['label' => $o->label])->values(),
            ])->values(),
        ];

        $latest = $user->quizAttempts()->orderByDesc('taken_at')->orderByDesc('id')->get()->groupBy('type');

        $eval = [];
        foreach (['pengetahuan' => 'p', 'sikap' => 's', 'tindakan' => 't'] as $type => $key) {
            $attempt = $latest->get($type)?->first();
            $eval[$key] = $attempt ? [
                'percentage' => $attempt->percentage,
                'date' => $attempt->taken_at->translatedFormat('j M'),
            ] : null;
        }

        $perilaku = $user->quizAttempts()
            ->where('type', 'tindakan')
            ->orderBy('taken_at')
            ->orderBy('id')
            ->get()
            ->map(fn ($a) => [
                'percentage' => $a->percentage,
                'date' => $a->taken_at->translatedFormat('j M'),
            ])->values();

        return view('pages.kuis', ['data' => ['quiz' => $quiz, 'eval' => $eval, 'perilaku' => $perilaku]]);
    }

    public function lila(Request $request): View
    {
        $history = $request->user()->lilaMeasurements()
            ->orderBy('measured_at')
            ->orderBy('id')
            ->get()
            ->map(fn ($m) => [
                'value' => (float) $m->value_cm,
                'date' => $m->measured_at->translatedFormat('j M Y'),
            ])->values();

        return view('pages.lila', ['data' => ['lila' => $history]]);
    }

    public function layanan(Request $request): View
    {
        return view('pages.layanan', ['data' => ['bidan' => $request->user()->bidan_phone ?? '']]);
    }

    public function menarik(): View
    {
        return view('pages.menarik', ['data' => []]);
    }
}
