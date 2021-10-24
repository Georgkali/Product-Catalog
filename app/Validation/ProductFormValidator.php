<?php

namespace App\Validation;

use App\Models\ProductCategories;

class ProductFormValidator
{
    private array $errors = [];
    private array $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function productName()
    {
        $name = $this->data['productName'];
        if (strlen($name) <= 0) {
            $this->errors['productName'] = 'Product name cant be empty string';
        }
    }

    public function category()
    {
        $category = $this->data['category'];
        if (!in_array($category, (new ProductCategories())->getCategories())) {
            $this->errors['category'] = 'invalid product category';
        }
    }

    public function qty()
    {
        $qty = $this->data['qty'];
        if ($qty == 0) {
            $this->errors['qty'] = 'Qty cant be 0';
        }
    }

    public function getErrors(): array
    {
        return $this->errors;
    }

    public function validator(): array
    {
        $this->productName();
        $this->category();
        $this->qty();
        return $this->getErrors();
    }
}