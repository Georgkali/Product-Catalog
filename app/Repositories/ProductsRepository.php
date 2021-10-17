<?php

namespace App\Repositories;

use App\Models\Product;
use App\Models\ProductsCollection;
use PDO;

class ProductsRepository extends MysqlRepository
{
    public function addProduct(Product $product)
    {
        $sql = "INSERT INTO products(id, product_name, qty, user_id, category, add_date, last_edit_date) VALUES (?,?,?,?,?,?,?)";
        $statement = $this->pdo->prepare($sql);
        $statement->execute([$product->getId(),
            $product->getProductName(),
            $product->getQty(),
            $product->getUserId(),
            $product->getCategory(),
            $product->getAddDate(),
            $product->getLastEditDate()]);
    }
    public function getProductsById($id): ProductsCollection  {
        $db = $this->pdo->query("SELECT * FROM products WHERE user_id = '$id'");
        $db->execute();
        $products = $db->fetchAll(PDO::FETCH_ASSOC);
        $collection = new ProductsCollection();
        foreach ($products as $product) {
            $collection->insertProduct((new Product(
               $product['id'],
                $product['product_name'],
                $product['qty'],
                $product['user_id'],
                $product['category'],
                $product['add_date'],
                $product['last_edit_date']
            )));
        }
        return $collection;
    }
}