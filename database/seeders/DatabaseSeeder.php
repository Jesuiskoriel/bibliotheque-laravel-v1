<?php
/* METAL-EXPLAIN: Ce fichier fait une partie du boulot de l'app bibliothèque. 
 * Version simple: ce fichier sert à éviter que tout parte en spaghetti 😄.
 * Lisez les fonctions une par une: chacune fait un mini boulot précis.
 */

namespace Database\Seeders;

use App\Models\Author;
use App\Models\Book;
use App\Models\Category;
use App\Models\Member;
use Illuminate\Database\Seeder;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $roman = Category::create(['name' => 'Roman']);
        $tech = Category::create(['name' => 'Tech']);

        $hugo = Author::create(['name' => 'Victor Hugo']);
        $martin = Author::create(['name' => 'Robert C. Martin']);

        Book::create([
            'title' => 'Les MisÃ©rables',
            'isbn' => '978-0000000001',
            'published_year' => 1862,
            'stock_total' => 5,
            'stock_available' => 5,
            'author_id' => $hugo->id,
            'category_id' => $roman->id,
        ]);

        Book::create([
            'title' => 'Clean Code',
            'isbn' => '978-0000000002',
            'published_year' => 2008,
            'stock_total' => 3,
            'stock_available' => 3,
            'author_id' => $martin->id,
            'category_id' => $tech->id,
        ]);

        Member::create(['first_name' => 'Jean', 'last_name' => 'Dupont', 'email' => 'jean@example.com', 'phone' => '0600000001']);
        Member::create(['first_name' => 'Lina', 'last_name' => 'Martin', 'email' => 'lina@example.com', 'phone' => '0600000002']);

        User::create([
            'name' => 'Admin',
            'email' => 'admin@biblio.local',
            'password' => 'password',
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'Utilisateur Demo',
            'email' => 'user@biblio.local',
            'password' => 'password',
            'role' => 'user',
        ]);
    }
}

