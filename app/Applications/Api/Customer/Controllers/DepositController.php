<?php

namespace App\Applications\Api\Customer\Controllers;

use App\Applications\Api\Customer\Validators\Deposits\ListDepositsValidator;
use App\Applications\Api\Customer\Validators\Deposits\StoreDepositsValidator;
use App\Domains\Deposits\Actions\CreateDepositAction;
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

    /**
     * @param int $deposit_id
     * @return JsonResponse
     */
    public function show(int $deposit_id): JsonResponse
    {
        $deposit = Auth::user()->with('deposits')->find($deposit_id);
        return response()->json($deposit);
    }

    /**
     * @param StoreDepositsValidator $validator
     * @param CreateDepositAction $createDepositAction
     * @return JsonResponse
     */
    public function store(StoreDepositsValidator $validator, CreateDepositAction $createDepositAction): JsonResponse
    {
        $deposit = $createDepositAction->execute($validator->toDTO());
        return response()->json($deposit);
    }
}
