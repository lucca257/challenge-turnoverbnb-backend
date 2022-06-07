<?php

namespace App\Domains\Authentication\Actions;

use App\Domains\Authentication\DTOs\AuthenticationDTO;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Exceptions\HttpResponseException;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class LoginUserAction
{
    /**
     * @param AuthenticationDTO $authenticationDTO
     * @return Collection
     * @throws AuthenticationException
     * @throws \Exception
     */
    public function execute(AuthenticationDTO $authenticationDTO) : Collection
    {
        if (!Auth::attempt(array_filter(get_object_vars($authenticationDTO)))) {
            throw new HttpResponseException(response()->json("Unauthorized", 401));
        }

        $user = Auth::user();
        $token = $user->createToken('auth_token')->plainTextToken;
        return collect([
            'username' => $user->username,
            'role' => $user->role,
            'access_token' => $token,
            'token_type' => 'Bearer'
        ]);
    }
}
