<?php

namespace App\Applications\Api\Customer\Controllers;

use App\Applications\Api\Customer\Validators\Purchases\ListPurchasesValidator;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class PurchaseController extends Controller
{
    /**
     * @param ListPurchasesValidator $request
     * @return JsonResponse
     */
    public function index(ListPurchasesValidator $request): JsonResponse
    {
        $user_deposits = Auth::user()->purchases()->findByFilters($request->toDTO())->get();
        return response()->json($user_deposits);
    }
}
