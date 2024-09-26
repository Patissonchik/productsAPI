<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Services\ProductService;
use Exception;

/**
 * @OA\Tag(name="Products", description="API для управления продуктами")
 */
class ProductController extends Controller
{
    protected $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    /**
     * @OA\Get(
     *     path="/products",
     *     summary="Получить список всех продуктов",
     *     tags={"Products"},
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
    public function index()
    {
        return response()->json($this->productService->getAllProducts());
    }

    /**
     * @OA\Post(
     *     path="/products",
     *     summary="Создать новый продукт",
     *     tags={"Products"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/StoreProductRequest")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Продукт успешно создан",
     *         @OA\JsonContent(ref="#/components/schemas/Product")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Ошибка создания продукта",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Продукт не был создан"),
     *             @OA\Property(property="error", type="string", example="Ошибка создания")
     *         )
     *     )
     * )
     */
    public function store(StoreProductRequest $request)
    {
        try {
            $validatedData = $request->validated();
            $product = $this->productService->createProduct($validatedData);
            return response()->json($product, 201);
        } catch (Exception $e) {
            return response()->json(['message' => 'Продукт не был создан', 'error' => $e->getMessage()], 404);
        }
    }

    /**
     * @OA\Get(
     *     path="/products/{id}",
     *     summary="Получить продукт по ID",
     *     tags={"Products"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer"),
     *         description="ID продукта"
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Данные продукта",
     *         @OA\JsonContent(ref="#/components/schemas/Product")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Продукт не найден",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Продукт не был найден"),
     *             @OA\Property(property="error", type="string", example="Ошибка получения продукта")
     *         )
     *     )
     * )
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
     * @OA\Put(
     *     path="/products/{id}",
     *     summary="Обновить продукт по ID",
     *     tags={"Products"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer"),
     *         description="ID продукта"
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/UpdateProductRequest")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Продукт успешно обновлен",
     *         @OA\JsonContent(ref="#/components/schemas/Product")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Продукт не найден",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Продукт не был найден"),
     *             @OA\Property(property="error", type="string", example="Ошибка обновления продукта")
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
    public function update(UpdateProductRequest $request, $id)
    {
        try {
            $validatedData = $request->validated();
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
     * @OA\Delete(
     *     path="/products/{id}",
     *     summary="Удалить продукт по ID",
     *     tags={"Products"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer"),
     *         description="ID продукта"
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Продукт успешно удален"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Продукт не найден",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Продукт не найден"),
     *             @OA\Property(property="error", type="string", example="Ошибка удаления продукта")
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

    /**
     * @OA\Get(
     *     path="/products/{id}/category",
     *     summary="Получить категорию продукта",
     *     tags={"Products"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer"),
     *         description="ID продукта"
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Категория продукта",
     *         @OA\JsonContent(ref="#/components/schemas/Category")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Продукт не найден",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Продукт не найден"),
     *             @OA\Property(property="error", type="string", example="Ошибка получения категории продукта")
     *         )
     *     )
     * )
     */
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

    /**
     * @OA\Get(
     *     path="/products/category/{category_id}",
     *     summary="Фильтрация продуктов по категории",
     *     tags={"Products"},
     *     @OA\Parameter(
     *         name="category_id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer"),
     *         description="ID категории"
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Продукты, отфильтрованные по категории",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Product"))
     *     )
     * )
     */
    public function filterByCategory($category_id)
    {
        return response()->json($this->productService->getProductsFilteredByCategory($category_id), 200);
    }

    /**
     * @OA\Get(
     *     path="/products/price-range",
     *     summary="Фильтрация продуктов по диапазону цен",
     *     tags={"Products"},
     *     @OA\Parameter(
     *         name="minPrice",
     *         in="query",
     *         required=true,
     *         @OA\Schema(type="number", format="float"),
     *         description="Минимальная цена"
     *     ),
     *     @OA\Parameter(
     *         name="maxPrice",
     *         in="query",
     *         required=true,
     *         @OA\Schema(type="number", format="float"),
     *         description="Максимальная цена"
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Продукты, отфильтрованные по диапазону цен",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Product"))
     *     )
     * )
     */
    public function filterByPrice($minPrice, $maxPrice)
    {
        return response()->json($this->productService->getProductsFilteredByPrice($minPrice, $maxPrice), 200);
    }

    /**
     * @OA\Get(
     *     path="/products/sort-by-price",
     *     summary="Сортировка продуктов по цене",
     *     tags={"Products"},
     *     @OA\Parameter(
     *         name="order",
     *         in="query",
     *         required=true,
     *         @OA\Schema(type="string", enum={"asc", "desc"}),
     *         description="Порядок сортировки: asc (по возрастанию) или desc (по убыванию)"
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Отсортированные продукты",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Product"))
     *     )
     * )
     */
    public function sortByPrice($order)
    {
        return response()->json($this->productService->getProductsSortByPrice($order), 200);
    }

    /**
     * @OA\Get(
     *     path="/products/search",
     *     summary="Поиск продукта по имени",
     *     tags={"Products"},
     *     @OA\Parameter(
     *         name="name",
     *         in="query",
     *         required=true,
     *         @OA\Schema(type="string"),
     *         description="Название продукта для поиска"
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Продукты, найденные по имени",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Product"))
     *     )
     * )
     */
    public function searchProductByName($name)
    {
        return response()->json($this->productService->getProductByName($name), 200);
    }
}
