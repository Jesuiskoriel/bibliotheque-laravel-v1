<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Loan;

class UserDashboardController extends Controller
{
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
