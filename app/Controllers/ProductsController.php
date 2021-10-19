<?php

namespace App\Controllers;

use App\Models\Product;
use App\Models\ProductCategories;
use App\Models\ProductsCollection;
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
        if (in_array($_POST['category'], (new ProductCategories())->getCategories())) {
            $this->productsRepository->addProduct(
                new Product(
                    Uuid::uuid4(),
                    $_POST['productName'],
                    $_POST['qty'],
                    $this->usersRepository->getUserId($_SESSION['name']),
                    $_POST['category'],
                    Carbon::now(),
                )
            );
            header('location: /main');
        } else {
            var_dump('invalid category');
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
    }

    public function edit(): void
    {
        $this->productsRepository->edit($_POST['id']);
        header("location: /{$_POST['id']}");
    }

}