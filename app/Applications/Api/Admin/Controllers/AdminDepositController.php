<?php

namespace App\Applications\Api\Admin\Controllers;

use App\Applications\Api\Customer\Validators\Deposits\ListDepositsValidator;
use App\Domains\Deposits\Models\Deposit;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class AdminDepositController extends Controller
{
    /**
     * @param ListDepositsValidator $request
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $pending_deposits = Deposit::pending()->with('user')->get();
        return response()->json($pending_deposits);
    }

    public function show(int $deposit_id) : JsonResponse
    {
        $deposit = Deposit::find($deposit_id);
        return response()->json($deposit);
    }
}
