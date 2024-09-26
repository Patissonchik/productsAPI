<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *     schema="UpdateProductRequest",
 *     type="object",
 *     title="Update Product Request",
 *     description="Запрос на обновление продукта",
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
 *         example="Новое описание товара A"
 *     ),
 *     @OA\Property(
 *         property="price",
 *         type="number",
 *         format="float",
 *         description="Цена продукта",
 *         example=249
 *     ),
 *     @OA\Property(
 *         property="category_id",
 *         type="integer",
 *         description="ID категории продукта",
 *         example=2
 *     )
 * )
 */

class UpdateProductRequest extends FormRequest
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
            'name' => 'sometimes|required|string|max:255',
            'description' => 'sometimes|nullable|string',
            'price' => 'sometimes|required|numeric|min:0',
            'category_id' => 'sometimes|required|exists:categories,id',
        ];
    }
}
