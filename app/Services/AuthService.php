<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthService
{
    public function register(array $data): array
    {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
        $token = JWTAuth::fromUser($user);

        return [
            'user' => $user,
            'token' => $token,
        ];
    }
    public function login(array $data): array
    {
        if (!$token = JWTAuth::attempt($data)) {
            throw new \Exception('Giriş bilgileri hatalı.', 401);
        }
        $user = JWTAuth::user();

        return [
            'user' => $user,
            'token' => $token,
        ];
    }
    public function logout(): void
    {
        JWTAuth::invalidate(JWTAuth::getToken());
    }
}
