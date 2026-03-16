<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use App\Services\LoanService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class UserLoanController extends Controller
{
    public function __construct(private LoanService $loanService)
    {
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'book_id' => ['required', 'exists:books,id'],
        ]);

        $this->loanService->createLoanForUser($data['book_id'], $request->user());

        return back()->with('success', 'Emprunt enregistré. Bonne lecture.');
    }

    public function markReturned(Request $request, Loan $loan): RedirectResponse
    {
        abort_unless($loan->user_id === $request->user()->id, 403, 'Accès interdit');

        $this->loanService->markAsReturned($loan);

        return back()->with('success', 'Livre retourné. Merci.');
    }
}
