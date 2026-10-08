<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function show(Request $request): JsonResponse
    {
        $request->validate([
            'user_id' => ['required', 'integer', 'exists:users,id'],
        ]);

        $user = User::findOrFail($request->input('user_id'));

        return response()->json([
            'id' => $user->id,
            'email' => $user->email,
            'gender' => $user->gender,
            'created_at' => $user->created_at->toDateTimeString(),
        ]);
    }
}