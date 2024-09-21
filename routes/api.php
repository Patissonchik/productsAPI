<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;

// Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
//     return $request->user();
// });


Route::prefix('categories')->group(function () {
    Route::get('/', [CategoryController::class, 'index']);
    Route::post('/', [CategoryController::class, 'store']);
    Route::get('/{id}', [CategoryController::class, 'show']);
    Route::put('/{id}', [CategoryController::class, 'update']);
    Route::delete('/{id}', [CategoryController::class, 'destroy']);
    Route::get('/{id}/products', [CategoryController::class, 'getProducts']);
});

Route::prefix('products')->group(function () {
    Route::get('/', [ProductController::class, 'index']);
    Route::post('/', [ProductController::class, 'store']);
    Route::get('/{id}', [ProductController::class, 'show']);
    Route::put('/{id}', [ProductController::class, 'update']);
    Route::delete('/{id}', [ProductController::class, 'destroy']);

    Route::get('/category/{category_id}', [ProductController::class, 'filterByCategory']);
    Route::get('/price/{minPrice}/{maxPrice}', [ProductController::class, 'filterByPrice']);
    Route::get('/sort/{order}', [ProductController::class, 'sortByPrice']);
    Route::get('/search/{name}', [ProductController::class, 'searchProductByName']);
    Route::get('/{id}/category', [ProductController::class, 'getCategory']);
});
