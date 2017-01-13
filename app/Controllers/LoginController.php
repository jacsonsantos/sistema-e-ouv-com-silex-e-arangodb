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

class LoginController
{
    private $app;

    public function __construct(Application $application)
    {
        $this->app = $application;
    }

    public function getIndex(Request $request){
        return $this->app['twig']->render('login.twig');
    }
    public function postInput(Request $request)
    {
        $data  = $request->request->all();

        return new JsonResponse($data,200);
    }

    public function getLoguot(Request $request){
        return $this->app['twig']->render('login.twig');
    }

    public function getForgot(Request $request){
        return $this->app['twig']->render('login.twig');
    }
}