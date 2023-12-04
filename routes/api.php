<?php

use App\Http\Controllers\ExercisesController;
use App\Http\Controllers\FocusedAreasController;
use App\Http\Controllers\CacheController;
use App\Http\Controllers\WorkoutsController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::prefix('focused_areas')->group(function () {
    Route::get('/', [FocusedAreasController::class, 'list']);
});

Route::prefix('workouts')->group(function () {
    Route::post('/', [WorkoutsController::class, 'list']);
});

Route::prefix('exercises')->middleware('auth.api.reqs')->group(function () {
    /** Route For All Categories,Sub Category, Programs, Levels & Days **/
    Route::get('/', [ExercisesController::class, 'list']);
    // /** Butt Reduce Routes **/
    // Route::get('/butt_reduce/{cat_id}', [ExercisesController::class, 'listAllDataButtReduce']);
    // /** Neck Workout Routes **/
    // Route::get('/neck_workouts', [ExercisesController::class, 'listAllDataNeckWorkout']);
    // /** Route For All Categories **/
    // Route::get('/category/{cat_id}', [ExercisesController::class, 'listAllDataByCatId']);
});

Route::get('cache/destroy', [CacheController::class, 'destroy']);

// fallback for 404 URL's
Route::fallback(function () {
    return response()->json(
        [
            'data' => [],
            'success' => 0,
            'message' => 'Invalid Route, No API found against this URL. In case if you have declared a new route but still it\'s NOT FOUND then please reset the route cache of your application.'
        ],
        404
    );
});
