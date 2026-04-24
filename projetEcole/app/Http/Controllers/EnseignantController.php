<?php

namespace App\Http\Controllers;

use App\Models\Enseignant;
use Illuminate\Http\Request;

class EnseignantController extends Controller
{
    public function index()
    {
        $enseignants = Enseignant::all();
        return view('enseignants.index', compact('enseignants'));
    }

    public function create()
    {
        return view('enseignants.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|email|unique:enseignants,email',
        ]);

        Enseignant::create($request->only(['nom', 'prenom', 'email']));
        return redirect('/enseignants')->with('success', 'Enseignant créé avec succès');
    }

    public function edit($id)
    {
        $enseignant = Enseignant::findOrFail($id);
        return view('enseignants.edit', compact('enseignant'));
    }

    public function update(Request $request, $id)
    {
        $enseignant = Enseignant::findOrFail($id);
        $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|email|unique:enseignants,email,' . $enseignant->id,
        ]);

        $enseignant->update($request->only(['nom', 'prenom', 'email']));
        return redirect('/enseignants')->with('success', 'Enseignant modifié avec succès');
    }

    public function destroy($id)
    {
        Enseignant::destroy($id);
        return redirect('/enseignants')->with('success', 'Enseignant supprimé avec succès');
    }
}
