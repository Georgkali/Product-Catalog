<?php

namespace App\Controllers;

use App\Models\Product;
use App\Models\ProductCategories;
use App\Models\ProductsCollection;
use App\Models\Tag;
use App\Models\TagsCollection;
use App\Repositories\MysqlProductsRepositoryImplementation;
use App\Repositories\ProductsRepositoryInterface;
use Carbon\Carbon;
use Ramsey\Uuid\Uuid;

class ProductsController
{

    private ProductsRepositoryInterface $productsRepository;

    public function __construct()
    {
        $this->productsRepository = new MysqlProductsRepositoryImplementation();
    }

    public function get(): ProductsCollection
    {
        return $this->productsRepository->getProductsById($_SESSION['authId']);
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
                    $_SESSION['authId'],
                    $_POST['category'],
                    Carbon::now(),
                ));

            foreach ($_POST['tags'] as $tag) {
                if (isset($tag)) {
                    $this->productsRepository->addTag($id, new Tag($tag));
                }
            }

        } else {
            echo 'invalid category';
        }
        header('location: /main');
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
        $this->productsRepository->edit($_POST);
        header("location: /main");
    }

    public function searchByCategory(): ProductsCollection
    {
        return $this->productsRepository->searchByCategory($_POST['category']);
    }

    public function getProductTags(): TagsCollection
    {

        return $this->productsRepository->getTags();
    }

    public function searchByTags(): ProductsCollection
    {
        $allTags = $this->productsRepository->getTags()->getTags();
        $productsWithTags = [];

        foreach ($_POST['tags'] as $tag) {
            foreach ($allTags as $id) {
                if ($id->getTagId() == $tag) {

                    $productsWithTags[$id->getProductId()][] = $tag;
                }
            }
        }
        $collection = new ProductsCollection();
        foreach ($productsWithTags as $productID => $tags) {
            if (count($tags) == count($_POST['tags'])) {
                $products = $this->get()->getProducts();
                foreach ($products as $product) {
                    if ($product->getId() == $productID) {
                        $collection->insertProduct($product);
                    }
                }
            }
        }
        return $collection;

    }

}