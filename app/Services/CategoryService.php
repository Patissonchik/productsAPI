<?php
namespace App\Services;

use App\Repositories\CategoryRepositoryInterface;

class CategoryService
{
    protected $categoryRepository;

    public function __construct(CategoryRepositoryInterface $categoryRepositoryInterface)
    {
        $this->categoryRepository = $categoryRepositoryInterface;
    }

    public function getAllCategories()
    {
        return $this->categoryRepository->all();
    }

    public function getCategoryById($id)
    {
        return $this->categoryRepository->find($id);
    }

    public function createCategory($data)
    {
        return $this->categoryRepository->create($data);
    }

    public function updateCategory($category_id, $data)
    {
        return $this->categoryRepository->update($category_id, $data);
    }

    public function deleteCategory($category_id)
    {
        return $this->categoryRepository->delete($category_id);
    }

    public function getProductsForCategory($category_id)
    {
        $this->categoryRepository->getProducts($category_id);
    }
}
