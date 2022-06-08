<?php

namespace App\Applications\Api\Admin\Controllers;

use App\Applications\Api\Admin\Validators\ReviewDepositValidator;
use App\Domains\Deposits\Actions\ReviewDepositAction;
use App\Domains\Deposits\Models\Deposit;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

class AdminDepositController extends Controller
{
    /**
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $pending_deposits = Deposit::pending()->get();
        return response()->json($pending_deposits);
    }

    public function show(int $deposit_id) : JsonResponse
    {
        $deposit = Deposit::with('images','user','user.balance')->find($deposit_id);
        return response()->json($deposit);
    }

    public function update(ReviewDepositValidator $validator, ReviewDepositAction $reviewDepositAction) : JsonResponse
    {
        $deposit_review = $reviewDepositAction->execute($validator->toDTO());
        return response()->json($deposit_review);
    }
}
