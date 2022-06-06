<?php

use App\Applications\Api\Admin\Controllers\AdminDepositController;
use Illuminate\Support\Facades\Route;

Route::controller(AdminDepositController::class)->prefix('deposits')->group(function () {
    Route::get('', 'index');
});
