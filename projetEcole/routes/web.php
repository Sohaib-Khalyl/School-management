<?php

use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StudentProfileController;
use App\Http\Controllers\TeacherController;
use Illuminate\Support\Facades\Route;

// Welcome page
Route::get('/', function () {
    return view('welcome');
});

// Generic dashboard redirect based on role
Route::get('/dashboard', function () {
    $user = auth()->user();
    if ($user->role === 'admin') return redirect()->route('admin.dashboard');
    if ($user->role === 'enseignant') return redirect()->route('enseignant.dashboard');
    if ($user->role === 'eleve') return redirect()->route('eleve.dashboard');
    return redirect('/');
})->middleware(['auth'])->name('dashboard');

// ─── Admin Routes ───
Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'admin'])->name('admin.dashboard');
    Route::get('/users', [AdminUserController::class, 'index'])->name('admin.users');
    Route::post('/users', [AdminUserController::class, 'store'])->name('admin.users.store');
    Route::put('/users/{id}', [AdminUserController::class, 'update'])->name('admin.users.update');
    Route::delete('/users/{id}', [AdminUserController::class, 'destroy'])->name('admin.users.destroy');
    
    // Classes Control
    Route::get('/classes', [App\Http\Controllers\AdminClasseController::class, 'index'])->name('admin.classes');
    Route::post('/classes', [App\Http\Controllers\AdminClasseController::class, 'store'])->name('admin.classes.store');
    Route::put('/classes/{id}', [App\Http\Controllers\AdminClasseController::class, 'update'])->name('admin.classes.update');
    Route::delete('/classes/{id}', [App\Http\Controllers\AdminClasseController::class, 'destroy'])->name('admin.classes.destroy');
    Route::post('/classes/{id}/students', [App\Http\Controllers\AdminClasseController::class, 'addStudent'])->name('admin.classes.addStudent');
    
    // Admin School Control
    Route::get('/notes', [App\Http\Controllers\AdminSchoolController::class, 'notes'])->name('admin.notes');
    Route::post('/notes/eleve/{eleve_id}', [App\Http\Controllers\AdminSchoolController::class, 'storeNotes'])->name('admin.notes.store');
    Route::delete('/notes/{id}', [App\Http\Controllers\AdminSchoolController::class, 'destroyNote'])->name('admin.notes.destroy');

    // Matieres Control
    Route::resource('matieres', App\Http\Controllers\MatiereController::class)->names([
        'index' => 'admin.matieres.index',
        'create' => 'admin.matieres.create',
        'store' => 'admin.matieres.store',
        'edit' => 'admin.matieres.edit',
        'update' => 'admin.matieres.update',
        'destroy' => 'admin.matieres.destroy',
    ]);
});

// ─── Teacher Routes ───
Route::middleware(['auth', 'role:enseignant'])->prefix('enseignant')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'enseignant'])->name('enseignant.dashboard');
    Route::get('/classes', [TeacherController::class, 'showClasses'])->name('enseignant.classes');
    Route::get('/classes/{classe_id}/notes', [TeacherController::class, 'showGrades'])->name('enseignant.grades');
    Route::post('/classes/{classe_id}/notes', [TeacherController::class, 'storeGrades'])->name('enseignant.grades.store');
});

// ─── Student Routes ───
Route::middleware(['auth', 'role:eleve'])->prefix('eleve')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'eleve'])->name('eleve.dashboard');
    Route::get('/profile', [StudentProfileController::class, 'edit'])->name('eleve.profile');
    Route::put('/profile', [StudentProfileController::class, 'update'])->name('eleve.profile.update');
});

// ─── Shared Profile (Breeze default) ───
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
