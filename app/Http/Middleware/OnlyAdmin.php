<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OnlyAdmin
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        // Check if user is logged in
        if (!Auth::check()) {
            return redirect('/login')->with('error', 'You must be logged in!');
        }

        // Check if the user has the admin email
        $adminEmail = 'admin@admin.com'; 

        if (Auth::user()->email !== $adminEmail) {
            return redirect('/')->with('error', 'Access denied! Admins only.');
        }

        // Otherwise, allow access
        return $next($request);
    }
}
