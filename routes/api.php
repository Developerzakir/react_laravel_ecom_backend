<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\SizeController;
use App\Http\Controllers\Admin\TempImageController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::post('/admin/login',[AuthController::class,'authenticate']);

Route::group(['middleware'=>'auth:sanctum'], function(){
   Route::resource('categories',CategoryController::class);
   Route::resource('brands',BrandController::class);
   Route::resource('sizes',SizeController::class);
   Route::resource('products',ProductController::class);

   Route::post('temp-images',[TempImageController::class,'store']);
   
   //route for new image upload before product update
   Route::post('save-product-images',[ProductController::class,'saveProductImage']);

   //product default image route
   Route::get('change-product-default-images',[ProductController::class,'updateDefaultImage']);
});
