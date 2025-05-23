<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request) // CONNEXION DU USER
    {
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string', 'min:8'],
        ]);

        $user = User::where('email', $request->email)->orWhere('pseudo', $request->pseudo)->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            return response([
                'message' => ['These credentials do not match our records.'],
            ], 404);
        }
        $user->tokens()->delete();
        $token = $user->createToken('my-app-token')->plainTextToken;

        $user->token = $token;

        return response([
            'user' => [
                'email' => $user->email,
            ],
            'token' => $token,
        ], 200);
    }
}
