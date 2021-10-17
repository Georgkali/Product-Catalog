<?php

namespace App\Models;

class ProductCategories
{
    private array $categories;

    public function __construct()
    {
        $this->categories = [
            'a',
            'b',
            'c',
            'd'
        ];
    }

        public function getCategories(): array
    {
        return $this->categories;
    }
}