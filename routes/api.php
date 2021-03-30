<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminCountryController;
use App\Http\Controllers\Admin\AdminCityController;
use App\Http\Controllers\Admin\AdminDistrictController;
use App\Http\Controllers\Admin\AdminVillageController;
use App\Http\Controllers\User\UserRoyaltiController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('country', [AdminCountryController::class, 'index']);
Route::get('city', [AdminCityController::class, 'index']);
Route::get('district', [AdminDistrictController::class, 'index']);
Route::get('village', [AdminVillageController::class, 'index']);

Route::prefix('royalti')->group(function() {
    Route::post('list-buku', [UserRoyaltiController::class, 'api_list_buku']);    
    Route::post('user', [UserRoyaltiController::class, 'api_royalti_user']);    
    Route::get('all', [UserRoyaltiController::class, 'api_royalti_all']);    
    Route::post('grafik-royalti', [UserRoyaltiController::class, 'api_grafik_royalti']);    
});
