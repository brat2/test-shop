<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CartController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProductController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/products', [ProductController::class, 'index'])->name('products');

Route::get('/cart/add/{id}', [CartController::class, 'add'])->where('id', '[0-9]+');

Route::get('/cart/remove/{id}', [CartController::class, 'remove'])->where('id', '[0-9]+');

Route::get('/cart/{id?}', [CartController::class, 'show']);

Route::get('/carts', [CartController::class, 'showAll']);

Route::post('/login', [LoginController::class, 'login'])->name('login');
