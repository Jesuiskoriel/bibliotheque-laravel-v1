<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    public function index() { return view('members.index', ['members' => Member::latest()->paginate(10)]); }
    public function create() { return view('members.create'); }

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

    public function edit(Member $member) { return view('members.edit', compact('member')); }

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

    public function destroy(Member $member)
    {
        $member->delete();
        return back()->with('success','Adhérent supprimé.');
    }
}
