<?php

namespace App\Applications\Api\Authentication\Controllers;


use App\Applications\Api\Authentication\Validators\AuthenticationValidator;
use App\Domains\Users\Actions\RegisterUserAction;
use App\Domains\Users\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthenticationController extends Controller
{
    public function register(AuthenticationValidator $validator, RegisterUserAction $registerUserAction)
    {
        $user = $registerUserAction->execute($validator->toDTO());
        $token = $user->createToken('auth_token')->plainTextToken;
        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer'
        ]);
    }
}
