<?php

namespace App\Http\Controllers;

use App\Models\Note;
use App\Models\Classe;
use App\Models\Eleve;
use App\Models\Matiere;
use Illuminate\Http\Request;

class AdminSchoolController extends Controller
{
    /**
     * List all notes for admin (hierarchical view with all matieres).
     */
    public function notes(Request $request)
    {
        $classes = Classe::orderBy('nom')->get();
        $eleves = collect();
        $matieres = collect();
        $notes = collect();
        $selectedClasse = null;
        $selectedEleve = null;

        if ($request->has('classe_id') && $request->classe_id) {
            $selectedClasse = Classe::find($request->classe_id);
            if ($selectedClasse) {
                $eleves = Eleve::where('classe_id', $selectedClasse->id)->orderBy('nom')->get();
            }
        }

        if ($request->has('eleve_id') && $request->eleve_id) {
            $selectedEleve = Eleve::find($request->eleve_id);
            if ($selectedEleve) {
                $matieres = Matiere::orderBy('nom')->get();
                $notes = Note::where('id_eleve', $selectedEleve->id)->get()->keyBy('matiere_id');
            }
        }

        return view('admin.notes', compact('classes', 'eleves', 'matieres', 'notes', 'selectedClasse', 'selectedEleve'));
    }

    /**
     * Bulk save CC1, CC2, CC3 grades for a student.
     */
    public function storeNotes(Request $request, $eleveId)
    {
        $request->validate([
            'notes' => 'required|array',
            'notes.*.cc1' => 'nullable|numeric|min:0|max:20',
            'notes.*.cc2' => 'nullable|numeric|min:0|max:20',
            'notes.*.cc3' => 'nullable|numeric|min:0|max:20',
        ]);

        foreach ($request->notes as $matiereId => $grades) {
            $cc1 = $grades['cc1'] ?? null;
            $cc2 = $grades['cc2'] ?? null;
            $cc3 = $grades['cc3'] ?? null;

            Note::updateOrCreate(
                [
                    'id_eleve' => $eleveId,
                    'matiere_id' => $matiereId,
                ],
                [
                    'cc1' => $cc1,
                    'cc2' => $cc2,
                    'cc3' => $cc3,
                ]
            );
        }

        return back()->with('success', 'Notes enregistrées avec succès.');
    }

    /**
     * Delete a note.
     */
    public function destroyNote($id)
    {
        Note::findOrFail($id)->delete();
        return back()->with('success', 'Note supprimée avec succès.');
    }
}
