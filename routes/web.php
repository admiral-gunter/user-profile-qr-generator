<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserSocialProfileController;
use App\Http\Controllers\UserSocialsManagementController;
use Illuminate\Support\Facades\Redirect;
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

Route::get('/login', [AuthController::class, 'Login']);

Route::get('/', function () {
    return Redirect::to('/login');
});

Route::group(['prefix' => 'user-socials'], function () {
    

    Route::get('qr/{id}', [UserSocialsManagementController::class, 'ViewUserSocials']);

});
Route::middleware('sanctum.token')->group(function () {
    Route::get('home',  [UserSocialProfileController::class, 'home']);

});    
// Route::group()



