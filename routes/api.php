<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CommercialController;
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


Route::middleware('auth:sanctum')->get('/test', function () {
    return response()->json(['message' => 'You are authenticated']);
});


Route::get('advertisements', [CommercialController::class, 'dataToJson'])
    ->middleware('auth:sanctum')
    ->name('commercial.advertisements');
