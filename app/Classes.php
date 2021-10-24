<?php

namespace App;
use App\Models\Product;
use App\Models\ProductsCollection;
use App\Repositories\MysqlProductsRepositoryImplementation;
use App\Repositories\MysqlUsersRepositoryImplementation;
use Carbon\Carbon;
use DI;
use Ramsey\Uuid\Uuid;

return [
    'productsRepository' => DI\factory(function () {
        return new MysqlProductsRepositoryImplementation();
    }),
    'usersRepository' => DI\factory(function () {
       return new MysqlUsersRepositoryImplementation();
    }),
    'productCollection' => DI\factory(function () {
        return new ProductsCollection();
    }),
    'product' => DI\factory(function () {
        $id = Uuid::uuid4();
        return new Product($id,
            $_POST['productName'],
            $_POST['qty'],
            $_SESSION['authId'],
            $_POST['category'],
            Carbon::now());
    })

];