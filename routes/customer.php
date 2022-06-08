<?php

use App\Applications\Api\Customer\Controllers\DepositController;
use App\Applications\Api\Customer\Controllers\ImageController;
use App\Applications\Api\Customer\Controllers\PurchaseController;
use App\Applications\Api\Customer\Controllers\TransactionController;
use App\Applications\Api\Customer\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::controller(TransactionController::class)->prefix('transactions')->group(function () {
    Route::any('', 'index');
});

Route::controller(DepositController::class)->prefix('deposits')->group(function () {
    Route::any('list', 'index');
    Route::get('{deposit_id}', 'show');
    Route::post('', 'store');
});

Route::controller(PurchaseController::class)->prefix('purchases')->group(function () {
    Route::any('list', 'index');
    Route::post('', 'store');
});

Route::controller(ImageController::class)->prefix('image')->group(function () {
    Route::get('{id}', 'show');
});

Route::controller(UserController::class)->prefix('user')->group(function () {
    Route::get('balance', 'balance');
});
