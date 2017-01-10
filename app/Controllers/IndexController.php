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
//        $data = $request->query->all();
//        return new Response($this->app['serializer']->serialize($data, $format));
        return $this->app['twig']->render('index.twig');
    }

    public function getAdmin(Request $request){
        return $this->app['twig']->render('admin.twig');
    }

    public function getCategory($slug, Request $request){
        if (is_null($slug)) {
            return new RedirectResponse('/admin');
        }

        return $this->app['twig']->render('category.twig');
    }

    public function getLogin(Request $request){
        return $this->app['twig']->render('login.twig');
    }
}