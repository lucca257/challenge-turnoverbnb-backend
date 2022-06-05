<?php

namespace App\Applications\Api\Customer\Controllers;

use App\Applications\Api\Images\Validators\Transactions\ShowImageValidator;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class ImageController extends Controller
{
    /**
     * @param ShowImageValidator $request
     * @return JsonResponse
     */
    public function show(ShowImageValidator $request): JsonResponse
    {
        $images = Auth::user()->images()->find($request->input('id'));
        return response()->file($images->path);
    }
}
