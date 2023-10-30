<?php

use App\Http\Controllers\ExercisesController;
use Illuminate\Support\Facades\Route;
use Kreait\Laravel\Firebase\Facades\Firebase;

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

Route::prefix('exercises')->group(function () {
    /** Route For All Categories,Sub Category, Programs, Levels & Days **/
    Route::get('/', [ExercisesController::class, 'listAllDataByGivenParams'])->middleware('auth.api.reqs');
    /** Butt Reduce Routes **/
    Route::get('/butt_reduce/{cat_id}', [ExercisesController::class, 'listAllDataButtReduce']);
    /** Neck Workout Routes **/
    Route::get('/neck_workouts', [ExercisesController::class, 'listAllDataNeckWorkout']);
    /** Route For All Categories **/
    Route::get('/category/{cat_id}', [ExercisesController::class, 'listAllDataByCatId']);
    /** Route For Authentication Testing - We Will Implement This In Future **/
    Route::get('test/category/{cat_id}', [ExercisesController::class, 'listAllDataByCatId'])->middleware('auth.api.reqs');
});

Route::prefix('firebase')->group(function () {
    /** For Modifying Firebase Remote Config **/
    // Route::get('/remote_config/insert', [ExercisesController::class, 'fireBaseRemoteConfig']);
    // Route::get('/remote_config/remove', [ExercisesController::class, 'fireBaseRemoteConfigRemove']);
    // Route::get('/remote_config/group', [ExercisesController::class, 'fireBaseRemoteConfigParamGroup']);
});

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
