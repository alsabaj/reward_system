<?php

use App\Http\Controllers\OrderController;
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

Route::get('/users', [UserController::class, 'index'])->name('users.index');
Route::get('/users/{user_id}/rewards', [UserController::class, 'rewards'])->name('users.rewards');
Route::get('/orders/create', [OrderController::class, 'create'])->name('orders.create');
Route::post('/orders/create', [OrderController::class, 'store'])->name('orders.store');
Route::post('/orders/{order_id}/complete', [OrderController::class, 'markAsComplete'])->name('orders.markAsComplete');
Route::get('/', [OrderController::class, 'index'])->name('orders.index');
