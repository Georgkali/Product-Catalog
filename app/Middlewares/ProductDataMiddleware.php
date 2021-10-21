<?php

namespace App\Middlewares;

class ProductDataMiddleware
{
    private array $data;
    private array $modData;
    private array $fields = ['productName', 'qty', 'category'];

    public function __construct(array $data)
    {
        $this->data = $data;
    }



    public function NameMod()
    {
        $productName = $this->data['productName'];
        $productName = trim(strtolower($productName));
        $this->addToModData('productName', $productName);
    }
    public function qtyMod() {
        $qty = $this->data['qty'];
        $qty = abs($qty);
        $this->addToModData('qty', $qty);
    }
    public function categoryMod() {
        $category = $this->data['category'];
        if(!in_array($category, ['a', 'b', 'c',])) {
            $category = '-';
        }
        $this->addToModData('category', $category);
    }

    private function addToModData(string $key, $value)
    {
        $this->modData[$key] = $value;
    }

    public function productDataMiddleware(): array {
        $this->NameMod();
        $this->qtyMod();
        $this->categoryMod();
        var_dump('iwasher');
        return $this->modData;
    }


}