<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;

class LogoutController extends Controller
{
    public function logout(): JsonResponse
    {
        auth()->logout();

        return response()->json([
            'status' => '200',
            'message' => 'User is logout'
        ]);
    }
}
