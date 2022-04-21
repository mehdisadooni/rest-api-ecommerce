<?php

use Illuminate\Support\Facades\Route;
use \Modules\Category\Http\Controllers\Api\V1\CategoryController;
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


Route::prefix('v1/')->group(function () {
    Route::apiResource('categories',CategoryController::class);
    Route::get('/categories/{category}/children',[CategoryController::class,'children']);
    Route::get('/categories/{category}/parent',[CategoryController::class,'parent']);
});
