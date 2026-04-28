<?php

namespace App\Http\Controllers;

use App\Models\Classe;
use App\Models\Eleve;
use App\Models\Enseignant;
use App\Models\Evaluation;
use App\Models\Matiere;
use App\Models\Note;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Admin dashboard — shows global stats.
     */
    public function admin()
    {
        $stats = [
            'eleves' => Eleve::count(),
            'enseignants' => Enseignant::count(),
            'classes' => Classe::count(),
            'matieres' => Matiere::count(),
        ];

        $recentUsers = User::latest()->take(5)->get();
        $classes = Classe::withCount('eleves')->get();

        return view('admin.dashboard', compact('stats', 'recentUsers', 'classes'));
    }

    /**
     * Teacher dashboard — shows their evaluations and classes.
     */
    public function enseignant()
    {
        $user = Auth::user();
        $enseignant = $user->enseignant;

        if (!$enseignant) {
            return view('enseignant.dashboard', [
                'enseignant' => null,
                'classes' => collect(),
            ]);
        }

        // Just fetch all classes for now, or classes they have graded
        $classes = Classe::withCount('eleves')->get();

        return view('enseignant.dashboard', compact('enseignant', 'classes'));
    }

    /**
     * Student dashboard — shows their grades.
     */
    public function eleve()
    {
        $user = Auth::user();
        $eleve = $user->eleve;

        if (!$eleve) {
            return view('eleve.dashboard', ['eleve' => null, 'notes' => collect(), 'moyenneGenerale' => null]);
        }

        $eleve->load('classe');

        // Fetch all subjects
        $matieres = Matiere::orderBy('nom')->get();
        
        // Fetch existing notes for this student
        $existingNotes = Note::where('id_eleve', $eleve->id)->get()->keyBy('matiere_id');

        $displayNotes = [];
        $allFinalGradesFilled = true;
        $sumFinalNotesCoeff = 0;
        $sumCoeff = 0;

        foreach ($matieres as $matiere) {
            $note = $existingNotes->get($matiere->id);
            $cc1 = $note?->cc1;
            $cc2 = $note?->cc2;
            $cc3 = $note?->cc3;

            $finalGrade = null;
            // Final Matière Grade only if all 3 CCs are filled
            if ($cc1 !== null && $cc2 !== null && $cc3 !== null) {
                $finalGrade = round(($cc1 + $cc2 + $cc3) / 3, 2);
                
                $coeff = $matiere->coefficient ?? 1;
                $sumFinalNotesCoeff += $finalGrade * $coeff;
                $sumCoeff += $coeff;
            } else {
                $allFinalGradesFilled = false;
            }

            $displayNotes[] = (object)[
                'matiere' => $matiere,
                'cc1' => $cc1,
                'cc2' => $cc2,
                'cc3' => $cc3,
                'final' => $finalGrade
            ];
        }

        // Moyenne Générale only if all final matiere grades are filled
        $moyenneGenerale = ($allFinalGradesFilled && $sumCoeff > 0) ? round($sumFinalNotesCoeff / $sumCoeff, 2) : null;

        return view('eleve.dashboard', [
            'eleve' => $eleve,
            'notes' => $displayNotes,
            'moyenneGenerale' => $moyenneGenerale
        ]);
    }
}
