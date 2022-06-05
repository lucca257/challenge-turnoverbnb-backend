<?php

namespace App\Applications\Api\Customer\Controllers;

use App\Applications\Api\Customer\Validators\Deposits\ListDepositsValidator;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class DepositController extends Controller
{
    /**
     * @param ListDepositsValidator $request
     * @return JsonResponse
     */
    public function index(ListDepositsValidator $request): JsonResponse
    {
        $user_deposits = Auth::user()->deposits()->findByFilters($request->toDTO())->get();
        return response()->json($user_deposits);
    }
}
