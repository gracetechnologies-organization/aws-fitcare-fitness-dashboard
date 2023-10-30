<?php
use App\Http\Livewire\Admin\Dashboard;
use App\Http\Livewire\Admin\ManageBackups;
use App\Http\Livewire\Admin\ManageEmployees;
use App\Http\Livewire\Admin\ManageTokens;
use App\Http\Livewire\Admin\Profile;

Route::middleware('admin.guard')->prefix('admin')->group(function () {
    Route::get('/dashboard', Dashboard::class)->name('admin.index');
    Route::get('/employees', ManageEmployees::class)->name('admin.employees');
    Route::get('/backups', ManageBackups::class)->name('admin.backups');
    Route::get('/tokens', ManageTokens::class)->name('admin.tokens');
    Route::get('/profile', Profile::class)->name('admin.profile');
    Route::post('/update/info', )->name('admin.update.info');
    // Route::get('/profile', [AdminController::class, 'profile'])->name('admin.profile');
    // Route::post('/update-admin', [AdminController::class, 'update_admin'])->name('admin.update');
    // Route::post('/update-password', [AdminController::class, 'update_admin_password'])->name('admin.update_password');
});