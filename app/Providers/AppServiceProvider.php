<?php

namespace App\Providers;

use App\Listeners\UpdateLastLogin;
use App\Models\Backend\Products\Category;
use App\Models\Backend\Products\Product;
use Illuminate\Auth\Events\Login;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    protected $policies = [];

    public function boot(): void
    {

        Event::listen(Login::class, UpdateLastLogin::class);
        // ✅ Super Admin bypasses ALL permission checks automatically
        Gate::before(function ($user, $ability) {
            if ($user->hasRole('super_admin')) {
                return true;
            }
        });

        // ✅ Only Super Admin can remove another Super Admin
        Gate::define('remove-super-admin', function ($user) {
            return $user->hasRole('super_admin');
        });

        // ✅ No user can change their own role
        Gate::define('change-own-role', function ($user, $targetUser) {
            if ($user->id === $targetUser->id) {
                return false; // blocked
            }

            return $user->hasRole('super_admin');
        });

        View::composer('frontend.*', function ($view) {
            $categories = Category::with('children')
                ->whereNull('category_id')
                ->get();

            

            $view->with('categories', $categories);
          

        });

    }
}