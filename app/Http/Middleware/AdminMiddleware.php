<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();

        // Check if user is logged in and role is admin
        if (! $user || $user->role !== 'admin') {
            return response()->view('wrong.error', [], 403);
        }

        return $next($request);
    }
}
