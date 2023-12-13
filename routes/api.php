<?php

use App\Http\Controllers\Api\CustomUserAuthSystem\ForgotPasswordController;
use App\Http\Controllers\Api\CustomUserAuthSystem\LoginController;
use App\Http\Controllers\Api\CustomUserAuthSystem\RegisterController;
use App\Http\Controllers\Api\CustomUserAuthSystem\ResetPasswordController;
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
Route::prefix('custom/auth')->group(function () {
    Route::post('/register', [RegisterController::class, 'register']);
    Route::post('/login', [LoginController::class, 'login']);
    Route::post('/forgot-password/send/email', [ForgotPasswordController::class, 'sendForgotPasswordEmail']);
    Route::post('/forgot-password/verify/otp', [ForgotPasswordController::class, 'verifyOtp']);
    Route::post('/reset-password', [ResetPasswordController::class, 'resetPassword']);
});

Route::prefix('focused_areas')->group(function () {
    Route::get('/', [FocusedAreasController::class, 'list']);
});

Route::prefix('workouts')->group(function () {
    Route::post('/', [WorkoutsController::class, 'list']);
});

Route::prefix('exercises')->middleware('auth.api.reqs')->group(function () {
    Route::get('/', [ExercisesController::class, 'list']);
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
