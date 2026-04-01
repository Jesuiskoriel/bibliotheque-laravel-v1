<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;

class AdminUserController extends Controller
{
    public function index()
    {
        $users = User::query()
            ->where('role', 'user')
            ->withCount([
                'loans as total_empruntes',
                'loans as en_cours' => fn ($query) => $query->whereNull('returned_at'),
            ])
            ->orderBy('name')
            ->paginate(12);

        return view('admin.users.index', compact('users'));
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
        abort_if($user->id === auth()->id(), 422, 'Vous ne pouvez pas bloquer votre propre compte.');

        $isBlocked = !$user->is_blocked;

        $user->update([
            'is_blocked' => $isBlocked,
            'blocked_at' => $isBlocked ? now() : null,
        ]);

        $message = $isBlocked
            ? 'Utilisateur bloqué.'
            : 'Utilisateur débloqué.';

        return back()->with('success', $message);
    }
}
