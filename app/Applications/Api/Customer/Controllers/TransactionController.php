<?php

namespace App\Applications\Api\Customer\Controllers;


use App\Applications\Api\Customer\Validators\Transactions\ListTransactionValidator;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function index(ListTransactionValidator $request): JsonResponse
    {
        $user_transactions = Auth::user()->transactions()->findByFilters($request->toDTO())->get();
        return response()->json($user_transactions);
    }
}
