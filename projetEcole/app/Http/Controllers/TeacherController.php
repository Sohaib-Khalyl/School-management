<?php

namespace App\Http\Controllers;

use App\Models\Classe;
use App\Models\Note;
use App\Models\Eleve;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TeacherController extends Controller
{
    /**
     * Show the classes the teacher can grade.
     */
    public function showClasses()
    {
        $enseignant = Auth::user()->enseignant;
        if (!$enseignant || !$enseignant->matiere_id) {
            return view('enseignant.classes', ['classes' => collect(), 'enseignant' => $enseignant]);
        }

        // For simplicity, we assume a teacher can grade any class
        $classes = Classe::withCount('eleves')->orderBy('nom')->get();

        return view('enseignant.classes', compact('classes', 'enseignant'));
    }

    /**
     * Show the grade entry table for a specific class (CC1, CC2, CC3).
     */
    public function showGrades($classeId)
    {
        $enseignant = Auth::user()->enseignant;
        if (!$enseignant || !$enseignant->matiere_id) abort(403);

        $classe = Classe::with('eleves')->findOrFail($classeId);
        $matiereId = $enseignant->matiere_id;

        // Fetch existing notes for this class and this subject
        $elevesIds = $classe->eleves->pluck('id');
        $notes = Note::whereIn('id_eleve', $elevesIds)
            ->where('matiere_id', $matiereId)
            ->get()
            ->keyBy('id_eleve');

        return view('enseignant.grades', compact('classe', 'enseignant', 'notes'));
    }

    /**
     * Bulk save CC1, CC2, CC3 grades for a class.
     */
    public function storeGrades(Request $request, $classeId)
    {
        $enseignant = Auth::user()->enseignant;
        if (!$enseignant || !$enseignant->matiere_id) abort(403);

        $classe = Classe::findOrFail($classeId);
        $matiereId = $enseignant->matiere_id;

        $request->validate([
            'notes' => 'required|array',
            'notes.*.cc1' => 'nullable|numeric|min:0|max:20',
            'notes.*.cc2' => 'nullable|numeric|min:0|max:20',
            'notes.*.cc3' => 'nullable|numeric|min:0|max:20',
        ]);

        foreach ($request->notes as $eleveId => $grades) {
            $cc1 = $grades['cc1'] ?? null;
            $cc2 = $grades['cc2'] ?? null;
            $cc3 = $grades['cc3'] ?? null;

            if ($cc1 === null && $cc2 === null && $cc3 === null) {
                // If all are null, maybe don't create/update, or keep it empty
                continue;
            }

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
}
