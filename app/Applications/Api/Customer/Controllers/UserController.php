<?php

namespace App\Applications\Api\Customer\Controllers;


use App\Applications\Api\Customer\Validators\Transactions\ListTransactionValidator;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * @return JsonResponse
     */
    public function balance(): JsonResponse
    {
        return response()->json(Auth::user()->balance);
    }
}
