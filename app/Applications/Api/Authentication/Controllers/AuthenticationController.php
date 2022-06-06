<?php

namespace App\Applications\Api\Authentication\Controllers;


use App\Applications\Api\Authentication\Validators\AuthenticationValidator;
use App\Http\Controllers\Controller;

class AuthenticationController extends Controller
{
    public function register(AuthenticationValidator $validator)
    {
        //action to create user
        //
    }
}
