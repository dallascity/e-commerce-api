<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function sendSuccess($data, $code = 200)
    {
        return response()->json([
            'success' => true,
            'data' => $data,
        ], $code);
    }
    public function sendError($errors = [], $code = 400)
    {
        return response()->json([
            'success' => false,
            'errors' => $errors,
        ], $code);
    }
}
