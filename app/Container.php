<?php

namespace App;

use App\Exceptions\ContainerException;
use DI\ContainerBuilder;
use Psr\Container\ContainerInterface;

class Container implements ContainerInterface
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
  public function get(string $id)
    {
        try {
            return $this->container->get($id);
        } catch (ContainerException $e) {
            $_SESSION['_errors'] = $e->getMessage();
            exit();
        }
    }
    public function has(string $id)
    {
    }

}

