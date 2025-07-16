<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
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
    Route::post('/get-all-by-category', [SubCategoryController::class, 'index']);         // Lấy tất cả sub
    Route::post('/', [SubCategoryController::class, 'store']);        // Tạo sub
    Route::get('/{id}', [SubCategoryController::class, 'show']);       // Chi tiết sub
    Route::put('/{id}', [SubCategoryController::class, 'update']);     // Cập nhật
    Route::delete('/{id}', [SubCategoryController::class, 'destroy']); // Xoá
});
