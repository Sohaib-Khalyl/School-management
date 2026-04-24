<?php

namespace App\Http\Controllers;

use App\Models\Eleve;
use App\Models\Classe;
use Illuminate\Http\Request;

class EleveController extends Controller
{
    function index()
    {
        $eleves = Eleve::with('classe')->orderBy('nom')->get();
        return view('eleves.index', compact('eleves'));
    }

    public function create()
    {
        $classes = Classe::orderBy('nom')->get();
        return view('eleves.create', compact('classes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'date_naissance' => 'required|date',
            'email' => 'required|email|unique:eleves,email',
            'classe_id' => 'nullable|exists:classes,id',
        ]);

        Eleve::create($request->only(['nom', 'prenom', 'date_naissance', 'email', 'classe_id']));
        return redirect('/eleves')->with('success', 'Élève créé avec succès');
    }

    public function edit($id)
    {
        $eleve = Eleve::findOrFail($id);
        $classes = Classe::orderBy('nom')->get();
        return view('eleves.edit', compact('eleve', 'classes'));
    }

    public function update(Request $request, $id)
    {
        $eleve = Eleve::findOrFail($id);
        $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'date_naissance' => 'required|date',
            'email' => 'required|email|unique:eleves,email,' . $eleve->id,
            'classe_id' => 'nullable|exists:classes,id',
        ]);

        $eleve->update($request->only(['nom', 'prenom', 'date_naissance', 'email', 'classe_id']));
        return redirect('/eleves')->with('success', 'Élève modifié avec succès');
    }

    public function destroy($id)
    {
        Eleve::destroy($id);
        return redirect('/eleves');
    }
}
