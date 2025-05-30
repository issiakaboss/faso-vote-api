<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{
    public function login(Request $request)
    {

        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string', 'min:8'],
        ]);

        if (! Auth::attempt(['email' => $request->get('email'), 'password' => $request->get('password')])) {
            throw ValidationException::withMessages([
                'email' => trans('auth.failed'),
            ]);
        }

        /** @var User $user */
        $user = Auth::user();

        $user->tokens()->delete();
        $token = $user->createToken('my-app-token')->plainTextToken;

        return self::successJson(new UserResource($user))
            ->additional(compact('token'));
    }

    public function register(Request $request): JsonResource
    {
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string', 'min:8'],
            'name' => ['required', 'string', 'min:3'],
        ]);

        $user = User::create([
            'password' => $request->get('password'),
            'email' => $request->get('email'),
            'name' => $request->get('name'),
        ]);

        return self::successJson((new UserResource($user)));
    }

    public function logout(Request $request)
    {
        /** @var User $user */
        $user = $request->user();
        $user->tokens()->delete();

        return self::successJson(new UserResource($user));
    }

    public function redirectToGoogle()
    {
        $url = Socialite::driver('google')
            ->stateless()
            ->redirect()
            ->getTargetUrl();

        return self::successJson(new JsonResource(['url' => $url]));
    }

    public function handleGoogleCallback()
    {
        $googleUser = Socialite::driver('google')->stateless()->user();

        return self::successJson(new JsonResource([
            'identity' => $googleUser->getEmail(),
        ]));
    }
}
