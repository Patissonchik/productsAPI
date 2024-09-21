<?php

namespace App\Repositories;

use App\Models\Category;

class CategoryRepository implements CategoryRepositoryInterface
{
    public function all()
    {
        return Category::with('products')->get();
    }
    public function find($id)
    {
        return Category::with('products')->findOrFail($id);
    }
    public function create(array $data)
    {
        return Category::create($data);
    }
    public function update($id, array $data)
    {
        $category = $this->find($id);
        if ($category) {
            $category->update($data);
            return $category;
        }

        throw new \Exception("Категория не найдена", 404);
    }
    public function delete($id)
    {
        $category = $this->find($id);
        if ($category) {
            return $category->delete();
        }

        throw new \Exception("Категория не найдена", 404);
    }
    public function getProducts($category_id)
    {
        return Category::findOrFail($category_id)->products;
    }
}
