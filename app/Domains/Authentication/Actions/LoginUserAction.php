<?php

namespace App\Domains\Authentication\Actions;

use App\Domains\Authentication\DTOs\AuthenticationDTO;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class LoginUserAction
{
    /**
     * @param AuthenticationDTO $authenticationDTO
     * @return Collection
     * @throws AuthenticationException
     */
    public function execute(AuthenticationDTO $authenticationDTO) : Collection
    {
        if (!Auth::attempt(get_object_vars($authenticationDTO))) {
            throw new AuthenticationException('Invalid login credentials');
        }

        $user = Auth::user();
        $token = $user->createToken('auth_token')->plainTextToken;
        return collect([
            'username' => $user->username,
            'email' => $user->email,
            'access_token' => $token,
            'token_type' => 'Bearer'
        ]);
    }
}
