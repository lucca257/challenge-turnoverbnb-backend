<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return response()->json([
        'application' => 'BNB BANK',
        'message' => 'Welcome to the BNB BANK API',
        'version' => '1.0.0',
        'author' => 'Pedro Almeida',
        'github' => 'lucca257'
    ]);
});
