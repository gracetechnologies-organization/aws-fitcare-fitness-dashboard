<?php

use App\Http\Livewire\Employee\Dashboard;
use App\Http\Livewire\Employee\ManageActiveExercises;
use App\Http\Livewire\Employee\ManageArchivedExercises;
use App\Http\Livewire\Employee\ManageCategories;
use App\Http\Livewire\Employee\ManageLevels;
use App\Http\Livewire\Employee\ManagePrograms;
use App\Http\Livewire\Employee\ManageWeeks;
use App\Http\Livewire\Employee\ManageFocusedAreas;
use App\Http\Livewire\Employee\ManageWorkouts;
use App\Http\Livewire\Employee\Profile;

Route::prefix('emp')->middleware(['emp.guard', 'check.emp.activation'])->group(function () {
    Route::get('/dashboard', Dashboard::class)->name('emp.index');
    Route::get('/categories', ManageCategories::class)->name('emp.categories');
    Route::get('/levels', ManageLevels::class)->name('emp.levels');
    Route::get('/programs', ManagePrograms::class)->name('emp.programs');
    Route::get('/weeks', ManageWeeks::class)->name('emp.weeks');
    Route::get('/focused-areas', ManageFocusedAreas::class)->name('emp.focused_areas');
    Route::get('/workouts', ManageWorkouts::class)->name('emp.workouts');

    Route::get('/exercises/active/{cat_id?}/{sub_cat_id?}/{program_id?}', ManageActiveExercises::class)->name('emp.exercises.active');
    Route::get('/programs/exercises/active/{program_id}', ManageActiveExercises::class)->name('emp.programs.exercises.active');
    Route::get('/exercises/archived', ManageArchivedExercises::class)->name('emp.exercises.archived');
    Route::get('/profile', Profile::class)->name('emp.profile');

    Route::post('/update-employee', function () {
        echo "Under Production :(";
    })->name('emp.update');
    Route::post('/update-password', function () {
        echo "Under Production :(";
    })->name('emp.update_password');
});
