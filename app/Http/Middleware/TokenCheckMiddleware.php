<?php

namespace App\Http\Middleware;

use Closure;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Http\JsonResponse;

class TokenCheckMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        try {
            // Kullanıcının token'ını doğrula
            $user = JWTAuth::parseToken()->authenticate();

            if (!$user) {
                return new JsonResponse([
                    'success' => false,
                    'message' => 'Token geçerli ancak kullanıcı bulunamadı.',
                ], 401);
            }
        } catch (TokenExpiredException $e) {
            return new JsonResponse([
                'success' => false,
                'message' => 'Token süresi dolmuş.',
            ], 401);
        } catch (TokenInvalidException $e) {
            return new JsonResponse([
                'success' => false,
                'message' => 'Token geçersiz.',
            ], 401);
        } catch (JWTException $e) {
            return new JsonResponse([
                'success' => false,
                'message' => 'Token doğrulama hatası.',
            ], 401);
        }

        return $next($request);
    }
}
