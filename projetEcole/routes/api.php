<?php

use App\Http\Controllers\CoursController;
use App\Http\Controllers\EleveController;
use App\Http\Controllers\EnseignantController;
use App\Http\Controllers\EvaluationController;
use App\Http\Controllers\MatiereController;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\EmploiDuTempsController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
    Route::get('/cours', [CoursController::class, 'index']);
    Route::get('/eleves', [EleveController::class, 'index']);
    Route::get('/enseignants', [EnseignantController::class, 'index']);
    Route::get('/evaluations', [EvaluationController::class, 'index']);
    Route::get('/matieres', [MatiereController::class, 'index']);
    Route::get('/notes', [NoteController::class, 'index']);
    Route::resource('timetable', EmploiDuTempsController::class, ['as' => 'api']);
});
