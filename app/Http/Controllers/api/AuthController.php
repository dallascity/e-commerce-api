<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\api\ApiController;
use App\Http\Requests\api\LoginRequest;
use App\Http\Requests\api\RegisterRequest;
use Illuminate\Http\Request;
use App\Services\AuthService;

class AuthController extends ApiController
{
    protected AuthService $authService;
    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }


    public function register(RegisterRequest $request)
    {
        // dd($request->all());
        $data = $this->authService->register($request->validated());
        return $this->sendSuccess($data, 201);
    }

    public function login(LoginRequest $request)
    {
        try {
            $data = $this->authService->login($request->validated());
            return $this->sendSuccess($data, 200);
        } catch (\Exception $e) {
            return $this->sendError(['message' => $e->getMessage()], $e->getCode());
        }
    }

    public function logout(Request $request)
    {
        try {
            $this->authService->logout();
            return $this->sendSuccess(['message' => 'Çıkış yapıldı.'], 200);
        } catch (\Exception $e) {
            return $this->sendError(['message' => 'Çıkış işlemi sırasında bir hata oluştu.'], 500);
        }
    }
}
