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
        $this->verificy($request);

        return new JsonResponse([]);
    }

    public function getUsers(Request $request)
    {
        $this->verificy($request);
        $arango = $this->app['arango'];

        $docs = $arango->getAllDocument('users');

        $users = [];
        foreach ($docs as $doc) {
            array_push($users, ['name'=> $doc->name,'key'=> $doc->getId()]);
        }

        return new JsonResponse($users);
    }
    public function postUsers(Request $request)
    {
        $this->verificy($request);

        $user = $request->request->all();
        $user['password'] = password_hash($user['password'],PASSWORD_DEFAULT,['cost'=>12]);

        $arango = $this->app['arango'];

        if(!$arango->createDocument('users',$user)) {
            return new JsonResponse('error Token',401);
        }

        return new JsonResponse($user);
    }

    public function getDelete($key, Request $request)
    {
        $this->verificy($request);

        if (is_null($key)) {
            return new JsonResponse('error',401);
        }

        $arango = $this->app['arango'];

        if (!$arango->removeDocument(['users'=> $key])) {
            return new JsonResponse('error',401);
        }

        return $this->getUsers($request);
    }

    public function getOrgaos(Request $request)
    {
        $this->verificy($request);
        $arango = $this->app['arango'];

        $docs = $arango->getAllDocument('orgoas');
        $collections = [];
        foreach ($docs as $doc) {
            array_push($collections, ['name'=>$doc->name]);
        }

        return new JsonResponse($collections);
    }

    private function clearToken(Request $request)
    {
        $token = $request->headers->get('Authorization');
        $token = trim(str_replace("Bearer", "", $token));
        return base64_decode($token);
    }
    private function verificy(Request $request)
    {
        $token = $this->clearToken($request);

        if (!$this->app['auth']->validationToken($token)) {
            return new JsonResponse('error Token',401);
        }
    }
}