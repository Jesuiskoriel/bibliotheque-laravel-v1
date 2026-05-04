<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class AdminUserController extends Controller
{
    public function index(Request $request)
    {
        $baseQuery = User::query()->where('role', 'user');

        $totalUsers = (clone $baseQuery)->count();
        $bannedUsers = (clone $baseQuery)->where('is_blocked', true)->count();
        $activeUsers = $totalUsers - $bannedUsers;

        $users = (clone $baseQuery)
            ->when($request->filled('q'), function ($query) use ($request) {
                $search = trim((string) $request->input('q'));

                $query->where(function ($inner) use ($search) {
                    $inner->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                });
            })
            ->when($request->input('status') === 'active', fn ($query) => $query->where('is_blocked', false))
            ->when($request->input('status') === 'banned', fn ($query) => $query->where('is_blocked', true))
            ->withCount([
                'loans as total_empruntes',
                'loans as en_cours' => fn ($query) => $query->whereNull('returned_at'),
            ])
            ->orderBy('name')
            ->paginate(12)
            ->withQueryString();

        return view('admin.users.index', compact('users', 'totalUsers', 'activeUsers', 'bannedUsers'));
    }

    public function show(User $user)
    {
        abort_if($user->role !== 'user', 404);

        $user->loadCount([
            'loans as total_empruntes',
            'loans as en_cours' => fn ($query) => $query->whereNull('returned_at'),
            'loans as total_rendus' => fn ($query) => $query->whereNotNull('returned_at'),
        ]);

        $activeLoans = $user->loans()
            ->with('book')
            ->whereNull('returned_at')
            ->orderBy('due_at')
            ->paginate(8, ['*'], 'active_page');

        $loanHistory = $user->loans()
            ->with('book')
            ->latest('loaned_at')
            ->paginate(10, ['*'], 'history_page');

        return view('admin.users.show', compact('user', 'activeLoans', 'loanHistory'));
    }

    public function toggleBlock(User $user): RedirectResponse
    {
        abort_if($user->role !== 'user', 403, 'Action interdite.');
        abort_if($user->id === auth()->id(), 422, 'Vous ne pouvez pas bannir votre propre compte.');

        $isBlocked = !$user->is_blocked;

        $user->update([
            'is_blocked' => $isBlocked,
            'blocked_at' => $isBlocked ? now() : null,
        ]);

        $message = $isBlocked
            ? 'Utilisateur banni.'
            : 'Utilisateur débanni.';

        return back()->with('success', $message);
    }
}
