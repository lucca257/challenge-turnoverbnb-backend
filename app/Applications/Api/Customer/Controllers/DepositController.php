<?php

namespace App\Applications\Api\Customer\Controllers;

use App\Applications\Api\Customer\Validators\Deposits\ListDepositsValidator;
use App\Applications\Api\Customer\Validators\Deposits\StoreDepositsValidator;
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

    public function show(int $deposit_id): JsonResponse
    {
        $deposit = Auth::user()->with('deposits')->find($deposit_id);
        return response()->json($deposit);
    }

    public function store(StoreDepositsValidator $validator){
        dd($validator->toDTO());
    }
}
