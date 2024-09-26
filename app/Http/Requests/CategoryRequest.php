<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *     schema="CategoryRequest",
 *     type="object",
 *     title="CategoryRequest",
 *     description="Запрос на создание/обновление категории",
 *     required={"name", "description"},
 *     @OA\Property(
 *         property="name",
 *         type="string",
 *         description="Название категории"
 *     ),
 *     @OA\Property(
 *         property="description",
 *         type="string",
 *         description="Описание категории"
 *     )
 * )
 */
class CategoryRequest extends FormRequest
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
            'name' => 'required|string|max:255'
        ];
    }
}
