<?php
/* METAL-EXPLAIN: Ce fichier fait une partie du boulot de l'app bibliothèque. 
 * Version simple: ce fichier sert à éviter que tout parte en spaghetti .
 * Lisez les fonctions une par une: chacune fait un mini boulot précis.
 */

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Loan;
use App\Models\Member;

class DashboardController extends Controller
{
    /**
     * EXPLAIN-FUNC: Cette fonction '__invoke' fait une étape précise du flux applicatif.
     */
    public function __invoke()
    {
        $stats = [
            'books' => Book::count(),
            'members' => Member::count(),
            'active_loans' => Loan::whereNull('returned_at')->count(),
            'overdue_loans' => Loan::whereNull('returned_at')->whereDate('due_at', '<', now())->count(),
        ];

        $recentLoans = Loan::with(['book', 'member'])
            ->latest('loaned_at')
            ->take(8)
            ->get();

        return view('dashboard', compact('stats', 'recentLoans'));
    }
}

