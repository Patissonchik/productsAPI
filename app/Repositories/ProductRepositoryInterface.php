<?php
namespace App\Repositories;

use App\Model\Product;

interface ProductRepositoryInterface
{
    public function all($perPage = 10);

    public function find($id);

    public function create(array $data);

    public function update($id, array $data);

    public function delete($id);

    public function getCategory($product_id);

    public function filterByCategory($category_id, $perPage = 10);

    public function filterByPrice($minPrice, $maxPrice, $perPage = 10);

    public function sortByPrice($order = 'asc', $perPage = 10);

    public function searchByName($name, $perPage = 10);

}
