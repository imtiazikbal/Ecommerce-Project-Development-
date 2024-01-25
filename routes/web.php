<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\PolicyController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Middleware\UserTokenVarification;
use App\Http\Controllers\ProductCartController;
use App\Http\Controllers\ProductWishController;
use App\Http\Controllers\CustomerProfileController;

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

//Backend Part
Route::get('/BrandList', [BrandController::class, 'BrandList']);
Route::get('/CategoryList', [CategoryController::class, 'CategoryList']);
Route::get('/PolicyByType', [PolicyController::class, 'PolicyByType']);
//Product Part
Route::get('/ProductByCategory', [ProductController::class, 'ProductByCategory']);
Route::get('/ProductByRemark', [ProductController::class, 'ProductByRemark']);
Route::get('/ProductByBrand', [ProductController::class, 'ProductByBrand']);
Route::get('/ProductSlider', [ProductController::class, 'ProductSlider']);
Route::get('/ProductById', [ProductController::class, 'ProductById']);
Route::get('/ListReviewByProduct', [ProductController::class, 'ListReviewByProduct']);

// User Part
Route::post('/UserLogin/{UserEmail}', [UserController::class, 'UserLogin']);
Route::post('/VarifyUser/{UserEmail}/{VarificationCode}', [UserController::class, 'VarifyUser']);
Route::get('/UserLogOut', [UserController::class, 'UserLogOut']);
//Customer Profile Part

Route::group(['middleware' => [UserTokenVarification::class]], function () {
    Route::post('/CustomerProfileCreate', [CustomerProfileController::class, 'CustomerProfileCreate']);
    Route::get('/ReadCustomerProfile', [CustomerProfileController::class, 'ReadCustomerProfile']);
    Route::get('/CreateReview', [ProductController::class, 'CreateProductReview']);
    Route::get('/WishList', [ProductWishController::class, 'WishList']);
    Route::post('/CreateWishList/{product_id}', [ProductWishController::class, 'CreateWishList']);
    Route::post('/RemoveWishList/{product_id}', [ProductWishController::class, 'RemoveWishList']);
    Route::post('/CreateProductCart', [ProductCartController::class, 'CreateProductCart']);
    Route::get('/CartProductList', [ProductCartController::class, 'CartProductList']);
    Route::post('/RemoveCartProduct/{product_id}', [ProductCartController::class, 'RemoveCartProduct']);
    Route::post('/InvoiceCreate', [InvoiceController::class, 'InvoiceCreate']);
    Route::get('/InvoiceList', [InvoiceController::class, 'InvoiceList']);
    Route::get('/InvoiceProductList/{invoice_id}', [InvoiceController::class, 'InvoiceProductList']);

    Route::post('/PaymentSuccess', [InvoiceController::class, 'PaymentSuccess']);
    Route::post('/PaymentFail', [InvoiceController::class, 'PaymentFail']);
    Route::post('/PaymentCancel', [InvoiceController::class, 'PaymentCancel']);
});
