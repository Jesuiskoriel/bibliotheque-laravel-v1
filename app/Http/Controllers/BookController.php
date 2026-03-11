<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index()
    {
        $books = Book::with(['author','category'])->latest()->paginate(10);
        return view('books.index', compact('books'));
    }

    public function create()
    {
        return view('books.create', [
            'authors' => Author::orderBy('name')->get(),
            'categories' => Category::orderBy('name')->get(),
        ]);
    }

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

    public function edit(Book $book)
    {
        return view('books.edit', [
            'book'=>$book,
            'authors'=>Author::orderBy('name')->get(),
            'categories'=>Category::orderBy('name')->get(),
        ]);
    }

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

    public function destroy(Book $book)
    {
        $book->delete();
        return back()->with('success','Livre supprimé.');
    }
}
