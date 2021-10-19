<?php

namespace App\Controllers;

use App\Models\Product;
use App\Models\ProductCategories;
use App\Models\ProductsCollection;
use App\Models\Tag;
use App\Models\TagsCollection;
use App\Repositories\ProductsRepository;
use App\Repositories\UsersRepository;
use Carbon\Carbon;
use Ramsey\Uuid\Uuid;

class ProductsController
{

    private ProductsRepository $productsRepository;
    private UsersRepository $usersRepository;

    public function __construct()
    {
        $this->productsRepository = new ProductsRepository();
        $this->usersRepository = new UsersRepository();
    }

    public function get(): ProductsCollection
    {
        return $this->productsRepository->getProductsById($this->usersRepository->getUserId($_SESSION['name']));
    }

    public function addProduct()
    {
        $id = Uuid::uuid4();
        if (in_array($_POST['category'], (new ProductCategories())->getCategories()) && !empty($_POST['productName'])) {
            $this->productsRepository->addProduct(
                new Product(
                    $id,
                    $_POST['productName'],
                    $_POST['qty'],
                    $this->usersRepository->getUserId($_SESSION['name']),
                    $_POST['category'],
                    Carbon::now(),
                ));

            foreach ($_POST['tags'] as $tag) {
                if (isset($tag)) {
                    $this->productsRepository->addTag($id, new Tag($tag));
                }
            }

           header('location: /main');
        } else {
            echo 'invalid category';
            header('location: /main');
        }
    }

    public function getProductById(string $id): ProductsCollection
    {
        $collection = new ProductsCollection();
        $products = $this->get()->getProducts();
        foreach ($products as $product) {
            if ($product->getId() == $id) {
                $collection->insertProduct($product);
            }
        }
        return $collection;
    }

    public function delete(): void
    {
        $this->productsRepository->delete($_POST['id']);
        header("location: /main");
    }

    public function edit(): void
    {
        $this->productsRepository->edit($_POST['id']);
        header("location: /main");
    }

    public function searchByCategory(): ProductsCollection
    {

        return $this->productsRepository->searchByCategory($_POST['category']);
    }
    public function getProductTags(): TagsCollection {

          // var_dump($this->productsRepository->getTags()->getTags());
           return $this->productsRepository->getTags();
    }

}