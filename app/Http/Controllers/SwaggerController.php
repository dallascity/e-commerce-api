<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

/**
 * @OA\Info(
 *     title="API Dokümantasyonu",
 *     version="1.0.0",
 *     description="Eymen Navdar Case API dokümantasyonu."
 * ),
 * @OA\Server(
 *     url="http://localhost:8080",
 *     description="Yerel Sunucu"
 * ),
 * @OA\PathItem(
 *     path="/api"
 * )
 */

class SwaggerController extends Controller {}
