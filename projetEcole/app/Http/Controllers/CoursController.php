<?php

namespace App\Http\Controllers;

use App\Models\Cours;
use App\Models\Enseignant;
use App\Models\Matiere;
use Illuminate\Http\Request;

class CoursController extends Controller
{
    public function index()
    {
        $cours = Cours::with('enseignant', 'matiere')->get();
        return view('cours.index', compact('cours'));
    }

    public function create()
    {
        $enseignants = Enseignant::all();
        $matieres = Matiere::all();
        return view('cours.create', compact('enseignants', 'matieres'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_enseignant' => 'required|exists:enseignants,id',
            'id_matiere' => 'required|exists:matieres,id',
        ]);

        Cours::create($request->only(['id_enseignant', 'id_matiere']));
        return redirect('/cours')->with('success', 'Cours créé avec succès');
    }

    public function edit($id)
    {
        $cours = Cours::findOrFail($id);
        $enseignants = Enseignant::all();
        $matieres = Matiere::all();
        return view('cours.edit', compact('cours', 'enseignants', 'matieres'));
    }

    public function update(Request $request, $id)
    {
        $cours = Cours::findOrFail($id);
        $request->validate([
            'id_enseignant' => 'required|exists:enseignants,id',
            'id_matiere' => 'required|exists:matieres,id',
        ]);

        $cours->update($request->only(['id_enseignant', 'id_matiere']));
        return redirect('/cours')->with('success', 'Cours modifié avec succès');
    }

    public function destroy($id)
    {
        Cours::destroy($id);
        return redirect('/cours')->with('success', 'Cours supprimé avec succès');
    }
}
