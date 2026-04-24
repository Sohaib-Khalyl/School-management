<?php
use App\Http\Controllers\CoursController;
use App\Http\Controllers\EleveController;
use App\Http\Controllers\EnseignantController;
use App\Http\Controllers\EvaluationController;
use App\Http\Controllers\MatiereController;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\EmploiDuTempsController;
use App\Http\Controllers\ClasseController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware('auth')->group(function () {

    Route::resource('classes', ClasseController::class);
    Route::resource('eleves', EleveController::class);
    Route::resource('enseignants', EnseignantController::class);
    Route::resource('matieres', MatiereController::class);
    Route::resource('cours', CoursController::class);
    Route::resource('notes', NoteController::class);
    Route::resource('evaluations', EvaluationController::class);
    Route::resource('timetable', EmploiDuTempsController::class);

});

require __DIR__.'/auth.php';
