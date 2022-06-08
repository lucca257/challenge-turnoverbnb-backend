<?php

use App\Applications\Api\Admin\Controllers\AdminDepositController;
use App\Applications\Api\Customer\Controllers\ImageController;
use Illuminate\Support\Facades\Route;

Route::controller(AdminDepositController::class)->prefix('deposits')->group(function () {
    Route::get('', 'index');
    Route::get('{deposit_id}', 'show');
    Route::patch('review', 'update');
});

Route::controller(ImageController::class)->prefix('image')->group(function () {
    Route::get('{id}', 'show');
});
