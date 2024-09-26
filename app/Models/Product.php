<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @OA\Schema(
 *     schema="Product",
 *     type="object",
 *     title="Product",
 *     description="Схема для продукта",
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         description="ID продукта"
 *     ),
 *     @OA\Property(
 *         property="name",
 *         type="string",
 *         description="Название продукта"
 *     ),
 *     @OA\Property(
 *         property="price",
 *         type="number",
 *         format="float",
 *         description="Цена продукта"
 *     ),
 *     @OA\Property(
 *         property="category_id",
 *         type="integer",
 *         description="ID категории"
 *     )
 * )
 */
class Product extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'price', 'category_id'];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}
