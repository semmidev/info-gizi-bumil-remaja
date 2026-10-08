<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\DailyTargetLog;
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
