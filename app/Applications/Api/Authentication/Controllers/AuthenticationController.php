<?php

namespace App\Applications\Api\Authentication\Controllers;


use App\Applications\Api\Authentication\Validators\AuthenticationValidator;
use App\Domains\Authentication\Actions\LoginUserAction;
use App\Domains\Users\Actions\RegisterUserAction;
use App\Http\Controllers\Controller;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticationController extends Controller
{
    /**
     * @param AuthenticationValidator $validator
     * @param RegisterUserAction $registerUserAction
     * @return JsonResponse
     */
    public function register(AuthenticationValidator $validator, RegisterUserAction $registerUserAction) : JsonResponse
    {
        $user = $registerUserAction->execute($validator->toDTO());
        $token = $user->createToken('auth_token')->plainTextToken;
        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer'
        ]);
    }

    public function login(AuthenticationValidator $validator, LoginUserAction $loginUserAction) : JsonResponse
    {
        try {
            $loginCredentials = $loginUserAction->execute($validator->toDTO());
            return response()->json($loginCredentials);
        } catch (\Exception $e) {
            return response()->json([
                'message' => "Something went wrong"
            ], 500);
        } catch (\AuthenticationException $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 401);
        }
    }
}
