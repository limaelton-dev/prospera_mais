<?php

use App\Http\Controllers\ApiWalletController;
use App\Http\Controllers\Auth\RegisteredUserController;
use Illuminate\Http\Request;
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

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::resource('/wallets', ApiWalletController::class);

Route::post('/register', [RegisteredUserController::class, 'store']);
Route::post('wallets/{id}/withdraw', [ApiWalletController::class, 'withdraw']);
Route::post('wallets/{id}/deposit', [ApiWalletController::class, 'deposit']);
Route::post('wallets/{id}/transfer', [ApiWalletController::class, 'transfer']);
