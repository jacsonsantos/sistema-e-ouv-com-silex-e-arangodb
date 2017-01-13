<?php

/**
 * Created by PhpStorm.
 * User: jacson
 * Date: 06/01/17
 * Time: 00:06
 */
namespace JSantos\Controllers;

use Silex\Application;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use JSantos\Model\ArangoModel;
class IndexController
{
    private $app;

    public function __construct(Application $application)
    {
        $this->app = $application;
    }

    public function getIndex(Request $request)
    {
        $arango = new ArangoModel($this->app);

        $user = [
            "email" => "jacsonk47@gmail.com",
            "password" => password_hash("jacson",PASSWORD_DEFAULT,['cost'=>15]),
        ];

        var_dump($arango->createDocument("users",$user));
        die();
//        return $this->app['twig']->render('index.twig');
    }
}