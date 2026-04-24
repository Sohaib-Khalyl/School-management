<?php

namespace App\Http\Controllers;

use App\Models\Classe;
use Illuminate\Http\Request;

class ClasseController extends Controller
{
    /**
     * Display a listing of all classes.
     */
    public function index()
    {
        $classes = Classe::withCount('eleves')
            ->withCount('emploisDuTemps')
            ->orderBy('nom')
            ->get();

        return view('classes.index', compact('classes'));
    }

    /**
     * Show the form for creating a new class.
     */
    public function create()
    {
        return view('classes.create');
    }

    /**
     * Store a newly created class in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|string|unique:classes,nom|max:50',
        ]);

        Classe::create($validated);

        return redirect()
            ->route('classes.index')
            ->with('success', 'Class created successfully.');
    }

    /**
     * Show the form for editing the specified class.
     */
    public function edit(Classe $classe)
    {
        return view('classes.edit', compact('classe'));
    }

    /**
     * Update the specified class in storage.
     */
    public function update(Request $request, Classe $classe)
    {
        $validated = $request->validate([
            'nom' => 'required|string|unique:classes,nom,' . $classe->id . '|max:50',
        ]);

        $classe->update($validated);

        return redirect()
            ->route('classes.index')
            ->with('success', 'Class updated successfully.');
    }

    /**
     * Remove the specified class from storage.
     */
    public function destroy(Classe $classe)
    {
        if ($classe->eleves()->exists()) {
            return back()->with('error', 'Cannot delete a class that has students.');
        }

        $classe->delete();

        return redirect()
            ->route('classes.index')
            ->with('success', 'Class deleted successfully.');
    }
}
