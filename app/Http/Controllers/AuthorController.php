<?php
/* Ce fichier fait une partie du boulot de l'app bibliothèque. 
 * Version simple: ce fichier sert à éviter que tout parte en spaghetti .
 * Lisez les fonctions une par une: chacune fait un mini boulot précis.
 */

namespace App\Http\Controllers;

use App\Models\Author;
use Illuminate\Http\Request;

class AuthorController extends Controller
{
    /**
     * Affiche la liste des éléments (page liste).
     */
    public function index() { return view('authors.index', ['authors' => Author::latest()->paginate(10)]); }
    /**
     * Affiche le formulaire pour créer un nouvel élément.
     */
    public function create() { return view('authors.create'); }

    /**
     * Vérifie les données envoyées puis enregistre en base.
     */
    public function store(Request $request)
    {
        $data = $request->validate(['name'=>'required|string|max:255','bio'=>'nullable|string']);
        Author::create($data);
        return redirect()->route('authors.index')->with('success','Auteur créé.');
    }

    /**
     * Ouvre le formulaire d'édition avec les données existantes.
     */
    public function edit(Author $author) { return view('authors.edit', compact('author')); }

    /**
     * Vérifie les nouvelles données puis met à jour la base.
     */
    public function update(Request $request, Author $author)
    {
        $data = $request->validate(['name'=>'required|string|max:255','bio'=>'nullable|string']);
        $author->update($data);
        return redirect()->route('authors.index')->with('success','Auteur mis à jour.');
    }

    /**
     * Supprime l'élément demandé (ou le marque supprimé).
     */
    public function destroy(Author $author)
    {
        $author->delete();
        return back()->with('success','Auteur supprimé.');
    }
}

