<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AuthController;

// Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

Route::prefix('categories')->group(function () {
    Route::get('/', [CategoryController::class, 'index']);
    Route::get('/{id}', [CategoryController::class, 'show']);
    Route::get('/{id}/products', [CategoryController::class, 'getProducts']);
});

Route::prefix('products')->group(function () {
    Route::get('/', [ProductController::class, 'index']);
    Route::get('/{id}', [ProductController::class, 'show']);

    Route::get('/category/{category_id}/{perPage?}', [ProductController::class, 'filterByCategory']);
    Route::get('/price/{minPrice}/{maxPrice}/{perPage?}', [ProductController::class, 'filterByPrice']);
    Route::get('/sort/{order}/{perPage?}', [ProductController::class, 'sortByPrice']);
    Route::get('/search/{name}/{perPage?}', [ProductController::class, 'searchProductByName']);
    Route::get('/{id}/category', [ProductController::class, 'getCategory']);
});

Route::middleware(['auth:sanctum', 'admin'])->group(function () {
    Route::prefix('products')->group(function () {
        Route::post('/', [ProductController::class, 'store']);
        Route::put('/{id}', [ProductController::class, 'update']);
        Route::delete('/{id}', [ProductController::class, 'destroy']);
    });

    Route::prefix('categories')->group(function () {
        Route::post('/', [CategoryController::class, 'store']);
        Route::put('/{id}', [CategoryController::class, 'update']);
        Route::delete('/{id}', [CategoryController::class, 'destroy']);
    });
});
