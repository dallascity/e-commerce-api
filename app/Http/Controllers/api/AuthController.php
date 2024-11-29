<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\api\ApiController;
use Illuminate\Http\Request;

class AuthController extends ApiController
{

    public function register(Request $request)
    {
        // Dummy response, gerçek veritabanı işlemleri buraya eklenebilir
        $userData = [
            'id' => 1,
            'name' => 'Eymen',
            'email' => 'eymen@example.com',
        ];

        return $this->sendSuccess($userData, 201); // Success response
    }

    public function login(Request $request)
    {
        // Dummy response, gerçek kimlik doğrulama buraya eklenebilir
        $tokenData = [
            'token' => 'exampleToken123456789',
            'token_type' => 'Bearer',
            'expires_in' => 3600,
        ];

        return $this->sendSuccess($tokenData, 200); // Success response
    }

    public function logout(Request $request)
    {
        // Dummy response, oturum kapatma işlemi buraya eklenebilir
        return $this->sendSuccess('User logged out successfully', 200); // Success response
    }

    /**
     * Success Response
     */
    public function sendSuccess($data, $code = 200)
    {
        return response()->json([
            'success' => true,
            'data' => $data,
        ], $code);
    }

    /**
     * Error Response
     */
    public function sendError($errors = [], $code = 400)
    {
        return response()->json([
            'success' => false,
            'errors' => $errors,
        ], $code);
    }
}
