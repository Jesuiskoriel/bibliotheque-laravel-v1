<?php
/* Ce fichier fait une partie du boulot de l'app bibliothèque. 
 * Version simple: ce fichier sert à éviter que tout parte en spaghetti .
 * Lisez les fonctions une par une: chacune fait un mini boulot précis.
 */

namespace Database\Seeders;

use App\Models\Author;
use App\Models\Book;
use App\Models\Category;
use App\Models\Member;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seeder RUN = injecte des données de démonstration.
     */
    public function run(): void
    {
        $categories = collect([
            ['name' => 'Roman', 'description' => 'Romans classiques et contemporains'],
            ['name' => 'Tech', 'description' => 'Informatique, code et architecture logicielle'],
            ['name' => 'Science-fiction', 'description' => 'Futur, dystopies et exploration spatiale'],
            ['name' => 'Histoire', 'description' => 'Ouvrages historiques et biographies'],
            ['name' => 'Développement personnel', 'description' => 'Habitudes, organisation et motivation'],
        ])->mapWithKeys(function (array $category) {
            $model = Category::updateOrCreate(
                ['name' => $category['name']],
                ['description' => $category['description']]
            );

            return [$model->name => $model];
        });

        $authors = collect([
            ['name' => 'Victor Hugo', 'bio' => 'Auteur majeur du XIXe siècle.'],
            ['name' => 'Robert C. Martin', 'bio' => 'Figure connue du software craftsmanship.'],
            ['name' => 'George Orwell', 'bio' => 'Romancier britannique et critique politique.'],
            ['name' => 'Frank Herbert', 'bio' => 'Auteur de science-fiction.'],
            ['name' => 'Yuval Noah Harari', 'bio' => 'Historien et essayiste.'],
            ['name' => 'James Clear', 'bio' => 'Auteur autour des habitudes et de la performance.'],
            ['name' => 'Antoine de Saint-Exupéry', 'bio' => 'Écrivain et aviateur français.'],
            ['name' => 'Mary Shelley', 'bio' => 'Pionnière du roman gothique et scientifique.'],
            ['name' => 'Martin Fowler', 'bio' => 'Référence sur le design logiciel.'],
            ['name' => 'Cal Newport', 'bio' => 'Auteur sur le travail en profondeur et la concentration.'],
        ])->mapWithKeys(function (array $author) {
            $model = Author::updateOrCreate(
                ['name' => $author['name']],
                ['bio' => $author['bio']]
            );

            return [$model->name => $model];
        });

        $books = [
            ['title' => 'Les Misérables', 'isbn' => '978-0000000001', 'published_year' => 1862, 'stock_total' => 5, 'author' => 'Victor Hugo', 'category' => 'Roman'],
            ['title' => 'Clean Code', 'isbn' => '978-0000000002', 'published_year' => 2008, 'stock_total' => 3, 'author' => 'Robert C. Martin', 'category' => 'Tech'],
            ['title' => '1984', 'isbn' => '978-0000000003', 'published_year' => 1949, 'stock_total' => 4, 'author' => 'George Orwell', 'category' => 'Science-fiction'],
            ['title' => 'Animal Farm', 'isbn' => '978-0000000004', 'published_year' => 1945, 'stock_total' => 4, 'author' => 'George Orwell', 'category' => 'Roman'],
            ['title' => 'Dune', 'isbn' => '978-0000000005', 'published_year' => 1965, 'stock_total' => 6, 'author' => 'Frank Herbert', 'category' => 'Science-fiction'],
            ['title' => 'Sapiens', 'isbn' => '978-0000000006', 'published_year' => 2011, 'stock_total' => 5, 'author' => 'Yuval Noah Harari', 'category' => 'Histoire'],
            ['title' => 'Atomic Habits', 'isbn' => '978-0000000007', 'published_year' => 2018, 'stock_total' => 5, 'author' => 'James Clear', 'category' => 'Développement personnel'],
            ['title' => 'Le Petit Prince', 'isbn' => '978-0000000008', 'published_year' => 1943, 'stock_total' => 7, 'author' => 'Antoine de Saint-Exupéry', 'category' => 'Roman'],
            ['title' => 'Frankenstein', 'isbn' => '978-0000000009', 'published_year' => 1818, 'stock_total' => 4, 'author' => 'Mary Shelley', 'category' => 'Science-fiction'],
            ['title' => 'Refactoring', 'isbn' => '978-0000000010', 'published_year' => 1999, 'stock_total' => 3, 'author' => 'Martin Fowler', 'category' => 'Tech'],
            ['title' => 'Deep Work', 'isbn' => '978-0000000011', 'published_year' => 2016, 'stock_total' => 4, 'author' => 'Cal Newport', 'category' => 'Développement personnel'],
            ['title' => 'Notre-Dame de Paris', 'isbn' => '978-0000000012', 'published_year' => 1831, 'stock_total' => 3, 'author' => 'Victor Hugo', 'category' => 'Roman'],
        ];

        foreach ($books as $book) {
            Book::updateOrCreate(
                ['isbn' => $book['isbn']],
                [
                    'title' => $book['title'],
                    'published_year' => $book['published_year'],
                    'stock_total' => $book['stock_total'],
                    'stock_available' => $book['stock_total'],
                    'author_id' => $authors[$book['author']]->id,
                    'category_id' => $categories[$book['category']]->id,
                ]
            );
        }

        $members = [
            ['first_name' => 'Jean', 'last_name' => 'Dupont', 'email' => 'jean@example.com', 'phone' => '0600000001'],
            ['first_name' => 'Lina', 'last_name' => 'Martin', 'email' => 'lina@example.com', 'phone' => '0600000002'],
            ['first_name' => 'Sarah', 'last_name' => 'Bernard', 'email' => 'sarah.bernard@example.com', 'phone' => '0600000003'],
            ['first_name' => 'Mehdi', 'last_name' => 'Azouzi', 'email' => 'mehdi.azouzi@example.com', 'phone' => '0600000004'],
            ['first_name' => 'Camille', 'last_name' => 'Roux', 'email' => 'camille.roux@example.com', 'phone' => '0600000005'],
            ['first_name' => 'Nora', 'last_name' => 'Bensaid', 'email' => 'nora.bensaid@example.com', 'phone' => '0600000006'],
            ['first_name' => 'Thomas', 'last_name' => 'Leroy', 'email' => 'thomas.leroy@example.com', 'phone' => '0600000007'],
            ['first_name' => 'Inès', 'last_name' => 'Morel', 'email' => 'ines.morel@example.com', 'phone' => '0600000008'],
            ['first_name' => 'Yacine', 'last_name' => 'Amrani', 'email' => 'yacine.amrani@example.com', 'phone' => '0600000009'],
            ['first_name' => 'Emma', 'last_name' => 'Caron', 'email' => 'emma.caron@example.com', 'phone' => '0600000010'],
        ];

        foreach ($members as $member) {
            Member::updateOrCreate(
                ['email' => $member['email']],
                [
                    'first_name' => $member['first_name'],
                    'last_name' => $member['last_name'],
                    'phone' => $member['phone'],
                ]
            );
        }

        User::updateOrCreate(
            ['email' => 'admin@biblio.local'],
            [
                'name' => 'Admin',
                'password' => 'password',
                'role' => 'admin',
            ]
        );

        User::updateOrCreate(
            ['email' => 'user@biblio.local'],
            [
                'name' => 'Utilisateur Demo',
                'password' => 'password',
                'role' => 'user',
            ]
        );
    }
}
