<?php
/* METAL-EXPLAIN: Ce fichier fait une partie du boulot de l'app bibliothèque. 
 * Version simple: ce fichier sert à éviter que tout parte en spaghetti 😄.
 * Lisez les fonctions une par une: chacune fait un mini boulot précis.
 */

namespace App\Http\Controllers;

use App\Models\Author;
use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;

class BookController extends Controller
{
    /**
     * EXPLAIN-FUNC: Affiche la liste des éléments (page liste).
     */
    public function index()
    {
        $books = Book::with(['author','category'])->latest()->paginate(10);
        return view('books.index', compact('books'));
    }

    /**
     * EXPLAIN-FUNC: Affiche le formulaire pour créer un nouvel élément.
     */
    public function create()
    {
        return view('books.create', [
            'authors' => Author::orderBy('name')->get(),
            'categories' => Category::orderBy('name')->get(),
        ]);
    }

    /**
     * EXPLAIN-FUNC: Vérifie les données envoyées puis enregistre en base.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'title'=>'required|string|max:255',
            'isbn'=>'required|string|max:100|unique:books,isbn',
            'published_year'=>'nullable|integer|min:1500|max:'.date('Y'),
            'stock_total'=>'required|integer|min:1',
            'author_id'=>'required|exists:authors,id',
            'category_id'=>'required|exists:categories,id',
        ]);
        $data['stock_available'] = $data['stock_total'];
        Book::create($data);
        return redirect()->route('books.index')->with('success','Livre créé.');
    }

    /**
     * EXPLAIN-FUNC: Ouvre le formulaire d'édition avec les données existantes.
     */
    public function edit(Book $book)
    {
        return view('books.edit', [
            'book'=>$book,
            'authors'=>Author::orderBy('name')->get(),
            'categories'=>Category::orderBy('name')->get(),
        ]);
    }

    /**
     * EXPLAIN-FUNC: Vérifie les nouvelles données puis met à jour la base.
     */
    public function update(Request $request, Book $book)
    {
        $data = $request->validate([
            'title'=>'required|string|max:255',
            'isbn'=>'required|string|max:100|unique:books,isbn,'.$book->id,
            'published_year'=>'nullable|integer|min:1500|max:'.date('Y'),
            'stock_total'=>'required|integer|min:1',
            'author_id'=>'required|exists:authors,id',
            'category_id'=>'required|exists:categories,id',
        ]);
        $delta = $data['stock_total'] - $book->stock_total;
        $data['stock_available'] = max(0, $book->stock_available + $delta);
        $book->update($data);
        return redirect()->route('books.index')->with('success','Livre mis à jour.');
    }

    /**
     * EXPLAIN-FUNC: Supprime l'élément demandé (ou le marque supprimé).
     */
    public function destroy(Book $book)
    {
        $book->delete();
        return back()->with('success','Livre supprimé.');
    }
}

