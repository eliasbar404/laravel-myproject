<?php

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


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
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
Route::get('/add' ,fn()=> view("Store"));


Route::resources([
    'users'             => UsersController::class,
    'customers'         => CustomerController::class,
    'administrators'    => AdministratorController::class,
    'shoppingstores'    => ShoppingStoreController::class,
    'carts'             => CartController::class,
    'shoppingcarts'     => ShoppingCartController::class,
    'products'          => ProductController::class,
    'wishlists'         => WishlistController::class,
    'transactions'      => TransactionController::class,
    'reviews'           => ReviewController::class,
    'categories'        => CategoryController::class,
    'images'            => ImagesController::class,
]);





























