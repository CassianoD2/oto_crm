<?php

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

/**
 * Código comentado não será utilizado no teste.
 */
//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});


Route::middleware('api.token')->get('order/count', [\App\Http\Controllers\Api\BaseApiController::class, 'returnOrderCountByDate']);
Route::middleware('api.token')->get('order/revenue', [\App\Http\Controllers\Api\BaseApiController::class, 'returnOrdersRevenueByDate']);
Route::middleware('api.token')->get('order/quantity', [\App\Http\Controllers\Api\BaseApiController::class, 'returnTotalQuantityItensSellByDate']);
Route::middleware('api.token')->get('order/retail-price', [\App\Http\Controllers\Api\BaseApiController::class, 'returnOrdersRetailPrice']);
Route::middleware('api.token')->get('order/average-price', [\App\Http\Controllers\Api\BaseApiController::class, 'returnOrdersAverageOrderValue']);
Route::middleware('api.token')->get('order/all-statistics', [\App\Http\Controllers\Api\BaseApiController::class, 'returnAllStatistics']);
Route::middleware('api.token')->get('order/count-date', [\App\Http\Controllers\Api\BaseApiController::class, 'countOrdersByDate']);


