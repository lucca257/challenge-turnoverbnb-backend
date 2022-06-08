<?php

use App\Applications\Api\Authentication\Controllers\AuthenticationController;
use App\Applications\Api\Customer\Controllers\ImageController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::controller(AuthenticationController::class)->prefix('auth')->group(function () {
    Route::post('register', 'register');
    Route::post('login', 'login');
});

Route::controller(ImageController::class)->prefix('image')->group(function () {
    Route::get('{id}', 'show');
});
