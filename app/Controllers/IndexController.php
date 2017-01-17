<?php

/**
 * Created by PhpStorm.
 * User: jacson
 * Date: 06/01/17
 * Time: 00:06
 */
namespace JSantos\Controllers;

use Silex\Application;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use JSantos\Model\ArangoModel;

class IndexController
{
    private $app;

    public function __construct(Application $application)
    {
        $this->app = $application;
    }

    public function getIndex()
    {
        $arango = new ArangoModel($this->app);

        $aql = 'FOR u IN @@collection FILTER u.name == @name RETURN u';

        $arango = $arango->prepare($aql);
        $arango->bindCollection(['collection'=>'users']);
        $arango->bindValue(['name'=>'jacson']);
        $arango->bindValue(['age'=>22]);
        $arango->execute();


        return $this->app['twig']->render('index.twig');
    }
}