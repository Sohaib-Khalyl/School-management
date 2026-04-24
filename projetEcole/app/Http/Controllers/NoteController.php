<?php

namespace App\Http\Controllers;

use App\Models\Note;
use App\Models\Eleve;
use App\Models\Evaluation;
use Illuminate\Http\Request;

class NoteController extends Controller
{
    public function index()
    {
        $notes = Note::with('eleve', 'evaluation')->get();
        return view('notes.index', compact('notes'));
    }

    public function create()
    {
        $eleves = Eleve::all();
        $evaluations = Evaluation::all();
        return view('notes.create', compact('eleves', 'evaluations'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_eleve' => 'required|exists:eleves,id',
            'id_evaluation' => 'required|exists:evaluations,id',
        ]);

        Note::create($request->only(['id_eleve', 'id_evaluation']));
        return redirect('/notes')->with('success', 'Note créée avec succès');
    }

    public function edit($id)
    {
        $note = Note::findOrFail($id);
        $eleves = Eleve::all();
        $evaluations = Evaluation::all();
        return view('notes.edit', compact('note', 'eleves', 'evaluations'));
    }

    public function update(Request $request, $id)
    {
        $note = Note::findOrFail($id);
        $request->validate([
            'id_eleve' => 'required|exists:eleves,id',
            'id_evaluation' => 'required|exists:evaluations,id',
        ]);

        $note->update($request->only(['id_eleve', 'id_evaluation']));
        return redirect('/notes')->with('success', 'Note modifiée avec succès');
    }

    public function destroy($id)
    {
        Note::destroy($id);
        return redirect('/notes')->with('success', 'Note supprimée avec succès');
    }
}
