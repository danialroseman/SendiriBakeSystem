<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\CatalogueController;
use App\Http\Controllers\QuotaController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\CartController;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/manage-cat', [CatalogueController::class, 'manageCat'])->name('manage.catalogue');
Route::get('/add-product', [CatalogueController::class, 'addProduct'])->name('add.product');//for rendering page
Route::post('/add-product', [CatalogueController::class, 'storeProduct'])->name('product.store');//for form submission
Route::get('/edit-product/{Id}', [CatalogueController::class, 'editProduct'])->name('edit.product');
Route::put('/update-product/{Id}', [CatalogueController::class, 'updateProduct'])->name('update.product');
Route::delete('/delete-product/{id}', [CatalogueController::class, 'deleteProduct'])->name('delete.product');
Route::get('/manage-quota', [QuotaController::class, 'manageQuota'])->name('manage.quota');
Route::get('/edit-quota', [QuotaController::class, 'editQuota'])->name('edit.quota');
Route::post('/edit-quota', [QuotaController::class, 'update'])->name('quota.update');
Route::get('/new-orders', [OrderController::class, 'newOrders'])->name('new.orders');
Route::get('/active-orders', [OrderController::class, 'activeOrders'])->name('active.orders');

// Customer routes
Route::middleware(['web'])->group(function () {
    Route::get('/customer', [CatalogueController::class, 'index'])->name('customer.home');
    Route::get('/checkout', [CheckoutController::class, 'showCheckout'])->name('customer.checkout');

    // Cart routes
    Route::post('/add-to-cart', [CartController::class, 'addToCart'])->name('add.to.cart');
    Route::get('/get-cart', [CartController::class, 'getCart'])->name('get.cart');
    Route::post('/save-cart', [CartController::class, 'saveCart'])->name('save.cart');
    Route::post('/remove-from-cart', [CartController::class, 'removeFromCart'])->name('remove-from-cart');

});
