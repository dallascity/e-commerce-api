<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class TokenCheckMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        try {

            JWTAuth::parseToken()->authenticate();
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException
                    ? 'Token süresi dolmuş.'
                    : ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException
                        ? 'Token geçersiz.'
                        : 'Token bulunamadı.'),
            ], 401);
        }

        return $next($request);
    }
}
