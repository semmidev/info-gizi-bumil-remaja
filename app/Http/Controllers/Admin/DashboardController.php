<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\LilaMeasurement;
use App\Models\QuizAttempt;
use App\Models\User;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        // ponytail: latest-per-user via MAX(id); switch to a window function if backfilled dates matter.
        $latestLilaIds = LilaMeasurement::selectRaw('MAX(id) as id')->groupBy('user_id')->pluck('id');

        $stats = [
            'users' => User::count(),
            'new_users' => User::where('created_at', '>=', now()->subDays(7))->count(),
            'lila' => LilaMeasurement::count(),
            'quiz_avg' => (int) round(QuizAttempt::avg('percentage') ?? 0),
            'risky' => LilaMeasurement::whereIn('id', $latestLilaIds)->where('value_cm', '<', 23.5)->count(),
            'activity_today' => ActivityLog::whereDate('created_at', now()->toDateString())->count(),
        ];

        $recentUsers = User::latest()->take(5)->get();
        $recentActivity = ActivityLog::with('user')->latest()->take(10)->get();

        $quizByType = QuizAttempt::selectRaw('type, count(*) as total, round(avg(percentage)) as avg_score')
            ->groupBy('type')
            ->get()
            ->keyBy('type');

        return view('admin.dashboard', compact('stats', 'recentUsers', 'recentActivity', 'quizByType'));
    }
}
