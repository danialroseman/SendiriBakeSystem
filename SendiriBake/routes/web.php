<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\CatalogueController;
use App\Http\Controllers\QuotaController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\TrackOrderController;


Route::get('/', [CatalogueController::class, 'index'])->name('customer.home');
Route::get('/admin', [HomeController::class, 'index'])->name('home');
//Manage product routes
Route::get('/manage-cat', [CatalogueController::class, 'manageCat'])->name('manage.catalogue');
Route::get('/add-product', [CatalogueController::class, 'addProduct'])->name('add.product');//for rendering page
Route::post('/add-product', [CatalogueController::class, 'storeProduct'])->name('product.store');//for form submission
Route::get('/edit-product/{Id}', [CatalogueController::class, 'editProduct'])->name('edit.product');
Route::get('/product/{id}/image', [CatalogueController::class, 'getImage'])->name('product.image');
Route::put('/update-product/{Id}', [CatalogueController::class, 'updateProduct'])->name('update.product');
Route::delete('/delete-product/{id}', [CatalogueController::class, 'deleteProduct'])->name('delete.product');
//Manage quota routes
Route::get('/edit-quota', [QuotaController::class, 'editQuota'])->name('edit.quota');
Route::post('/quota/update', [QuotaController::class, 'update'])->name('quota.update');
//Manage order routes
Route::get('/new-orders', [OrderController::class, 'newOrders'])->name('new.orders');
Route::post('/update-order-status', [OrderController::class, 'updateStatus'])->name('update.order.status');
Route::get('/active-orders', [OrderController::class, 'activeOrders'])->name('active.orders');
Route::post('/complete-order', [OrderController::class, 'completeOrder'])->name('complete.order');
//report routes
Route::get('/reports', [OrderController::class, 'reports'])->name('reports');

// Customer routes
//Route::middleware(['web'])->group(function () {
    Route::get('/customer', [CatalogueController::class, 'index'])->name('customer.home');
    Route::get('/checkout', [CheckoutController::class, 'showCheckout'])->name('customer.checkout');
    Route::get('/order', [TrackOrderController::class, 'showOrder'])->name('customer.order');

    //Track Order routes
    Route::post('/track-order', [TrackOrderController::class, 'trackOrder'])->name('customer.trackOrder');

    // Cart routes
    Route::post('/check-pickup-date', [OrderController::class, 'checkPickupDate'])->name('checkPickupDate');
    Route::post('/add-to-cart', [CartController::class, 'addToCart'])->name('addToCart');
    Route::get('/get-cart', [CartController::class, 'getCart'])->name('getCart');
    Route::post('/save-cart', [CartController::class, 'saveCart'])->name('saveCart');
    Route::post('/remove-from-cart', [CartController::class, 'removeFromCart'])->name('removeFromCart');

    // Place Order routes
    Route::post('/place-order', [OrderController::class, 'placeOrder'])->name('placeorder');

//});
