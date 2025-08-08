<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function register(RegisterRequest $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);
        return response()->json(
            [
                'message' => 'user registered successfully',
                'User' => $user,
            ]
            ,
            201
        );

    }
    public function login(LoginUserRequest $request)
    {
        if (!Auth::attempt($request->only('email', 'password')))
            return response()->json(
                [
                    'massage' => 'invalid email or password'
                ],
                401
            );
        $user = User::where('email', $request->email)->firstOrFail();
        $token = $user->createToken('auth_Token')->plainTextToken;

        return response()->json(
            [
                'message' => 'Login successfully',
                'User' => $user,
                'Token' => $token
            ]
            ,
            201
        );

    }
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(
            [
                'message' => 'Logout successfully',
            ]
        );
    }


}
