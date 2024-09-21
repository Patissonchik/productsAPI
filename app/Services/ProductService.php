<?php
namespace App\Services;

use App\Repositories\ProductRepositoryInterface;

class ProductService
{
    protected $productRepository;

    public function __construct(ProductRepositoryInterface $productRepositoryInterface)
    {
        $this->productRepository = $productRepositoryInterface;
    }

    public function getAllProducts()
    {
        return $this->productRepository->all();
    }

    public function getProductById($id)
    {
        return $this->productRepository->find($id);
    }

    public function createProduct($data)
    {
        return $this->productRepository->create($data);
    }

    public function updateProduct($id, $data)
    {
        return $this->productRepository->update($id, $data);
    }

    public function deleteProduct($id)
    {
        return $this->productRepository->delete($id);
    }

    public function getCategoryForProduct($product_id)
    {
        return $this->productRepository->getCategory($product_id);
    }

    public function getProductsFilteredByCategory($category_id)
    {
        return $this->productRepository->filterByCategory($category_id);
    }

    public function getProductsFilteredByPrice($minPrice, $maxPrice)
    {
        return $this->productRepository->filterByPrice($minPrice, $maxPrice);
    }

    public function getProductsSortByPrice($order)
    {
        return $this->productRepository->sortByPrice($order);
    }

    public function getProductByName($name)
    {
        return $this->productRepository->searchByName($name);
    }
}
