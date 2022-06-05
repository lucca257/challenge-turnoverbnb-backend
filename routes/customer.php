<?php

use App\Applications\Api\Customer\Controllers\DepositController;
use App\Applications\Api\Customer\Controllers\TransactionController;
use Illuminate\Support\Facades\Route;

Route::controller(TransactionController::class)->prefix('transactions')->group(function () {
    Route::get('', 'index');
});

