<?php

namespace App\Http\Controllers;

use App\Models\Classe;
use Illuminate\Http\Request;

class AdminClasseController extends Controller
{
    /**
     * Display a listing of classes.
     */
    public function index()
    {
        $classes = Classe::withCount('eleves')->orderBy('nom')->get();
        $eleves = \App\Models\Eleve::with('classe')->orderBy('nom')->orderBy('prenom')->get();
        return view('admin.classes', compact('classes', 'eleves'));
    }

    /**
     * Store a newly created class.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255|unique:classes,nom',
        ]);

        Classe::create($request->only('nom'));

        return redirect()->route('admin.classes')->with('success', 'Classe créée avec succès.');
    }

    /**
     * Update the specified class.
     */
    public function update(Request $request, $id)
    {
        $classe = Classe::findOrFail($id);

        $request->validate([
            'nom' => 'required|string|max:255|unique:classes,nom,' . $classe->id,
        ]);

        $classe->update($request->only('nom'));

        return redirect()->route('admin.classes')->with('success', 'Classe modifiée avec succès.');
    }

    /**
     * Remove the specified class.
     */
    public function destroy($id)
    {
        $classe = Classe::findOrFail($id);

        if ($classe->eleves()->count() > 0) {
            return back()->with('error', 'Impossible de supprimer cette classe car elle contient des élèves.');
        }

        $classe->delete();

        return redirect()->route('admin.classes')->with('success', 'Classe supprimée avec succès.');
    }

    /**
     * Add a student to a class.
     */
    public function addStudent(Request $request, $id)
    {
        $request->validate([
            'eleve_id' => 'required|exists:eleves,id'
        ]);

        $eleve = \App\Models\Eleve::findOrFail($request->eleve_id);
        $eleve->classe_id = $id;
        $eleve->save();

        return redirect()->route('admin.classes')->with('success', 'Élève ajouté à la classe avec succès.');
    }
}
