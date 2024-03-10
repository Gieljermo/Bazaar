<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ListingController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [MainController::class, 'index'])->name('home');

Route::post('/logout', [MainController::class, 'logout'])->name('logout')->middleware('auth');

Route::resources([
    'users' => UserController::class
]);

Route::resource('listings', ListingController::class);

Route::middleware(['auth'])->group(function () {
    Route::post('/listings/bid', [ListingController::class, 'bid'])->name('listing.bid');
    Route::post('/listings/buy', [ListingController::class, 'buy'])->name('listing.buy');
    Route::post('/listings/rent', [ListingController::class, 'rent'])->name('listing.rent');
});

