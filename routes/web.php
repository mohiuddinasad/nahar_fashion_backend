<?php

use App\Http\Controllers\Backend\Banners\BannerController;
use App\Http\Controllers\Backend\Contact\ContactController;
use App\Http\Controllers\Backend\Order\OrderController;
use App\Http\Controllers\Backend\Pofile\MyProfileController;
use App\Http\Controllers\Backend\Products\CategoryController;
use App\Http\Controllers\Backend\Products\ProductController;
use App\Http\Controllers\Backend\RolePermission\RolePermissionController;
use App\Http\Controllers\Frontend\Cart\CartController;
use App\Http\Controllers\Frontend\HomePageController;
use App\Http\Controllers\Frontend\OrderTracking\OrderTrackingController;
use App\Http\Controllers\Frontend\ProductDetails\ProductDetailsController;
use App\Http\Controllers\Frontend\Review\ReviewController;
use App\Http\Controllers\Frontend\Shop\ShopController;
use App\Http\Controllers\Frontend\Wishlist\WishlistController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

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

    Route::prefix('role-permission')->name('role-permission.')->middleware(['permission:roles.create|roles.edit|roles.delete|roles.view|
            permissions.assign|permissions.view|
            users.create|users.edit|users.delete|users.view|users.assign-role'])->group(function () {
        Route::get('/role-list', [RolePermissionController::class, 'roleList'])->name('role-list');
        Route::get('/role-create', [RolePermissionController::class, 'roleCreate'])->name('role-create');
        Route::post('/role-store', [RolePermissionController::class, 'roleStore'])->name('role-store');
        Route::get('/role-edit/{id}', [RolePermissionController::class, 'roleEdit'])->name('role-edit');
        Route::put('/role-update/{id}', [RolePermissionController::class, 'roleUpdate'])->name('role-update');
        Route::delete('/role-delete/{id}', [RolePermissionController::class, 'roleDelete'])->name('role-delete');
    });

    Route::prefix('categories')->name('categories.')->middleware(['role:super_admin|admin|manager'])->group(function () {
        Route::get('/category-list', [CategoryController::class, 'index'])->name('category-list');
        Route::get('/category-create', [CategoryController::class, 'create'])->name('category-create');
        Route::post('/category-store', [CategoryController::class, 'store'])->name('category-store');
        Route::get('/category-edit/{category}', [CategoryController::class, 'edit'])->name('category-edit');
        Route::put('/category-update/{category}', [CategoryController::class, 'update'])->name('category-update');
        Route::delete('/category-delete/{category}', [CategoryController::class, 'destroy'])->name('category-delete');
        Route::get('/category-search', [CategoryController::class, 'search'])->name('category-search');
    });

    // ─── Products ─────────────────────────────────────────────────
    Route::prefix('products')->name('products.')->middleware(['role:super_admin|admin|manager'])->group(function () {
        Route::get('/product-list', [ProductController::class, 'index'])->name('product-list');
        Route::get('/product-create', [ProductController::class, 'create'])->name('product-create');
        Route::post('/product-store', [ProductController::class, 'store'])->name('product-store');
        Route::get('/product-edit/{product}', [ProductController::class, 'edit'])->name('product-edit');
        Route::put('/product-update/{product}', [ProductController::class, 'update'])->name('product-update');
        Route::delete('/product-delete/{product}', [ProductController::class, 'destroy'])->name('product-delete');
        Route::get('/product-search', [ProductController::class, 'search'])->name('product-search');
    });
    // ─── banners ─────────────────────────────────────────────────
    Route::prefix('banners')->name('banners.')->middleware(['role:super_admin|admin|manager'])->group(function () {
        // top banners
        Route::get('/top-banner-list', [BannerController::class, 'index'])->name('top.banner-list');
        Route::get('/top-banner-create', [BannerController::class, 'create'])->name('top.banner-create');
        Route::post('/top-banner-store', [BannerController::class, 'store'])->name('top.banner-store');
        Route::get('/top-banner-delete/{id}', [BannerController::class, 'destroy'])->name('top.banner-delete');
        Route::get('/top-banner-edit/{id}', [BannerController::class, 'edit'])->name('top.banner-edit');
        Route::put('/top-banner-update/{id}', [BannerController::class, 'update'])->name('top.banner-update');

        // bottom banners
        Route::get('/bottom-banner-list', [BannerController::class, 'bottomIndex'])->name('bottom.banner-list');
        Route::get('/bottom-banner-create', [BannerController::class, 'bottomCreate'])->name('bottom.banner-create');
        Route::post('/bottom-banner-store', [BannerController::class, 'bottomStore'])->name('bottom.banner-store');
        Route::get('/bottom-banner-delete/{id}', [BannerController::class, 'bottomDestroy'])->name('bottom.banner-delete');
        Route::get('/bottom-banner-edit/{id}', [BannerController::class, 'bottomEdit'])->name('bottom.banner-edit');
        Route::put('/bottom-banner-update/{id}', [BannerController::class, 'bottomUpdate'])->name('bottom.banner-update');

    });
    // ─── contacts Routes ─────────────────────────────────────────────────
    Route::get('/contact-list', [ContactController::class, 'index'])->name('contact-list');
    Route::post('/contact-store', [ContactController::class, 'store'])->name('contact-store');
    Route::get('/contacts/{contact}', [ContactController::class, 'show'])->name('contacts.show');
    Route::delete('/contacts/{contact}', [ContactController::class, 'destroy'])->name('contacts.destroy');
    // ─── orders Routes ─────────────────────────────────────────────────
    Route::prefix('orders')->name('orders.')->middleware(['role:super_admin|admin|manager'])->group(function () {
        Route::get('/order-list', [OrderController::class, 'index'])->name('order-list');
        Route::get('/order-show/{order}', [OrderController::class, 'show'])->name('order-show');
        Route::put('/order-status/{order}', [OrderController::class, 'updateStatus'])->name('order-status');
        Route::put('/payment-status/{order}', [OrderController::class, 'updatePaymentStatus'])->name('payment-status');
        Route::delete('/order-delete/{order}', [OrderController::class, 'destroy'])->name('order-delete');
    });

});

// frontend routes
Route::prefix('/')->name('frontend.')->group(function () {
    Route::get('/', [HomePageController::class, 'index'])->name('home');
    Route::get('/product_details/{slug}', [ProductDetailsController::class, 'productDetails'])->name('product-details');
    Route::post('/checkout', [HomePageController::class, 'store'])->name('checkout.store');
    Route::get('/order-success/{orderNumber}', [HomePageController::class, 'success'])->name('order.success');

    // cart routes
    Route::get('/cart', [CartController::class, 'index'])->name('cart');
    Route::get('/cart/add', [CartController::class, 'addToCart'])->name('add.cart');
    Route::get('/remove-cart/{id}', [CartController::class, 'removeCart'])->name('remove.cart');
    Route::post('/cart/update', [CartController::class, 'updateCart'])->name('cart.update');

    // shop routes
    Route::get('/shop', [ShopController::class, 'index'])->name('shop');
    Route::get('/category/{slug}', [ShopController::class, 'categoryWiseProduct'])->name('category-wise-product');
    Route::get('/shop/search', [ShopController::class, 'liveSearch'])->name('shop.live-search');

    // Wishlist routes

    Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist');
    Route::post('/wishlist/add/{id}', [WishlistController::class, 'add'])->name('wishlist.add');
    Route::delete('/wishlist/remove/{id}', [WishlistController::class, 'remove'])->name('wishlist.remove');

    // contact
    Route::get('/contact', function () {
        return view('frontend.contact');
    })->name('contact');
    Route::get('/checkout', function () {
        return view('frontend.checkout');
    })->name('checkout');

    // order tracking routes--------------------------------------------------
    Route::get('/track-order', [OrderTrackingController::class, 'index'])->name('track-order');
    Route::post('/track-order', [OrderTrackingController::class, 'track'])->name('track-order.track');

    // revie routes --------------------------------------------------

    Route::post('/products/{product}/reviews', [ReviewController::class, 'store'])->name('reviews.store');

    // product search route ------------------------------------------------
    

    
});

require __DIR__.'/auth.php';