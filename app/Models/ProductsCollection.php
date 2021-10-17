<?php

namespace App\Models;


class ProductsCollection
{
    private ?array $products;

    public function __construct(array $products = [])
    {
        $this->products = $products;
    }

    public function insertProduct(Product $product)
    {
        $this->products[] = $product;
    }

    public function getProducts(): ?array
    {
        return $this->products;
    }
}