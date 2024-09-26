<?php

namespace App\Http\Controllers;

use App\Services\CategoryService;
use App\Http\Requests\CategoryRequest;
use Exception;

/**
 * @OA\Tag(name="Categories", description="API для управления категориями")
 */
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
    /**
     * @OA\Get(
     *     path="/categories",
     *     summary="Получить список всех категорий",
     *     tags={"Categories"},
     *     @OA\Response(
     *         response=200,
     *         description="Список категорий",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Category")
     *         )
     *     )
     * )
     */
    public function index()
    {
        return response()->json($this->categoryService->getAllCategories());
    }

    /**
     * @OA\Post(
     *     path="/categories",
     *     summary="Создать новую категорию",
     *     tags={"Categories"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/CategoryRequest")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Категория успешно создана",
     *         @OA\JsonContent(ref="#/components/schemas/Category")
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Ошибка создания категории",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Категория не была создана"),
     *             @OA\Property(property="error", type="string", example="Ошибка создания")
     *         )
     *     )
     * )
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
     * @OA\Get(
     *     path="/categories/{id}",
     *     summary="Получить категорию по ID",
     *     tags={"Categories"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer"),
     *         description="ID категории"
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Данные категории",
     *         @OA\JsonContent(ref="#/components/schemas/Category")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Категория не найдена",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Категория не найдена"),
     *             @OA\Property(property="error", type="string", example="Ошибка получения категории")
     *         )
     *     )
     * )
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
     * @OA\Put(
     *     path="/categories/{id}",
     *     summary="Обновить категорию по ID",
     *     tags={"Categories"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer"),
     *         description="ID категории"
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/CategoryRequest")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Категория успешно обновлена",
     *         @OA\JsonContent(ref="#/components/schemas/Category")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Категория не найдена",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Категория не найдена"),
     *             @OA\Property(property="error", type="string", example="Ошибка обновления категории")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Непредвиденная ошибка",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Непредвиденная ошибка"),
     *             @OA\Property(property="error", type="string", example="Ошибка сервера")
     *         )
     *     )
     * )
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
     * @OA\Delete(
     *     path="/categories/{id}",
     *     summary="Удалить категорию по ID",
     *     tags={"Categories"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer"),
     *         description="ID категории"
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Категория успешно удалена"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Категория не найдена",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Категория не найдена"),
     *             @OA\Property(property="error", type="string", example="Ошибка удаления категории")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Непредвиденная ошибка",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Непредвиденная ошибка"),
     *             @OA\Property(property="error", type="string", example="Ошибка сервера")
     *         )
     *     )
     * )
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

    /**
     * @OA\Get(
     *     path="/categories/{id}/products",
     *     summary="Получить все продукты для категории",
     *     tags={"Categories"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer"),
     *         description="ID категории"
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Список продуктов",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Product")
     *         )
     *     )
     * )
     */
    public function getProducts($id)
    {
        return response()->json($this->categoryService->getProductsForCategory($id));
    }
}
