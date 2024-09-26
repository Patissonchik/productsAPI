<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @OA\Schema(
 *     schema="Category",
 *     type="object",
 *     title="Category",
 *     description="Схема для категории",
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         description="ID категории"
 *     ),
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
class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name'];
    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }
}
