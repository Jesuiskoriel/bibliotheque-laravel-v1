<?php
/* METAL-EXPLAIN: Ce fichier fait une partie du boulot de l'app bibliothèque. 
 * Version simple: ce fichier sert à éviter que tout parte en spaghetti 😄.
 * Lisez les fonctions une par une: chacune fait un mini boulot précis.
 */

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Loan;
use App\Models\Member;
use Illuminate\Http\Request;

class LoanController extends Controller
{
    /**
     * EXPLAIN-FUNC: Affiche la liste des éléments (page liste).
     */
    public function index()
    {
        $loans = Loan::with(['book','member'])->latest('loaned_at')->paginate(12);
        return view('loans.index', compact('loans'));
    }

    /**
     * EXPLAIN-FUNC: Affiche le formulaire pour créer un nouvel élément.
     */
    public function create()
    {
        return view('loans.create', [
            'books' => Book::where('stock_available', '>', 0)->orderBy('title')->get(),
            'members' => Member::orderBy('last_name')->get(),
        ]);
    }

    /**
     * EXPLAIN-FUNC: Vérifie les données envoyées puis enregistre en base.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'book_id'=>'required|exists:books,id',
            'member_id'=>'required|exists:members,id',
            'loaned_at'=>'required|date',
            'due_at'=>'required|date|after_or_equal:loaned_at',
            'notes'=>'nullable|string',
        ]);

        $book = Book::findOrFail($data['book_id']);
        if ($book->stock_available < 1) {
            return back()->withErrors(['book_id' => 'Ce livre n\'est plus disponible.'])->withInput();
        }

        Loan::create($data);
        $book->decrement('stock_available');

        return redirect()->route('loans.index')->with('success', 'Emprunt enregistré.');
    }

    /**
     * EXPLAIN-FUNC: Ouvre le formulaire d'édition avec les données existantes.
     */
    public function edit(Loan $loan)
    {
        return view('loans.edit', [
            'loan'=>$loan,
            'books'=>Book::orderBy('title')->get(),
            'members'=>Member::orderBy('last_name')->get(),
        ]);
    }

    /**
     * EXPLAIN-FUNC: Vérifie les nouvelles données puis met à jour la base.
     */
    public function update(Request $request, Loan $loan)
    {
        $data = $request->validate([
            'book_id'=>'required|exists:books,id',
            'member_id'=>'required|exists:members,id',
            'loaned_at'=>'required|date',
            'due_at'=>'required|date|after_or_equal:loaned_at',
            'returned_at'=>'nullable|date|after_or_equal:loaned_at',
            'notes'=>'nullable|string',
        ]);

        $wasReturned = !is_null($loan->returned_at);
        $isReturned = !empty($data['returned_at']);

        if (!$wasReturned && $isReturned) {
            $loan->book->increment('stock_available');
        } elseif ($wasReturned && !$isReturned) {
            $loan->book->decrement('stock_available');
        }

        $loan->update($data);
        return redirect()->route('loans.index')->with('success', 'Emprunt mis à jour.');
    }

    /**
     * EXPLAIN-FUNC: Supprime l'élément demandé (ou le marque supprimé).
     */
    public function destroy(Loan $loan)
    {
        if (is_null($loan->returned_at)) {
            $loan->book->increment('stock_available');
        }
        $loan->delete();

        return back()->with('success', 'Emprunt supprimé.');
    }
}

