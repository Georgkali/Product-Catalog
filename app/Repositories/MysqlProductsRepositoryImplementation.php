<?php

namespace App\Repositories;

use App\Auth;
use App\Models\Product;
use App\Models\ProductsCollection;
use App\Models\Tag;
use App\Models\TagsCollection;
use Carbon\Carbon;
use App\Models\Database;
use PDO;

class MysqlProductsRepositoryImplementation extends Database implements ProductsRepositoryInterface
{

    public function addTag(string $productId, Tag $tag)
    {
        $sql = "INSERT INTO productidtagid(product_id, tag_id) VALUES (?,?)";
        $statement = $this->pdo->prepare($sql);
        $statement->execute([$productId, $tag->getTagid()]);

    }

    public function addProduct(Product $product): void
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

    public function getProductsById(string $id): ProductsCollection
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

    public function edit(array $data): void
    {
        $now = Carbon::now();
        $sql = "UPDATE products SET product_name='{$data['productName']}',
                                    category = '{$data['category']}',
                                    qty = '{$data['qty']}',
                                    last_edit_date = '$now' WHERE id='{$data['id']}'";
        $this->pdo->exec($sql);

    }

    public function searchByCategory(string $category): ProductsCollection
    {
        $id = (new MysqlUsersRepositoryImplementation())->getUserId(Auth::name());
        $products = $this->getProductsById($id)->getProducts();
        $collection = new ProductsCollection();
        foreach ($products as $product) {
            if ($product->getCategory() == $category) {
                $collection->insertProduct($product);
            }
        }
        return $collection;
    }

    public function getTags(): TagsCollection
    {
        $sql = "SELECT * FROM productidtagid";
        $db = $this->pdo->query($sql);
        $db->execute();
        $tags = $db->fetchAll(PDO::FETCH_ASSOC);
        $collection = new TagsCollection();
        foreach ($tags as $tag) {
            $collection->insertTag(
                new Tag(
                    $tag['tag_id'],
                    $tag['product_id']
                )
            );
        }
        return $collection;
    }


}