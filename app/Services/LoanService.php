<?php

namespace App\Services;

use App\Models\Book;
use App\Models\Loan;
use App\Models\Member;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class LoanService
{
    /**
     * Crée un emprunt et met à jour le stock.
     */
    public function createLoan(array $data): Loan
    {
        return DB::transaction(function () use ($data) {
            $user = User::query()->findOrFail($data['user_id']);
            $member = $this->resolveMemberForUser($user);

            $duplicateActiveLoan = Loan::query()
                ->where('book_id', $data['book_id'])
                ->where('user_id', $data['user_id'])
                ->whereNull('returned_at')
                ->exists();

            if ($duplicateActiveLoan) {
                abort(422, 'Cet utilisateur a déjà emprunté ce livre.');
            }

            $book = Book::lockForUpdate()->findOrFail($data['book_id']);

            if ($book->stock_available < 1) {
                abort(422, "Ce livre n'est plus disponible.");
            }

            $loan = Loan::create([
                ...$data,
                'member_id' => $member->id,
            ]);
            $book->decrement('stock_available');

            return $loan;
        });
    }

    public function createLoanForUser(int $bookId, User $user): Loan
    {
        $activeLoan = Loan::query()
            ->where('user_id', $user->id)
            ->where('book_id', $bookId)
            ->whereNull('returned_at')
            ->exists();

        if ($activeLoan) {
            abort(422, 'Vous avez déjà emprunté ce livre.');
        }

        return $this->createLoan([
            'book_id' => $bookId,
            'user_id' => $user->id,
            'loaned_at' => now()->toDateString(),
            'due_at' => now()->addDays(14)->toDateString(),
            'notes' => 'Emprunt utilisateur',
        ]);
    }

    /**
     * Met à jour un emprunt et ajuste le stock si statut retour change.
     */
    public function updateLoan(Loan $loan, array $data): Loan
    {
        return DB::transaction(function () use ($loan, $data) {
            if (isset($data['user_id'])) {
                $user = User::query()->findOrFail($data['user_id']);
                $data['member_id'] = $this->resolveMemberForUser($user)->id;
            }

            $loan->load('book');
            $originalBook = Book::lockForUpdate()->findOrFail($loan->book_id);
            $targetBook = Book::lockForUpdate()->findOrFail($data['book_id']);

            $wasReturned = !is_null($loan->returned_at);
            $isReturned = !empty($data['returned_at']);
            $bookChanged = (int) $loan->book_id !== (int) $data['book_id'];

            if ($bookChanged && !$wasReturned) {
                $originalBook->increment('stock_available');

                if ($targetBook->stock_available < 1) {
                    abort(422, "Le nouveau livre sélectionné n'est plus disponible.");
                }

                $targetBook->decrement('stock_available');
            }

            if (!$wasReturned && $isReturned) {
                $targetBook->increment('stock_available');
            } elseif ($wasReturned && !$isReturned) {
                if ($targetBook->stock_available < 1) {
                    abort(422, "Ce livre n'est plus disponible pour rouvrir l'emprunt.");
                }
                $targetBook->decrement('stock_available');
            }

            $loan->update($data);

            return $loan;
        });
    }

    public function markAsReturned(Loan $loan): Loan
    {
        if ($loan->returned_at) {
            return $loan;
        }

        return DB::transaction(function () use ($loan) {
            $loan->load('book');
            $loan->update(['returned_at' => now()->toDateString()]);
            $loan->book->increment('stock_available');

            return $loan->fresh(['book', 'user']);
        });
    }

    /**
     * Supprime un emprunt. Si non rendu, remet le stock.
     */
    public function deleteLoan(Loan $loan): void
    {
        DB::transaction(function () use ($loan) {
            $loan->load('book');

            if (is_null($loan->returned_at)) {
                $loan->book->increment('stock_available');
            }

            $loan->delete();
        });
    }

    private function resolveMemberForUser(User $user): Member
    {
        [$firstName, $lastName] = $this->splitName($user->name);

        $member = Member::query()->firstOrCreate(
            ['email' => $user->email],
            [
                'first_name' => $firstName,
                'last_name' => $lastName,
                'phone' => null,
                'user_id' => $user->id,
            ]
        );

        if ((int) $member->user_id !== (int) $user->id) {
            $member->update(['user_id' => $user->id]);
        }

        return $member;
    }

    /**
     * Découpe un nom affiché en prénom/nom minimal pour alimenter Member.
     *
     * @return array{0: string, 1: string}
     */
    private function splitName(string $fullName): array
    {
        $parts = preg_split('/\s+/', trim($fullName)) ?: [];
        $parts = array_values(array_filter($parts, fn (string $part) => $part !== ''));

        if ($parts === []) {
            return ['Utilisateur', ''];
        }

        if (count($parts) === 1) {
            return [$parts[0], ''];
        }

        $firstName = array_shift($parts);
        $lastName = implode(' ', $parts);

        return [$firstName, $lastName];
    }
}
