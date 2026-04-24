<?php

namespace App\Http\Controllers;

use App\Models\EmploiDuTemps;
use App\Models\Classe;
use App\Models\Matiere;
use App\Models\Enseignant;
use Illuminate\Http\Request;

class EmploiDuTempsController extends Controller
{
    /**
     * Display a listing of the timetable.
     */
    public function index(Request $request)
    {
        $query = Classe::with(['emploisDuTemps.matiere', 'emploisDuTemps.enseignant']);

        // Filter by classe if provided
        if ($request->filled('classe_id')) {
            $query->where('id', $request->classe_id);
        }

        $classes = $query->orderBy('nom')->get();
        $allClasses = Classe::orderBy('nom')->pluck('nom', 'id');
        $selectedClasseId = $request->classe_id;

        return view('timetable.index', compact('classes', 'allClasses', 'selectedClasseId'));
    }

    /**
     * Show the form for creating a new timetable entry.
     */
    public function create()
    {
        $classes = Classe::orderBy('nom')->get();
        $matieres = Matiere::orderBy('nom')->get();
        $enseignants = Enseignant::orderBy('nom')->get();
        $jours = ['lundi', 'mardi', 'mercredi', 'jeudi', 'vendredi', 'samedi'];

        return view('timetable.create', compact('classes', 'matieres', 'enseignants', 'jours'));
    }

    /**
     * Store a newly created timetable entry in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'classe_id' => 'required|exists:classes,id',
            'jour' => 'required|in:lundi,mardi,mercredi,jeudi,vendredi,samedi',
            'heure_debut' => 'required|date_format:H:i',
            'heure_fin' => 'required|date_format:H:i|after:heure_debut',
            'matiere_id' => 'required|exists:matieres,id',
            'enseignant_id' => 'required|exists:enseignants,id',
            'salle' => 'nullable|string|max:50',
        ]);

        // Check for overlapping time slots
        if (EmploiDuTemps::hasOverlap(
            $validated['classe_id'],
            $validated['jour'],
            $validated['heure_debut'],
            $validated['heure_fin']
        )) {
            return back()
                ->withInput()
                ->with('error', 'There is already a course at this time for this class.');
        }

        EmploiDuTemps::create($validated);

        return redirect()
            ->route('timetable.index')
            ->with('success', 'Timetable entry created successfully.');
    }

    /**
     * Show the form for editing the specified timetable entry.
     */
    public function edit(EmploiDuTemps $emploiDuTemp)
    {
        $classes = Classe::orderBy('nom')->get();
        $matieres = Matiere::orderBy('nom')->get();
        $enseignants = Enseignant::orderBy('nom')->get();
        $jours = ['lundi', 'mardi', 'mercredi', 'jeudi', 'vendredi', 'samedi'];

        return view('timetable.edit', compact('emploiDuTemp', 'classes', 'matieres', 'enseignants', 'jours'));
    }

    /**
     * Update the specified timetable entry in storage.
     */
    public function update(Request $request, EmploiDuTemps $emploiDuTemp)
    {
        $validated = $request->validate([
            'classe_id' => 'required|exists:classes,id',
            'jour' => 'required|in:lundi,mardi,mercredi,jeudi,vendredi,samedi',
            'heure_debut' => 'required|date_format:H:i',
            'heure_fin' => 'required|date_format:H:i|after:heure_debut',
            'matiere_id' => 'required|exists:matieres,id',
            'enseignant_id' => 'required|exists:enseignants,id',
            'salle' => 'nullable|string|max:50',
        ]);

        // Check for overlapping time slots (excluding current entry)
        if (EmploiDuTemps::hasOverlap(
            $validated['classe_id'],
            $validated['jour'],
            $validated['heure_debut'],
            $validated['heure_fin'],
            $emploiDuTemp->id
        )) {
            return back()
                ->withInput()
                ->with('error', 'There is already a course at this time for this class.');
        }

        $emploiDuTemp->update($validated);

        return redirect()
            ->route('timetable.index')
            ->with('success', 'Timetable entry updated successfully.');
    }

    /**
     * Remove the specified timetable entry from storage.
     */
    public function destroy(EmploiDuTemps $emploiDuTemp)
    {
        $emploiDuTemp->delete();

        return redirect()
            ->route('timetable.index')
            ->with('success', 'Timetable entry deleted successfully.');
    }
}
