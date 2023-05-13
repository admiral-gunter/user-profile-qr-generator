<?php

use App\Http\Controllers\ApiAuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserSocialsManagementController;


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

Route::group(['prefix' => 'v1'], function () {
    Route::middleware('sanctum.token')->group(function () {
        Route::post('user-socials/add', [UserSocialsManagementController::class, 'PostMySocials']);
    });
    
    Route::group(['prefix' => 'auth'], function () {
        
        Route::post('register',[ApiAuthController::class, 'register']);
        Route::post('login',[ApiAuthController::class, 'login']);
    
    });
});

