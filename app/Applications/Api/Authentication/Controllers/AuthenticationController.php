<?php

namespace App\Applications\Api\Authentication\Controllers;

use App\Applications\Api\Authentication\Validators\RegisterAuthenticationValidator;
use App\Applications\Api\Authentication\Validators\AuthenticationValidator;
use App\Domains\Authentication\Actions\LoginUserAction;
use App\Domains\Users\Actions\RegisterUserAction;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

class AuthenticationController extends Controller
{
    /**
     * @param AuthenticationValidator $validator
     * @param RegisterUserAction $registerUserAction
     * @return JsonResponse
     */
    public function register(RegisterAuthenticationValidator $validator, RegisterUserAction $registerUserAction) : JsonResponse
    {
        $user = $registerUserAction->execute($validator->toDTO());
        $token = $user->createToken('auth_token')->plainTextToken;
        return response()->json([
            'username' => $user->username,
            'role' => $user->role,
            'access_token' => $token,
            'token_type' => 'Bearer'
        ]);
    }

    public function login(AuthenticationValidator $validator, LoginUserAction $loginUserAction) : JsonResponse
    {
        $loginCredentials = $loginUserAction->execute($validator->toDTO());
        return response()->json($loginCredentials);
    }
}
