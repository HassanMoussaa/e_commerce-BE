<?php

use App\Http\Controllers\CartController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\ProductController;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::controller(AuthController::class)->group(function () {
    Route::post('login', 'login');
    Route::post('register', 'register');
    Route::post('logout', 'logout');
    Route::post('refresh', 'refresh');
});


Route::middleware('auth:api')->group(function () {
    Route::get('/products', [ProductController::class, 'getProducts']);
    Route::delete('/products/delete/{id}', [ProductController::class, 'deleteProduct']);
    Route::post('/products/add', [ProductController::class, 'productsAdd']);
    Route::put('/products/update/{id}', [ProductController::class, 'productsUpdate']);
    Route::post('/add_to_cart', [CartController::class, 'addToCart']);
    Route::get('/cart_items', [CartController::class, 'getCartItems']);
});