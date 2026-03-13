<?php
/* METAL-EXPLAIN: Ce fichier fait une partie du boulot de l'app bibliothèque. 
 * Version simple: ce fichier sert à éviter que tout parte en spaghetti .
 * Lisez les fonctions une par une: chacune fait un mini boulot précis.
 */

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    /**
     * EXPLAIN-FUNC: Affiche la liste des éléments (page liste).
     */
    public function index() { return view('members.index', ['members' => Member::latest()->paginate(10)]); }
    /**
     * EXPLAIN-FUNC: Affiche le formulaire pour créer un nouvel élément.
     */
    public function create() { return view('members.create'); }

    /**
     * EXPLAIN-FUNC: Vérifie les données envoyées puis enregistre en base.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'first_name'=>'required|string|max:255',
            'last_name'=>'required|string|max:255',
            'email'=>'required|email|unique:members,email',
            'phone'=>'nullable|string|max:50',
        ]);
        Member::create($data);
        return redirect()->route('members.index')->with('success','Adhérent créé.');
    }

    /**
     * EXPLAIN-FUNC: Ouvre le formulaire d'édition avec les données existantes.
     */
    public function edit(Member $member) { return view('members.edit', compact('member')); }

    /**
     * EXPLAIN-FUNC: Vérifie les nouvelles données puis met à jour la base.
     */
    public function update(Request $request, Member $member)
    {
        $data = $request->validate([
            'first_name'=>'required|string|max:255',
            'last_name'=>'required|string|max:255',
            'email'=>'required|email|unique:members,email,'.$member->id,
            'phone'=>'nullable|string|max:50',
        ]);
        $member->update($data);
        return redirect()->route('members.index')->with('success','Adhérent mis à jour.');
    }

    /**
     * EXPLAIN-FUNC: Supprime l'élément demandé (ou le marque supprimé).
     */
    public function destroy(Member $member)
    {
        $member->delete();
        return back()->with('success','Adhérent supprimé.');
    }
}

