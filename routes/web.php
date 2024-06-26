<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainController;
use App\Http\Controllers\UserController;

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ProprietaryController;
use App\Http\Controllers\CommercialController;
use App\Http\Controllers\ListingController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\PageSettingsController;
use App\Http\Controllers\PageBuilderController;

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

Route::post('/logout', [MainController::class, 'logout'])->name('logout')->middleware('auth');


Route::middleware('role:admin')->group(function (){
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');
    Route::get('/admin/{role_name}', [AdminController::class, 'filterUsers'])->name('admin.filter');
    Route::get('/admin/export/{id}', [AdminController::class, 'exportContractPdf'])->name('admin.export.pdf');
    Route::post('/admin/upload/{id}', [AdminController::class, 'uploadContract'])->name('admin.upload');
});

Route::middleware('role:commercial')->group(function (){
    Route::get('/commercial/contract', [CommercialController::class, 'getContract'])->name('commercial.contract');
    Route::get('/commercial/contract/download/{id}',[CommercialController::class, 'downloadContract'])->name('commercial.download.contract');
    Route::get('/commercial/contract/{id}', [CommercialController::class, 'acceptContract'])->name('commercial.accept.contract');
    Route::get('/commercial/page-settings/{id}', [PageSettingsController::class, 'index'])->name('commercial.page-settings');
    Route::post('/commercial/page-settings/{id}', [PageSettingsController::class, 'store'])->name('commercial.page-settings.store');
    Route::get('/commercial/page-builder/{id}', [PageBuilderController::class, 'index'])->name('commercial.page-builder');
    Route::post('/commercial/page-builder/{id}', [PageBuilderController::class, 'store'])->name('commercial.page-builder.store');
    Route::delete('/commercial/page-builder/{component}', [PageBuilderController::class, 'destroy'])->name('commercial.page-builder.delete');
    Route::get('/commercial/page-builder/search/autocomplete', [ListingController::class, 'autocomplete']);
});

Route::middleware('role:customer,proprietary,commercial')->group(function (){
    Route::get('/customer/favorites', [CustomerController::class, 'getFavoriteProducts'])->name('customer.favorites');
    Route::get('/customer/favorites/{sort}', [CustomerController::class, 'sortFavoriteProducts'])->name('customer.sort.favorites');
    Route::get('/customer/add/favorite/{id}', [CustomerController::class, 'addFavoriteProduct'])->name('customer.add.favorite');
    Route::get('/customer/delete/favorite/{id}', [CustomerController::class, 'removeFavoriteProducts'])->name('customer.delete.favorite');
    Route::get('/customer/purchases', [CustomerController::class, 'getPurchaseHistory'])->name('customer.purchases');
    Route::get('/customer/purchases/{sort}', [CustomerController::class, 'sortPurchasedProducts'])->name('customer.sort.purchases');
    Route::post('/customer/review/', [CustomerController::class, 'createReview'])->name('customer.write.review');
    Route::get('/customer/calendar/{month?}', [CalendarController::class, 'index'])->name('customer.calendar');
});

Route::group(['middleware' => 'role:admin,customer,proprietary,commercial'], function (){
    Route::resources(['users' => UserController::class]);
    Route::post('/user/{id}/getKey', [UserController::class, 'getKey'])->name('user.getKey');
    Route::get("/listings/products", [ListingController::class, "showAdvertiserListings"])->name('advert.listings');
    Route::get('/listings/products/export-csv', [ListingController::class, 'exportToCsvFile'])->name('advert.export.csv');
    Route::post('/listings/products/upload-csv', [ListingController::class, 'uploadCsvFile'])->name('advert.upload.csv');

});


Route::resource ('listings', ListingController::class);

Route::middleware(['auth'])->group(function () {
    Route::post('/listings/bid', [ListingController::class, 'bid'])->name('listing.bid');
    Route::post('/listings/buy', [ListingController::class, 'buy'])->name('listing.buy');
    Route::post('/listings/rent', [ListingController::class, 'rent'])->name('listing.rent');
});

Route::get('/{customUrl?}', [MainController::class, 'index'])->name('home');

