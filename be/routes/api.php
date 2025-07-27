<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\BrandController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\SubCategoryController;

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

Route::prefix('categories')->group(function () {
    Route::get('/', [CategoryController::class, 'index']);         // Lấy tất cả danh mục + sub
    Route::post('/', [CategoryController::class, 'store']);        // Tạo danh mục
    Route::get('{id}', [CategoryController::class, 'show']);       // Chi tiết danh mục
    Route::put('{id}', [CategoryController::class, 'update']);     // Cập nhật
    Route::delete('{id}', [CategoryController::class, 'destroy']); // Xoá
});

Route::prefix('sub-categories')->group(function () {
    Route::post('/get-all-by-category', [SubCategoryController::class, 'index']);
    Route::post('/', [SubCategoryController::class, 'store']);
    Route::get('/{id}', [SubCategoryController::class, 'show']);
    Route::put('/{id}', [SubCategoryController::class, 'update']);
    Route::delete('/{id}', [SubCategoryController::class, 'destroy']);
});

Route::prefix('products')->group(function () {
    Route::get('/', [ProductController::class, 'index']);       
    Route::post('/', [ProductController::class, 'store']);      
    Route::get('/{id}', [ProductController::class, 'show']);       
    Route::put('/{id}', [ProductController::class, 'update']);    
    Route::delete('/{id}', [ProductController::class, 'destroy']); 
});

Route::prefix('brands')->group(function () {
    Route::get('/', [BrandController::class, 'index']);
    Route::post('/', [BrandController::class, 'store']);      
    Route::get('/{id}', [BrandController::class, 'show']);       
    Route::put('/{id}', [BrandController::class, 'update']);     
    Route::delete('/{id}', [BrandController::class, 'destroy']); 
});
