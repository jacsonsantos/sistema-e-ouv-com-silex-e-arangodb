<?php

/**
 * Created by PhpStorm.
 * User: jacson
 * Date: 06/01/17
 * Time: 00:06
 */
namespace JSantos\Controllers;

use JSantos\Model\ArangoModel;
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
        $arango = new ArangoModel($this->app);

        $user = $arango->searchInDocument('user',['email'=>$data['email']]);

        if (!count($user)) {
            return new RedirectResponse('/login');
        }

        if (!password_verify($data['password'],$user[0]->password)) {
            return new RedirectResponse('/login');
        }

        $token = $this->app['auth']->generateToken($user[0]->_key);

        if ($this->app['session']->has('token')) {
            $this->app['session']->remove('token');
        }

        $this->app['session']->set('token',base64_encode($token));

        return new RedirectResponse('/admin');
    }

    public function getLoguot()
    {

        $this->app['session']->remove('token');

        return new RedirectResponse('/login');
    }

    public function getForgot(Request $request){
        return $this->app['twig']->render('login.twig');
    }
}