<?php
/* Ce fichier fait une partie du boulot de l'app bibliothèque. 
 * Version simple: ce fichier sert à éviter que tout parte en spaghetti .
 * Lisez les fonctions une par une: chacune fait un mini boulot précis.
 */

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Loan;

class UserDashboardController extends Controller
{
    /**
     * Cette fonction '__invoke' fait une étape précise du flux applicatif.
     */
    public function __invoke()
    {
        $books = Book::with(['author', 'category'])->orderBy('title')->take(12)->get();
        $activeLoans = Loan::with(['book', 'member'])
            ->whereNull('returned_at')
            ->latest('loaned_at')
            ->take(10)
            ->get();

        return view('user.dashboard', compact('books', 'activeLoans'));
    }
}

