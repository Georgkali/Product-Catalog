<?php

namespace App\Repositories;

use App\Models\Product;
use App\Models\ProductsCollection;
use App\Models\Tag;
use Carbon\Carbon;
use PDO;

class ProductsRepository extends MysqlRepository
{

    public function addTag(string $product_id, Tag $tag)
    {
        $sql = "INSERT INTO productidtagid(product_id, tag_id) VALUES (?,?)";
        $statement = $this->pdo->prepare($sql);
        $statement->execute([$product_id, $tag->getName()]);

    }

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

    public function getProductsById($id): ProductsCollection
    {
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

    public function delete(string $id): void
    {
        $sql = "DELETE FROM products WHERE id='$id'";
        $this->pdo->exec($sql);

    }

    public function edit(string $id)
    {
        $now = Carbon::now();
        $sql = "UPDATE products SET product_name='{$_POST['newProductName']}',
                                    category = '{$_POST['newCategory']}',
                                    qty = '{$_POST['newQty']}',
                                    last_edit_date = '$now' WHERE id='$id'";
        $this->pdo->exec($sql);
    }

    public function searchByCategory(string $category): ProductsCollection
    {
        $id = (new UsersRepository())->getUserId($_SESSION['name']);
        $products = $this->getProductsById($id)->getProducts();
        $collection = new ProductsCollection();
        foreach ($products as $product) {
            if ($product->getCategory() == $category) {
                $collection->insertProduct($product);
            }
        }
        return $collection;
    }

}