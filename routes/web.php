<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainController;
use App\Http\Controllers\UserController;

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ProprietaryController;
use App\Http\Controllers\CommercialController;
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

Route::get('/user', [UserController::class, 'index'])->name('user.index');

Route::middleware('role:admin')->group(function (){
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');
});

Route::middleware('role:customer')->group(function (){
    Route::get('/customer', [CustomerController::class, 'index'])->name('customer.index');
});

Route::middleware('role:proprietary')->group(function (){
    Route::get('/proprietary', [ProprietaryController::class, 'index'])->name('proprietary.index');
});

Route::middleware('role:commercial')->group(function (){
    Route::get('/commercial', [CommercialController::class, 'index'])->name('commercial.index');
});


Route::resources([
    'users' => UserController::class
]);

Route::resource('listings', ListingController::class);
