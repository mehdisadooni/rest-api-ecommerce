<?php

use Illuminate\Support\Facades\Route;
use Modules\Purchase\Http\Controllers\Api\V1\PaymentController;

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

/**
 * Payment Gateway -- Pay --
 */
Route::prefix('v1')->group(function () {
    Route::post('/payment/send', [PaymentController::class, 'send']);
    Route::post('/payment/verify', [PaymentController::class, 'verify']);
});
