<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check()) {
            return response()->json(['error' => 'Unauthorized. Please log in.'], 401);
        }
        if (Auth::user()->role !== 'admin') {
            return response()->json(['error' => 'Unauthorized. Admin access only.'], 403);
        }
        return $next($request);
    }
}
