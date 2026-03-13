<?php
/* METAL-EXPLAIN: Ce contrôleur gère les emprunts. Version V2: la logique métier part dans LoanService. */

namespace App\Http\Controllers;

use App\Http\Requests\StoreLoanRequest;
use App\Http\Requests\UpdateLoanRequest;
use App\Models\Book;
use App\Models\Loan;
use App\Models\Member;
use App\Services\LoanService;

class LoanController extends Controller
{
    public function __construct(private LoanService $loanService)
    {
    }

    /** EXPLAIN-FUNC: Affiche la liste des emprunts. */
    public function index()
    {
        $loans = Loan::with(['book', 'member'])->latest('loaned_at')->paginate(12);
        return view('loans.index', compact('loans'));
    }

    /** EXPLAIN-FUNC: Affiche le formulaire de création d'un emprunt. */
    public function create()
    {
        return view('loans.create', [
            'books' => Book::where('stock_available', '>', 0)->orderBy('title')->get(),
            'members' => Member::orderBy('last_name')->get(),
        ]);
    }

    /** EXPLAIN-FUNC: Valide puis crée l'emprunt via le service métier. */
    public function store(StoreLoanRequest $request)
    {
        $this->loanService->createLoan($request->validated());

        return redirect()->route('loans.index')->with('success', 'Emprunt enregistré.');
    }

    /** EXPLAIN-FUNC: Affiche le formulaire d'édition d'un emprunt. */
    public function edit(Loan $loan)
    {
        return view('loans.edit', [
            'loan' => $loan,
            'books' => Book::orderBy('title')->get(),
            'members' => Member::orderBy('last_name')->get(),
        ]);
    }

    /** EXPLAIN-FUNC: Valide puis met à jour via le service métier. */
    public function update(UpdateLoanRequest $request, Loan $loan)
    {
        $this->loanService->updateLoan($loan, $request->validated());

        return redirect()->route('loans.index')->with('success', 'Emprunt mis à jour.');
    }

    /** EXPLAIN-FUNC: Supprime l'emprunt via le service métier. */
    public function destroy(Loan $loan)
    {
        $this->loanService->deleteLoan($loan);

        return back()->with('success', 'Emprunt supprimé.');
    }
}
