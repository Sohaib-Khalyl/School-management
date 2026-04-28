<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentProfileController extends Controller
{
    /**
     * Show the student profile edit form.
     */
    public function edit()
    {
        $user = Auth::user();
        $eleve = $user->eleve;

        return view('eleve.profile', compact('user', 'eleve'));
    }

    /**
     * Update student personal info.
     */
    public function update(Request $request)
    {
        $user = Auth::user();
        $eleve = $user->eleve;

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        if ($eleve) {
            // Split name for eleve record
            $parts = explode(' ', $request->name, 2);
            $eleve->update([
                'prenom' => $parts[0],
                'nom' => $parts[1] ?? $parts[0],
                'email' => $request->email,
            ]);
        }

        return back()->with('success', 'Profil mis à jour avec succès.');
    }
}
