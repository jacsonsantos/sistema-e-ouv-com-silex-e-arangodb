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

class IndexController
{
    private $app;

    public function __construct(Application $application)
    {
        $this->app = $application;
    }

    public function getIndex(Request $request)
    {
        return $this->app['twig']->render('index.twig');
    }
}