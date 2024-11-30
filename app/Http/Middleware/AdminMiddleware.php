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
            return response()->json(['error' => 'Yetkisiz giriş. Lütfen giriş yapin.'], 401);
        }
        if (Auth::user()->role !== 'admin') {
            return response()->json(['error' => 'Yetkisiz giriş. Sadece Admin.'], 403);
        }
        return $next($request);
    }
}
