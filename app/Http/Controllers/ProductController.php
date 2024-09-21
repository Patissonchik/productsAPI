<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Services\ProductService;
use Exception;


class ProductController extends Controller
{
    protected $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json($this->productService->getAllProducts());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
        try {
            $validatedData = $request->validate();
            $product = $this->productService->createProduct($validatedData);
            return response()->json($product, 201);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Продукт не был создан', 'error' => $e->getMessage()], 404);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try {
            $product = $this->productService->getProductById($id);
            return response()->json($product, 200);
        } catch (Exception $e) {
            return response()->json(['message' => 'Продукт не был найден', 'error' => $e->getMessage()], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, $id)
    {
        try {
            $validatedData = $request->validate();
            $product = $this->productService->updateProduct($id, $validatedData);
            return response()->json($product, 201);
        } catch (Exception $e) {
            if ($e->getCode() === 404) {
                return response()->json(['message' => 'Продукт не был найден', 'error' => $e->getMessage()], 404);
            }
            return response()->json(['message' => 'Непредвиденная ошибка'], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $this->productService->deleteProduct($id);
            return response()->json(['message' => 'Продукт удален'], 204);
        } catch (Exception $e) {
            if ($e->getCode() === 404) {
                return response()->json(['message' => 'Продукт не найден', 'error' => $e->getMessage()], 404);
            }
            return response()->json(['message' => 'Непредвиденная ошибка'], 500);
        }
    }

    public function getCategory($id)
    {
        try {
            $products = $this->productService->getCategoryForProduct($id);
            return response()->json($products, 200);
        } catch (Exception $e) {
            if ($e->getCode() === 404) {
                return response()->json(['message' => 'Продукты не найдены', 'error' => $e->getMessage()], 404);
            }
            return response()->json(['message' => 'Непредвиденная ошибка', 'error' => $e->getMessage()], 500);
        }
    }

    public function filterByCategory($category_id)
    {
        return response()->json($this->productService->getProductsFilteredByCategory($category_id), 200);
    }

    public function filterByPrice($minPrice, $maxPrice)
    {
        return response()->json($this->productService->getProductsFilteredByPrice($minPrice, $maxPrice), 200);
    }

    public function sortByPrice($order)
    {
        return response()->json($this->productService->getProductsSortByPrice($order));
    }

    public function searchProductByName($name)
    {
        return $this->productService->getProductByName($name);
    }
}
