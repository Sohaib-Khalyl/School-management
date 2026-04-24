<?php

namespace App\Http\Controllers;

use App\Models\Matiere;
use Illuminate\Http\Request;

class MatiereController extends Controller
{
    public function index()
    {
        $matieres = Matiere::all();
        return view('matieres.index', compact('matieres'));
    }

    public function create()
    {
        return view('matieres.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
        ]);

        Matiere::create($request->only(['nom']));
        return redirect('/matieres')->with('success', 'Matière créée avec succès');
    }

    public function edit($id)
    {
        $matiere = Matiere::findOrFail($id);
        return view('matieres.edit', compact('matiere'));
    }

    public function update(Request $request, $id)
    {
        $matiere = Matiere::findOrFail($id);
        $request->validate([
            'nom' => 'required|string|max:255',
        ]);

        $matiere->update($request->only(['nom']));
        return redirect('/matieres')->with('success', 'Matière modifiée avec succès');
    }

    public function destroy($id)
    {
        Matiere::destroy($id);
        return redirect('/matieres')->with('success', 'Matière supprimée avec succès');
    }
}
