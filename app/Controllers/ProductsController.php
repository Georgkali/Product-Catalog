<?php

namespace App\Controllers;

use App\Models\ProductsCollection;
use App\Models\TagsCollection;
use App\Container;
use App\Services\ProductsControllerService;


class ProductsController
{

    private Container $container;
    private ProductsControllerService $productsControllerService;

    public function __construct()
    {
        $this->container = new Container();
        $this->productsControllerService = new ProductsControllerService();
    }

    public function get(): ProductsCollection
    {
        return $this->productsControllerService->get();
    }

    public function addProduct()
    {
        $data = $_POST;
        var_dump($data);
        $this->productsControllerService->addProduct($data);
        header('location: /main');
    }

    public function getProductById(string $id): ProductsCollection
    {
        return $this->productsControllerService->getProductById($id);
    }

    public function delete(): void
    {
        $this->container->get('productsRepository')->delete($_POST['id']);
        header("location: /main");
    }

    public function edit(): void
    {
        $this->container->get('productsRepository')->edit($_POST);
        header("location: /main");
    }

    public function searchByCategory(): ProductsCollection
    {
        return $this->container->get('productsRepository')->searchByCategory($_POST['category']);
    }

    public function getProductTags(): TagsCollection
    {

        return $this->container->get('productsRepository')->getTags();
    }

    public function searchByTags(): ProductsCollection
    {
        return $this->productsControllerService->searchByTags();
    }

}