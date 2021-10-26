<?php

namespace App\Services;

use App\Models\Product;
use App\Models\ProductsCollection;
use App\Models\Tag;
use Carbon\Carbon;
use Ramsey\Uuid\Uuid;
use App\Container;

class ProductsControllerService
{
    private Container $container;

    private $productRepository;

    public function __construct()
    {
        $this->container = new Container();
        $this->productRepository = $this->container->get('productsRepository');
    }

    public function get(): ProductsCollection
    {
        return $this->container->get('productsRepository')->getProductsById($_SESSION['authId']);
    }

    public function addProduct(array $data)
    {

        $id = Uuid::uuid4();
        $this->productRepository->addProduct(
            new Product(
                $id,
                $data['productName'],
                $data['qty'],
                $_SESSION['authId'],
                $data['category'],
                Carbon::now(),
            ));

        if ($data['tags'] !== null) {
            foreach ($data['tags'] as $tag) {
                if (isset($tag)) {
                    $this->container->get('productsRepository')->addTag($id, new Tag($tag));
                }
            }
        }
    }

    public function getProductById(string $id): ProductsCollection
    {
        $collection = $this->container->get('productCollection');
        $products = $this->get()->getProducts();
        foreach ($products as $product) {
            if ($product->getId() == $id) {
                $collection->insertProduct($product);
            }
        }
        return $collection;
    }

    public function searchByTags(): ProductsCollection
    {
        $allTags = $this->container->get('productsRepository')->getTags()->getTags();
        $productsWithTags = [];

        foreach ($_POST['tags'] as $tag) {
            foreach ($allTags as $id) {
                if ($id->getTagId() == $tag) {

                    $productsWithTags[$id->getProductId()][] = $tag;
                }
            }
        }
        $collection = $this->container->get('productCollection');
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