<?php

namespace App\Services;

use App\Models\Book;
use App\Models\Loan;

class LoanService
{
    /**
     * Crée un emprunt et met à jour le stock.
     */
    public function createLoan(array $data): Loan
    {
        $book = Book::findOrFail($data['book_id']);

        if ($book->stock_available < 1) {
            abort(422, "Ce livre n'est plus disponible.");
        }

        $loan = Loan::create($data);
        $book->decrement('stock_available');

        return $loan;
    }

    /**
     * Met à jour un emprunt et ajuste le stock si statut retour change.
     */
    public function updateLoan(Loan $loan, array $data): Loan
    {
        $wasReturned = !is_null($loan->returned_at);
        $isReturned = !empty($data['returned_at']);

        if (!$wasReturned && $isReturned) {
            $loan->book->increment('stock_available');
        } elseif ($wasReturned && !$isReturned) {
            $loan->book->decrement('stock_available');
        }

        $loan->update($data);

        return $loan;
    }

    /**
     * Supprime un emprunt. Si non rendu, remet le stock.
     */
    public function deleteLoan(Loan $loan): void
    {
        if (is_null($loan->returned_at)) {
            $loan->book->increment('stock_available');
        }

        $loan->delete();
    }
}
