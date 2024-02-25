<?php

use App\Events\NewOrderCreated;
use App\Http\Controllers\KitchenOrderController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\UserController;
use App\Models\Order;
use App\Http\Controllers\ExpenseCategoryController;
use App\Http\Controllers\Invoice\InvoiceController;
use App\Http\Controllers\PrintController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// Redirect from '/' to '/admin'
Route::redirect('/', '/admin');

Auth::routes();

Route::prefix('/admin')->middleware('auth')->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
    Route::post('/settings', [SettingController::class, 'store'])->name('settings.store');
    Route::resource('products', ProductController::class);
    Route::get('/search-products', 'ProductController@search')->name('search.products');
    Route::resource('users', UserController::class);
    Route::resource('roles', RoleController::class);
    Route::resource('customers', CustomerController::class);
    Route::resource('orders', OrderController::class);
    Route::get('/orders/filter', [OrderController::class, 'show'])->name('orders.filter');
    Route::patch('/order/{id}', 'OrderController@update')->name('order.update');
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart', [CartController::class, 'store'])->name('cart.store');
    Route::post('/cart/change-qty', [CartController::class, 'changeQty']);
    Route::delete('/cart/delete', [CartController::class, 'delete']);
    Route::delete('/cart/empty', [CartController::class, 'empty']);
    // routes/web.php
    // Kitchen Orders routes
    Route::get('/kitchen', [KitchenOrderController::class, 'index'])->name('kitchen.index');
    // Route::get('/kitchen/{id}', [KitchenOrderController::class, 'show'])->name('kitchen.show');
    Route::patch('/kitchen/{id}', [KitchenOrderController::class, 'update'])->name('kitchen.update');
    Route::get('/get-pending-orders', [KitchenOrderController::class, 'getPendingOrders'])->name('kitchen.getPendingOrders');
    // Route::get('event', function(){
    //     NewOrderCreated::dispatch(Order::find(1));
    // });
    // Route::get('/expenses', 'ExpenseController@index')->name('expenses.index');
    Route::get('/expenses', [ExpenseController::class, 'index'])->name('expenses.index');
    // Route::post('/expenses/get', 'ExpenseController@getExpenses')->name('expenses.get');
    Route::get('/expenses/get', [ExpenseController::class, 'getExpenses'])->name('expenses.get');
    Route::post('/expenses', [ExpenseController::class, 'store'])->name('expenses.store');
    // Routes for expense categories
    Route::resource('expense-categories', ExpenseCategoryController::class)->except(['create']);
    // Route::post('/print', [InvoiceController::class, 'printInvoice'])->name('print.invoice');
    Route::post('/print', [PrintController::class, 'printInvoice'])->name('print.invoice');

});

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
