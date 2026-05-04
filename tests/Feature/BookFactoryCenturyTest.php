<?php

namespace Tests\Feature;

use App\Models\Book;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookFactoryCenturyTest extends TestCase
{
    use RefreshDatabase;

    public function test_generated_books_are_from_fifteenth_century(): void
    {
        $books = Book::factory()->count(30)->create();

        $allInRange = $books->every(
            fn (Book $book) => $book->published_year >= 1401 && $book->published_year <= 1500
        );

        $this->assertTrue($allInRange);
    }
}
