<?php

namespace App\Applications\Api\Customer\Controllers;

use App\Applications\Api\Images\Validators\Transactions\ShowImageValidator;
use App\Domains\Images\Models\Image;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class ImageController extends Controller
{
    /**
     * @param ShowImageValidator $request
     * @return JsonResponse
     */
    public function show(int $image_id): BinaryFileResponse
    {
        //todo make action to validate user
        //todo make action to admin see all images withou validation
        $image = Image::find($image_id);
        return response()->file(Storage::path($image->path));
    }
}
