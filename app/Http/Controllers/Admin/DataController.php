<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\DailyTargetLog;
use App\Models\ImtMeasurement;
use App\Models\LilaMeasurement;
use App\Models\QuizAttempt;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DataController extends Controller
{
    public function lila(Request $request): View
    {
        $rows = LilaMeasurement::with('user')
            ->when($request->filled('q'), fn ($q) => $q->whereHas('user', fn ($u) => $u->where('username', 'like', '%'.$request->string('q').'%')))
            ->when($request->input('risk') === '1', fn ($q) => $q->where('value_cm', '<', 23.5))
            ->when($request->input('risk') === '0', fn ($q) => $q->where('value_cm', '>=', 23.5))
            ->latest('measured_at')->latest('id')
            ->paginate(20)->withQueryString();

        return view('admin.data.lila', compact('rows'));
    }

    public function destroyLila(LilaMeasurement $lila): RedirectResponse
    {
        $lila->delete();

        return back()->with('sukses', 'Data LILA dihapus.');
    }

    public function imt(Request $request): View
    {
        $rows = ImtMeasurement::with('user')
            ->when($request->filled('q'), fn ($q) => $q->whereHas('user', fn ($u) => $u->where('username', 'like', '%'.$request->string('q').'%')))
            ->when($request->filled('category'), function ($q) use ($request) {
                [$min, $max] = $this->bmiRange($request->string('category')->toString());
                $q->where('bmi', '>=', $min)->where('bmi', '<', $max);
            })
            ->latest('measured_at')->latest('id')
            ->paginate(20)->withQueryString();

        return view('admin.data.imt', compact('rows'));
    }

    /**
     * Batas bawah (inklusif) dan atas (eksklusif) IMT per kategori WHO.
     *
     * @return array{0: float, 1: float}
     */
    private function bmiRange(string $category): array
    {
        return match ($category) {
            'kurus' => [0, 18.5],
            'normal' => [18.5, 25],
            'overweight' => [25, 30],
            'obesitas' => [30, PHP_FLOAT_MAX],
            default => [0, PHP_FLOAT_MAX],
        };
    }

    public function destroyImt(ImtMeasurement $imt): RedirectResponse
    {
        $imt->delete();

        return back()->with('sukses', 'Data IMT dihapus.');
    }

    public function quiz(Request $request): View
    {
        $rows = QuizAttempt::with('user')
            ->when($request->filled('q'), fn ($q) => $q->whereHas('user', fn ($u) => $u->where('username', 'like', '%'.$request->string('q').'%')))
            ->when($request->filled('type'), fn ($q) => $q->where('type', $request->input('type')))
            ->latest('taken_at')->latest('id')
            ->paginate(20)->withQueryString();

        return view('admin.data.quiz', compact('rows'));
    }

    public function destroyQuiz(QuizAttempt $attempt): RedirectResponse
    {
        $attempt->delete();

        return back()->with('sukses', 'Hasil kuis dihapus.');
    }

    public function quizShow(QuizAttempt $attempt): View
    {
        $attempt->load(['user', 'answers.question.options', 'answers.option']);

        return view('admin.data.quiz-show', compact('attempt'));
    }

    public function activity(Request $request): View
    {
        $rows = ActivityLog::with('user')
            ->when($request->filled('q'), fn ($q) => $q->whereHas('user', fn ($u) => $u->where('username', 'like', '%'.$request->string('q').'%')))
            ->when($request->filled('event'), fn ($q) => $q->where('event', $request->input('event')))
            ->latest()
            ->paginate(30)->withQueryString();

        $events = ActivityLog::distinct()->orderBy('event')->pluck('event');

        return view('admin.data.activity', compact('rows', 'events'));
    }

    public function destroyActivity(ActivityLog $log): RedirectResponse
    {
        $log->delete();

        return back()->with('sukses', 'Aktivitas dihapus.');
    }

    public function target(Request $request): View
    {
        $rows = DailyTargetLog::with(['user', 'checklistItem'])
            ->when($request->filled('q'), fn ($q) => $q->whereHas('user', fn ($u) => $u->where('username', 'like', '%'.$request->string('q').'%')))
            ->when($request->filled('date'), fn ($q) => $q->whereDate('log_date', $request->date('date')))
            ->latest('log_date')->latest('id')
            ->paginate(30)->withQueryString();

        return view('admin.data.target', compact('rows'));
    }

    public function destroyTarget(DailyTargetLog $log): RedirectResponse
    {
        $log->delete();

        return back()->with('sukses', 'Log target dihapus.');
    }
}
