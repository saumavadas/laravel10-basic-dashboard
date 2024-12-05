<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\API\SellerAuthController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) 
{
    return $request->user();
});


Route::prefix('seller')->group(function () 
{
    Route::post('register-seller', [SellerAuthController::class, 'registerSeller']);
    Route::post('verify-seller-otp', [SellerAuthController::class, 'verifySellerOtp']);
});