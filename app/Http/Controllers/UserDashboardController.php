<?php
/* Ce fichier fait une partie du boulot de l'app bibliothèque. 
 * Version simple: ce fichier sert à éviter que tout parte en spaghetti .
 * Lisez les fonctions une par une: chacune fait un mini boulot précis.
 */

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Loan;
use Illuminate\Http\Request;

class UserDashboardController extends Controller
{
    /**
     * Cette fonction '__invoke' fait une étape précise du flux applicatif.
     */
    public function __invoke(Request $request)
    {
        $books = Book::with(['author', 'category'])
            ->when($request->filled('q'), function ($query) use ($request) {
                $search = $request->string('q')->trim();

                $query->where(function ($inner) use ($search) {
                    $inner->where('title', 'like', "%{$search}%")
                        ->orWhereHas('author', fn ($author) => $author->where('name', 'like', "%{$search}%"))
                        ->orWhereHas('category', fn ($category) => $category->where('name', 'like', "%{$search}%"));
                });
            })
            ->orderBy('title')
            ->paginate(12)
            ->withQueryString();

        $communityLoans = Loan::with(['book', 'user'])
            ->whereNull('returned_at')
            ->latest('loaned_at')
            ->take(8)
            ->get();

        $myActiveLoans = Loan::with('book')
            ->where('user_id', $request->user()->id)
            ->whereNull('returned_at')
            ->orderBy('due_at')
            ->get();

        $myLoanHistory = Loan::with('book')
            ->where('user_id', $request->user()->id)
            ->latest('loaned_at')
            ->take(10)
            ->get();

        return view('user.dashboard', compact('books', 'communityLoans', 'myActiveLoans', 'myLoanHistory'));
    }
}
