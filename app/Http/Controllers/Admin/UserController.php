<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ChecklistItem;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class UserController extends Controller
{
    public function index(Request $request): View
    {
        $users = User::query()
            ->when($request->filled('q'), fn ($q) => $q->where('username', 'like', '%'.$request->string('q').'%'))
            ->when($request->filled('role'), fn ($q) => $q->where('role', $request->input('role')))
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('admin.users.index', compact('users'));
    }

    public function create(): View
    {
        return view('admin.users.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'username' => ['required', 'string', 'min:3', 'max:20', 'alpha_dash', Rule::unique('users', 'username')],
            'password' => ['required', 'string', 'min:6'],
            'role' => ['required', 'in:admin,user'],
            'bidan_phone' => ['nullable', 'string', 'max:30'],
            'full_name' => ['nullable', 'string', 'max:100'],
            'age' => ['nullable', 'integer', 'between:10,60'],
            'address' => ['nullable', 'string', 'max:255'],
            'pregnancy_month' => ['nullable', 'integer', 'between:1,9'],
        ]);

        User::create($data);

        return redirect()->route('admin.users.index')->with('sukses', 'Pengguna berhasil ditambahkan.');
    }

    public function show(User $user): View
    {
        $user->loadCount(['lilaMeasurements', 'quizAttempts', 'dailyTargetLogs', 'activityLogs']);

        $latestLila = $user->lilaMeasurements()->latest('measured_at')->latest('id')->first();
        $latestQuiz = $user->quizAttempts()->latest('taken_at')->latest('id')->get()->keyBy('type');

        $latestTargetLog = $user->dailyTargetLogs()->latest('log_date')->latest('id')->first();
        $targetsByDate = $latestTargetLog
            ? $user->dailyTargetLogs()->with('checklistItem')
                ->whereDate('log_date', $latestTargetLog->log_date->toDateString())
                ->latest('id')->get()
                ->groupBy(fn ($log) => $log->log_date->toDateString())
            : collect();

        $activity = $user->activityLogs()->latest()->take(1)->get();
        $quizHistory = $user->quizAttempts()
            ->with(['answers.question.options', 'answers.option'])
            ->latest('taken_at')->latest('id')->take(1)->get();
        $targetTotal = ChecklistItem::count();

        return view('admin.users.show', compact(
            'user', 'latestLila', 'latestQuiz', 'targetsByDate', 'activity', 'quizHistory', 'targetTotal'
        ));
    }

    public function edit(User $user): View
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user): RedirectResponse
    {
        $data = $request->validate([
            'username' => ['required', 'string', 'min:3', 'max:20', 'alpha_dash', Rule::unique('users', 'username')->ignore($user->id)],
            'password' => ['nullable', 'string', 'min:6'],
            'role' => ['required', 'in:admin,user'],
            'bidan_phone' => ['nullable', 'string', 'max:30'],
            'full_name' => ['nullable', 'string', 'max:100'],
            'age' => ['nullable', 'integer', 'between:10,60'],
            'address' => ['nullable', 'string', 'max:255'],
            'pregnancy_month' => ['nullable', 'integer', 'between:1,9'],
        ]);

        if ($user->is($request->user()) && $data['role'] !== 'admin') {
            return back()->withErrors(['role' => 'Kamu tidak bisa menurunkan peran akunmu sendiri.'])->withInput();
        }

        if (empty($data['password'] ?? null)) {
            unset($data['password']);
        }

        $user->update($data);

        return redirect()->route('admin.users.index')->with('sukses', 'Data pengguna diperbarui.');
    }

    public function destroy(Request $request, User $user): RedirectResponse
    {
        if ($user->is($request->user())) {
            return back()->withErrors(['user' => 'Kamu tidak bisa menghapus akunmu sendiri.']);
        }

        $user->delete();

        return redirect()->route('admin.users.index')->with('sukses', 'Pengguna dihapus.');
    }
}
