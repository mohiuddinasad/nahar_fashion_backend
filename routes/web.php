<?php

use App\Http\Controllers\Backend\Pofile\MyProfileController;
use App\Http\Controllers\Backend\RolePermission\RolePermissionController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['role:super_admin|admin|manager'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

});
// backend routes

Route::prefix('dashboard/')->name('dashboard.')->middleware(['role:super_admin|admin|manager'])->group(function () {
    Route::get('/profile', [MyProfileController::class, 'index'])->name('profile');
    Route::post('/profile-update', [MyProfileController::class, 'update'])->name('profile.update');
    Route::post('/password-update', [MyProfileController::class, 'updatePassword'])->name('password.update');

    Route::prefix('users')->name('users.')->middleware(['role:super_admin|admin'])->group(function () {
        Route::get('/user-list', [RolePermissionController::class, 'userList'])->name('user-list');
        Route::put('/user-update/{id}', [RolePermissionController::class, 'userUpdate'])->name('user-update');
        Route::post('/{id}/grant-wholesale', [RolePermissionController::class, 'grantWholesale'])->name('grant-wholesale');
        Route::post('/{id}/revoke-wholesale', [RolePermissionController::class, 'revokeWholesale'])->name('revoke-wholesale');
        Route::get('/user-delete/{id}', [RolePermissionController::class, 'userDelete'])->name('user-delete');
    });

    Route::prefix('role-permission')->name('role-permission.')->middleware('role:super_admin|admin')->group(function () {
        Route::get('/role-list', [RolePermissionController::class, 'roleList'])->name('role-list');
        Route::get('/role-create', [RolePermissionController::class, 'roleCreate'])->name('role-create');
        Route::post('/role-store', [RolePermissionController::class, 'roleStore'])->name('role-store');
        Route::get('/role-edit/{id}', [RolePermissionController::class, 'roleEdit'])->name('role-edit');
        Route::put('/role-update/{id}', [RolePermissionController::class, 'roleUpdate'])->name('role-update');
        Route::delete('/role-delete/{id}', [RolePermissionController::class, 'roleDelete'])->name('role-delete');
    });
});

// frontend routes

require __DIR__.'/auth.php';