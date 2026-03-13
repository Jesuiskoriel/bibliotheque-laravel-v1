<?php
/* Ce fichier fait une partie du boulot de l'app bibliothèque. 
 * Version simple: ce fichier sert à éviter que tout parte en spaghetti .
 * Lisez les fonctions une par une: chacune fait un mini boulot précis.
 */

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Affiche la liste des éléments (page liste).
     */
    public function index() { return view('categories.index', ['categories' => Category::latest()->paginate(10)]); }
    /**
     * Affiche le formulaire pour créer un nouvel élément.
     */
    public function create() { return view('categories.create'); }

    /**
     * Vérifie les données envoyées puis enregistre en base.
     */
    public function store(Request $request)
    {
        $data = $request->validate(['name'=>'required|string|max:255|unique:categories,name','description'=>'nullable|string']);
        Category::create($data);
        return redirect()->route('categories.index')->with('success','Catégorie créée.');
    }

    /**
     * Ouvre le formulaire d'édition avec les données existantes.
     */
    public function edit(Category $category) { return view('categories.edit', compact('category')); }

    /**
     * Vérifie les nouvelles données puis met à jour la base.
     */
    public function update(Request $request, Category $category)
    {
        $data = $request->validate(['name'=>'required|string|max:255|unique:categories,name,'.$category->id,'description'=>'nullable|string']);
        $category->update($data);
        return redirect()->route('categories.index')->with('success','Catégorie mise à jour.');
    }

    /**
     * Supprime l'élément demandé (ou le marque supprimé).
     */
    public function destroy(Category $category)
    {
        $category->delete();
        return back()->with('success','Catégorie supprimée.');
    }
}

