<?php

namespace App\Repositories;

use App\Models\Product;

class ProductRepository implements ProductRepositoryInterface
{
    public function all($perPage = 10)
    {
        return Product::paginate($perPage);
    }

    public function find($id)
    {
        return Product::with('category')->findOrFail($id);
    }

    public function create(array $data)
    {
        return Product::create($data);
    }

    public function update($id, array $data)
    {
        $product = Product::findOrFail($id);
        if($product)
        {
            return $product->update($data);
        }

        throw new \Exception("Category not found", 404);
    }

    public function delete($id)
    {
        $product = Product::findOrFail($id);
        if($product)
        {
            return $product->delete();
        }
        throw new \Exception("Category not found", 404);
    }

    public function getCategory($product_id)
    {
        return Product::findOrFail($product_id)->category;
    }

    public function filterByCategory($category_id, $perPage = 10)
    {
        return Product::where('category_id', $category_id)->paginate($perPage);
    }

    public function filterByPrice($minPrice, $maxPrice, $perPage = 10)
    {
        return Product::whereBetween('price', [$minPrice, $maxPrice])->paginate($perPage);
    }

    public function sortByPrice($order = 'asc', $perPage = 10)
    {
        return Product::orderBy('price', $order)->paginate($perPage);
    }

    public function searchByName($name, $perPage = 10)
    {
        return Product::where('name', 'like', "%$name%")->paginate($perPage);
    }
}
