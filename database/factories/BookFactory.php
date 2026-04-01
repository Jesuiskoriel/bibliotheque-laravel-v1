<?php

namespace Database\Factories;

use App\Models\Author;
use App\Models\Book;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Book>
 */
class BookFactory extends Factory
{
    protected $model = Book::class;

    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $stockTotal = fake()->numberBetween(1, 12);
        $currentYear = (int) date('Y');

        return [
            'title' => ucfirst(fake()->words(fake()->numberBetween(2, 5), true)),
            'isbn' => fake()->unique()->numerify('978##########'),
            'published_year' => fake()->numberBetween(1900, $currentYear),
            'stock_total' => $stockTotal,
            'stock_available' => fake()->numberBetween(0, $stockTotal),
            'author_id' => Author::query()->inRandomOrder()->value('id') ?? Author::factory(),
            'category_id' => Category::query()->inRandomOrder()->value('id') ?? Category::factory(),
        ];
    }
}
