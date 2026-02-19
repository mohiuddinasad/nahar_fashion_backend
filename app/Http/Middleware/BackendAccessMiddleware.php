<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class BackendAccessMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        $user = $request->user();

        if (! $user) {
            return redirect()->route('login');
        }

        // ❌ Customers and Wholesale Buyers cannot access admin panel
        if (! $user->canAccessBackend()) {
            return view('welcome')
                ->with('error', 'You do not have access to the admin panel.');
        }

        return $next($request);
    }
}