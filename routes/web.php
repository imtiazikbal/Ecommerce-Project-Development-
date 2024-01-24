<?php

use App\Models\Brand;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\PolicyController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Middleware\UserTokenVarification;
use App\Http\Controllers\ProductReviewController;
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
Route::get('/BrandList',[BrandController::class,'BrandList']);
Route::get('/CategoryList',[CategoryController::class,'CategoryList']);
Route::get('/PolicyByType',[PolicyController::class,'PolicyByType']);
//Product Part
Route::get('/ProductByCategory',[ProductController::class,'ProductByCategory']);
Route::get('/ProductByRemark',[ProductController::class,'ProductByRemark']);
Route::get('/ProductByBrand',[ProductController::class,'ProductByBrand']);
Route::get('/ProductSlider',[ProductController::class,'ProductSlider']);
Route::get('/ProductById',[ProductController::class,'ProductById']);
Route::get('/ListReviewByProduct',[ProductController::class,'ListReviewByProduct']);


// User Part
Route::post('/UserLogin/{UserEmail}',[UserController::class,'UserLogin']);
Route::post('/VarifyUser/{UserEmail}/{VarificationCode}',[UserController::class,'VarifyUser']);
Route::get('/UserLogut',[UserController::class,'UserLogut']);
//Customer Profile Part

Route::group(['middleware'=>[UserTokenVarification::class]],function(){
    Route::post('/CustomerProfileCreate',[CustomerProfileController::class,'CustomerProfileCreate']);
    Route::get('/ReadCustomerProfile',[CustomerProfileController::class,'ReadCustomerProfile']);
    Route::post('/CreateProductReview',[ProductController::class,'CreateProductReview']);
});