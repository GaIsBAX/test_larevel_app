<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserUpdateRequest;
use App\Http\Resources\ProfileResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
     public function show(Request $request)
    {
        return new ProfileResource($request->user());
    }


   public function update(UserUpdateRequest $request)
    {
        $user = $request->user();
        $data = $request->validated();

        if ($request->filled('password')) {
            $data['password'] = Hash::make($data['password']);
        }

        $user->update($data);

        return response()->json([
            'message' => 'Profile updated',
            'user' => new ProfileResource($user)
        ]);
    }

    public function destroy(Request $request)
    {
        $request->user()->tokens()->delete();
        $request->user()->delete();

        return response()->json([
            'message' => 'User deleted successfully'
        ]);
    }
}
