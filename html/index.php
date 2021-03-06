<?php
chdir(dirname(__DIR__));
    require "vendor/autoload.php";

use Silex\Application;

    $app = new Application;
    $app['debug'] = true;

    $app->register(new Silex\Provider\TwigServiceProvider(), array(
        'twig.path' => __DIR__.'/../views',
    ));
    $app->register(new Silex\Provider\SerializerServiceProvider());
    $app->register(new \JSantos\Provider\ConnectionServiceProvider());
    $app->register(new \JSantos\Provider\IndexServiceProvider());
    $app->register(new \JSantos\Provider\AdminServiceProvider());
    $app->register(new \JSantos\Provider\LoginServiceProvider());
    $app->register(new \JSantos\Provider\RouteServiceProvider());
    $app->register(new \JSantos\Provider\AuthServiceProvider());
    $app->register(new \JSantos\Provider\ArangoModelServiceProvider());
    $app->register(new \JSantos\Provider\ChatServiceProvider());
    $app->register(new Silex\Provider\ServiceControllerServiceProvider());
    $app->register(new Silex\Provider\SessionServiceProvider());

    $app->run();