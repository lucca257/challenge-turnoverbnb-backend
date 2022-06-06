<?php

namespace App\Applications\Api\Customer\Controllers;

use App\Applications\Api\Customer\Validators\Purchases\ListPurchasesValidator;
use App\Applications\Api\Customer\Validators\Purchases\StorePurchasesValidator;
use App\Domains\Purchases\Actions\CreatePurchaseAction;
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

    /**
     * @param StorePurchasesValidator $request
     * @return JsonResponse
     */
    public function store(StorePurchasesValidator $request, CreatePurchaseAction $createPurchaseAction): JsonResponse
    {
        $purchase = $createPurchaseAction->execute($request->toDTO());
        return response()->json($purchase);
    }
}
