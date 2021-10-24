<?php

namespace App\Repositories;

use App\Models\Product;
use App\Models\ProductsCollection;
use App\Models\Tag;
use App\Models\TagsCollection;

interface ProductsRepositoryInterface
{
    public function addProduct(Product $product);

    public function getProductsById(string $id): ProductsCollection;

    public function delete(string $id);

    public function edit(array $data);

    public function searchByCategory(string $category): ProductsCollection;

    public function addTag(string $productId, Tag $tag);

    public function getTags(): TagsCollection;

}