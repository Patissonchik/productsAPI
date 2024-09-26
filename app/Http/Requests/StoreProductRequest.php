<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
/**
 * @OA\Schema(
 *     schema="StoreProductRequest",
 *     type="object",
 *     title="Store Product Request",
 *     description="Запрос на создание нового продукта",
 *     required={"name", "price", "category_id"},
 *     @OA\Property(
 *         property="name",
 *         type="string",
 *         description="Название продукта",
 *         example="Товар A"
 *     ),
 *     @OA\Property(
 *         property="description",
 *         type="string",
 *         description="Описание продукта",
 *         example="Описание товара A"
 *     ),
 *     @OA\Property(
 *         property="price",
 *         type="number",
 *         format="float",
 *         description="Цена продукта",
 *         example=199
 *     ),
 *     @OA\Property(
 *         property="category_id",
 *         type="integer",
 *         description="ID категории продукта",
 *         example=1
 *     )
 * )
 */

class StoreProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
        ];
    }
}
