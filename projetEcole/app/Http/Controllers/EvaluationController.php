<?php

namespace App\Http\Controllers;

use App\Models\Evaluation;
use App\Models\Matiere;
use Illuminate\Http\Request;

class EvaluationController extends Controller
{
    public function index()
    {
        $evaluations = Evaluation::with('matiere')->get();
        return view('evaluations.index', compact('evaluations'));
    }

    public function create()
    {
        $matieres = Matiere::all();
        return view('evaluations.create', compact('matieres'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_matiere' => 'required|exists:matieres,id',
            'type' => 'required|string|max:255',
        ]);

        Evaluation::create($request->only(['id_matiere', 'type']));
        return redirect('/evaluations')->with('success', 'Évaluation créée avec succès');
    }

    public function edit($id)
    {
        $evaluation = Evaluation::findOrFail($id);
        $matieres = Matiere::all();
        return view('evaluations.edit', compact('evaluation', 'matieres'));
    }

    public function update(Request $request, $id)
    {
        $evaluation = Evaluation::findOrFail($id);
        $request->validate([
            'id_matiere' => 'required|exists:matieres,id',
            'type' => 'required|string|max:255',
        ]);

        $evaluation->update($request->only(['id_matiere', 'type']));
        return redirect('/evaluations')->with('success', 'Évaluation modifiée avec succès');
    }

    public function destroy($id)
    {
        Evaluation::destroy($id);
        return redirect('/evaluations')->with('success', 'Évaluation supprimée avec succès');
    }
}
