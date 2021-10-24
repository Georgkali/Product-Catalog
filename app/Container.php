<?php

namespace App;

use App\Exceptions\ContainerException;
use DI\ContainerBuilder;

class Container
{
    private array $classes;
    private \DI\Container $container;

    public function __construct()
    {
        $this->classes = require 'Classes.php';
        $builder = new ContainerBuilder();
        $builder->addDefinitions($this->classes);
        $this->container = $builder->build();

    }
    public function get(string $classname)
    {
        try {
            return $this->container->get($classname);
        } catch (ContainerException $e) {
            $_SESSION['_errors'] = $e->getMessage();
            exit();
        }
    }

}