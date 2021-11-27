<?php

use App\Http\Controllers\IndexController;
use App\Http\Controllers\LogController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\StorageController;
use App\Http\Controllers\UserController;
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

// Можно было бы использовать ресурс-контроллеры, но мне больше нравится обычные роуты, мне кажется что они более гибкие

Route::get('/', [IndexController::class, 'index'])->name('index');

// ЛОГИ
Route::get('/logs', [LogController::class, 'index'])->name('logs');

// СКЛАДЫ
Route::get('/storages', [StorageController::class, 'index'])->name('storages');
Route::get('/storages/{storage}', [StorageController::class, 'storage'])->name('storages.storage');
Route::get('/storages/{storage}/add', [StorageController::class, 'addProduct'])->name('storages.storage.product');
Route::post('/storages/{storage}', [StorageController::class, 'add'])->name('storages.storage.add');
Route::get('/storages/{storage}/move/{product}', [StorageController::class, 'moveProduct'])->name('storages.storage.move.product');
Route::post('/storages/{storage}/move/{product}', [StorageController::class, 'move'])->name('storages.storage.move');
Route::get('/storages/{storage}/history', [StorageController::class, 'history'])->name('storages.storage.history');
Route::get('/storages/{storage}/history/{product}', [StorageController::class, 'productHistory'])->name('storages.storage.product.history');

// ЗАКАЗЫ
Route::get('/orders', [OrderController::class, 'index'])->name('orders');
Route::get('/orders/create', [OrderController::class, 'create'])->name('orders.create');
Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
Route::get('/orders/{order}/edit', [OrderController::class, 'edit'])->name('orders.edit');
Route::put('/orders/{order}', [OrderController::class, 'update'])->name('orders.update');
Route::post('/orders/gethistory', [OrderController::class, 'getHistory'])->name('orders.get.history');
Route::get('/orders/history', [OrderController::class, 'history'])->name('orders.history');

Route::prefix('tools')->group(function () {

    // ПОЛЬЗОВАТЕЛИ
    Route::get('/users', [UserController::class, 'index'])->name('users');
    Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
    Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');

    // СКЛАДЫ
    Route::get('/storages', [StorageController::class, 'indexTools'])->name('storages.tools');
    Route::get('/storages/create', [StorageController::class, 'create'])->name('storages.create');
    Route::post('/storages', [StorageController::class, 'store'])->name('storages.store');
    Route::get('/storages/{storage}/edit', [StorageController::class, 'edit'])->name('storages.edit');
    Route::put('/storages/{storage}', [StorageController::class, 'update'])->name('storages.update');
    Route::delete('/storages/{storage}', [StorageController::class, 'destroy'])->name('storages.destroy');

    // ПРОДУКТЫ
    Route::get('/products', [ProductController::class, 'index'])->name('products');
    Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
    Route::post('/products', [ProductController::class, 'store'])->name('products.store');
    Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
    Route::put('/products/{product}', [ProductController::class, 'update'])->name('products.update');
    Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');

    // ТИПЫ ЛОГОВ
    Route::get('/logs-type', [LogController::class, 'indexTypes'])->name('logs.type.index');
    Route::get('/logs-type/create', [LogController::class, 'create'])->name('logs.type.create');
    Route::post('/logs-type', [LogController::class, 'store'])->name('logs.type.store');
    Route::get('/logs-type/{type}/edit', [LogController::class, 'edit'])->name('logs.type.edit');
    Route::put('/logs-type/{type}', [LogController::class, 'update'])->name('logs.type.update');
    Route::delete('/logs-type/{type}', [LogController::class, 'destroy'])->name('logs.type.destroy');
    
});

