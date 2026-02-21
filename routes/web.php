<?php

use App\Http\Controllers\Backend\Pofile\MyProfileController;
use App\Http\Controllers\Backend\Products\CategoryController;
use App\Http\Controllers\Backend\Products\ProductController;
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
    Route::get('/profile-delete', [MyProfileController::class, 'delete'])->name('profile.delete');

    Route::prefix('users')->name('users.')->middleware(['role:super_admin|admin'])->group(function () {
        Route::get('/user-list', [RolePermissionController::class, 'userList'])->name('user-list');
        Route::put('/user-update/{id}', [RolePermissionController::class, 'userUpdate'])->name('user-update');
        Route::post('/{id}/grant-wholesale', [RolePermissionController::class, 'grantWholesale'])->name('grant-wholesale');
        Route::post('/{id}/revoke-wholesale', [RolePermissionController::class, 'revokeWholesale'])->name('revoke-wholesale');
        Route::get('/user-delete/{id}', [RolePermissionController::class, 'userDelete'])->name('user-delete');
    });

    Route::prefix('role-permission')->name('role-permission.')->middleware(['permission:roles.view'])->group(function () {
        Route::get('/role-list', [RolePermissionController::class, 'roleList'])->name('role-list');
        Route::get('/role-create', [RolePermissionController::class, 'roleCreate'])->name('role-create');
        Route::post('/role-store', [RolePermissionController::class, 'roleStore'])->name('role-store');
        Route::get('/role-edit/{id}', [RolePermissionController::class, 'roleEdit'])->name('role-edit');
        Route::put('/role-update/{id}', [RolePermissionController::class, 'roleUpdate'])->name('role-update');
        Route::delete('/role-delete/{id}', [RolePermissionController::class, 'roleDelete'])->name('role-delete');
    });

    Route::prefix('categories')->name('categories.')->middleware(['permission:categories.view'])->group(function () {
        Route::get('/category-list', [CategoryController::class, 'index'])->name('category-list');
        Route::get('/category-create', [CategoryController::class, 'create'])->name('category-create');
        Route::post('/category-store', [CategoryController::class, 'store'])->name('category-store');
        Route::get('/category-edit/{category}', [CategoryController::class, 'edit'])->name('category-edit');
        Route::put('/category-update/{category}', [CategoryController::class, 'update'])->name('category-update');
        Route::delete('/category-delete/{category}', [CategoryController::class, 'destroy'])->name('category-delete');
        Route::get('/category-search', [CategoryController::class, 'search'])->name('category-search');
    });

    // ─── Products ─────────────────────────────────────────────────
    Route::prefix('products')->name('products.')->middleware(['permission:products.view'])->group(function () {
        Route::get('/product-list', [ProductController::class, 'index'])->name('product-list');
        Route::get('/product-create', [ProductController::class, 'create'])->name('product-create');
        Route::post('/product-store', [ProductController::class, 'store'])->name('product-store');
        Route::get('/product-edit/{product}', [ProductController::class, 'edit'])->name('product-edit');
        Route::put('/product-update/{product}', [ProductController::class, 'update'])->name('product-update');
        Route::delete('/product-delete/{product}', [ProductController::class, 'destroy'])->name('product-delete');
        Route::get('/product-search', [ProductController::class, 'search'])->name('product-search');
    });

});

// frontend routes

require __DIR__.'/auth.php';
