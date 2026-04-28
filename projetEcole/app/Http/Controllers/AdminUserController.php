<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Eleve;
use App\Models\Enseignant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AdminUserController extends Controller
{
    /**
     * List all users with search and filter.
     */
    public function index(Request $request)
    {
        $query = User::orderBy('created_at', 'desc');

        // Search by name or email
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Filter by role
        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        $users = $query->paginate(15)->withQueryString();
        return view('admin.users', compact('users'));
    }

    /**
     * Store a new user.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'role' => 'required|in:admin,enseignant,eleve',
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'date_naissance' => 'nullable|date',
            'classe_id' => 'nullable|exists:classes,id',
            'matiere_id' => 'nullable|exists:matieres,id',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        if ($request->role === 'enseignant') {
            Enseignant::create([
                'nom' => $request->nom,
                'prenom' => $request->prenom,
                'email' => $request->email,
                'matiere_id' => $request->matiere_id,
                'user_id' => $user->id,
            ]);
        } elseif ($request->role === 'eleve') {
            Eleve::create([
                'nom' => $request->nom,
                'prenom' => $request->prenom,
                'email' => $request->email,
                'date_naissance' => $request->date_naissance ?? now()->subYears(15),
                'classe_id' => $request->classe_id,
                'user_id' => $user->id,
            ]);
        }

        return redirect()->route('admin.users')->with('success', 'Utilisateur créé avec succès.');
    }

    /**
     * Update a user.
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|min:6',
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        if ($user->role === 'enseignant' && $user->enseignant) {
            $parts = explode(' ', $request->name, 2);
            $user->enseignant->update([
                'prenom' => $parts[0],
                'nom' => $parts[1] ?? $parts[0],
                'email' => $request->email,
                'matiere_id' => $request->has('matiere_id') ? $request->matiere_id : $user->enseignant->matiere_id,
            ]);
        } elseif ($user->role === 'eleve' && $user->eleve) {
            $parts = explode(' ', $request->name, 2);
            $user->eleve->update([
                'prenom' => $parts[0],
                'nom' => $parts[1] ?? $parts[0],
                'email' => $request->email,
                'classe_id' => $request->has('classe_id') ? $request->classe_id : $user->eleve->classe_id,
            ]);
        }

        return redirect()->route('admin.users')->with('success', 'Utilisateur modifié avec succès.');
    }

    /**
     * Delete a user.
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        if ($user->id === Auth::id()) {
            return back()->with('error', 'Vous ne pouvez pas supprimer votre propre compte.');
        }

        $user->delete();
        return redirect()->route('admin.users')->with('success', 'Utilisateur supprimé.');
    }
}
