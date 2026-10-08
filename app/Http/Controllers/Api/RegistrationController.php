<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Password;

class RegistrationController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'string', Password::min(8)],
            'gender' => ['required', 'string', 'in:male,female,other'],
        ]);

        $user = User::create([
            'email' => $validated['email'],
            'password' => $validated['password'],
            'gender' => $validated['gender'],
        ]);

        return response()->json([
            'user_id' => $user->id,
            'message' => 'User registered successfully',
        ], 201);
    }
}