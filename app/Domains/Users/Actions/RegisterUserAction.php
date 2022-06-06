<?php

namespace App\Domains\Users\Actions;

use App\Domains\Authentication\DTOs\AuthenticationDTO;
use App\Domains\Users\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class RegisterUserAction extends Controller
{
    public function execute(AuthenticationDTO $authenticationDTO) : User
    {
        return User::create([
            "username" => $authenticationDTO->username,
            "password" => Hash::make($authenticationDTO->password),
            "email" => $authenticationDTO->email,
            "role" => "customer"
        ]);
        //create user balance
    }
}
