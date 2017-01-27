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
use Symfony\Component\HttpFoundation\Response;

class AdminController
{
    private $app;

    public function __construct(Application $application)
    {
        $this->app = $application;
    }

    public function getIndex(Request $request)
    {
        return $this->app['twig']->render('admin.twig');
    }

    public function getToken(Request $request)
    {

        if (!$this->app['session']->has('token')) {
            return new JsonResponse('error',401);
        }
        $token = $this->app['session']->get('token');

        return new JsonResponse($token);
    }

    public function getCategory($slug, Request $request)
    {
        if (is_null($slug)) {
            return new RedirectResponse('/admin');
        }

        return $this->app['twig']->render('category.twig');
    }

    public function getPanel(Request $request)
    {
        $token = $this->clearToken($request);

        if (!$this->app['auth']->validationToken($token)) {
            return new JsonResponse('error Token',401);
        }

        return new JsonResponse([]);
    }

    private function clearToken(Request $request)
    {
        $token = $request->headers->get('Authorization');
        $token = trim(str_replace("Bearer", "", $token));
        return base64_decode($token);
    }
}