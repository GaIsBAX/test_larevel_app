<?php

namespace App\Http\Controllers;


use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController
{
    public function register(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8'
        ]);

        $user = User::create([
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        return response()->json([
            'token' => $user->createToken('auth-token')->plainTextToken
        ], 201);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
    
        $user = User::where('email', $request->email)->first();
    
        if (! $user || ! Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => 'Неверный email или пароль',
            ], 401);
        }
    
        $existingToken = $user->tokens()->where('name', 'auth-token')->first();
    
        if ($existingToken) {
            $token = $existingToken->plainTextToken ?? $existingToken->token; // plainTextToken только сразу после создания
        } else {
            $token = $user->createToken('auth-token')->plainTextToken;
        }

        return response()->json([
            'token' => $token,
        ]);
    }
    

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        
        return response()->json(['message' => 'Вышел, иди нахуй']);
    }
}
