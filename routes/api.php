<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


use App\Http\Controllers\UsersController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\AdministratorController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ShoppingCartController;
use App\Http\Controllers\ShoppingStoreController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ImagesController;
use App\Http\Controllers\GalleryController;

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


Route::resources([
    'users'             => UsersController::class,
    'customers'         => CustomerController::class,
    'administrators'    => AdministratorController::class,
    'shopping_stores'   => ShoppingStoreController::class,
    'carts'             => CartController::class,
    'shoppingcarts'     => ShoppingCartController::class,
    'products'          => ProductController::class,
    'wishlists'         => WishlistController::class,
    'transactions'      => TransactionController::class,
    'reviews'           => ReviewController::class,
    'categories'        => CategoryController::class,
    'images'            => ImagesController::class,
    'galleries'           => GalleryController::class,
]);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

