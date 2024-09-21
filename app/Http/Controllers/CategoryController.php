<?php

namespace App\Http\Controllers;

use App\Services\CategoryService;
use App\Http\Requests\CategoryRequest;
use Exception;

class CategoryController extends Controller
{
    protected $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json($this->categoryService->getAllCategories());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoryRequest $request)
    {
        try {
            $validatedData = $request->validated();
            $category = $this->categoryService->createCategory($validatedData);

            return response()->json($category, 201);
        } catch (Exception $e) {
            return response()->json(['message' => 'Категория не была создана', 'error' => $e->getMessage()], 400);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try {
            $category = $this->categoryService->getCategoryById($id);
            return response()->json($category, 200);
        } catch (Exception $e) {
            return response()->json(['message' => 'Категория не найдена', 'error' => $e->getMessage()], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CategoryRequest $request, string $id)
    {
        try {
            $category = $this->categoryService->updateCategory($id, $request->validated());
            return response()->json($category, 201);
        } catch (Exception $e) {
            if ($e->getCode() === 404) {
                return response()->json(['message' => 'Категория не найдена', 'error' => $e->getMessage()], 404);
            }
            return response()->json(['message' => 'Непредвиденная ошибка'], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $this->categoryService->deleteCategory($id);
            return response()->json(['message' => 'Категория удалена'], 204);
        } catch (Exception $e) {
            if ($e->getCode() === 404) {
                return response()->json(['message' => 'Категория не найдена', 'error' => $e->getMessage()], 404);
            }
            return response()->json(['message' => 'Непредвиденная ошибка'], 500);
        }
    }

    public function getProducts($id)
    {
        return response()->json($this->categoryService->getProductsForCategory($id));
    }
}
