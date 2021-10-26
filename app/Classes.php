<?php

namespace App;
use App\Models\ProductsCollection;
use App\Repositories\MysqlProductsRepositoryImplementation;
use App\Repositories\MysqlUsersRepositoryImplementation;
use App\Repositories\ProductsRepositoryInterface;
use App\Repositories\UsersRepositoryInterface;
use DI;

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
    UsersRepositoryInterface::class => DI\create(MysqlUsersRepositoryImplementation::class),
    ProductsRepositoryInterface::class => DI\create(MysqlProductsRepositoryImplementation::class)
];