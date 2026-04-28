<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(Request $request, $role = null): View
    {
        return view('auth.login', ['role' => $role]);
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $user = Auth::user();
        $expectedRole = $request->input('role');

        if ($expectedRole && $user->role !== $expectedRole) {
            Auth::logout();
            return back()->withErrors([
                'email' => "Ce compte n'est pas autorisé à accéder à cet espace.",
            ]);
        }

        $request->session()->regenerate();

        // Redirect based on role
        if ($user->role === 'admin') {
            return redirect()->intended(route('admin.dashboard', absolute: false));
        } elseif ($user->role === 'enseignant') {
            return redirect()->intended(route('enseignant.dashboard', absolute: false));
        } elseif ($user->role === 'eleve') {
            return redirect()->intended(route('eleve.dashboard', absolute: false));
        }

        return redirect()->intended(route('dashboard', absolute: false));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
