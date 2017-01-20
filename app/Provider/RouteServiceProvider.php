<?php
/**
 * Created by PhpStorm.
 * User: jacson
 * Date: 07/01/17
 * Time: 21:05
 */
namespace JSantos\Provider;

use Pimple\ServiceProviderInterface;
use Pimple\Container;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

class RouteServiceProvider implements ServiceProviderInterface
{
    public function register(Container $app)
    {
        $app->get('/',"index:getIndex");

        $app->mount('/login', function($login) {
            $login->get('/',"login:getIndex");
            $login->post('/input',"login:postInput");
            $login->get('/loguot',"login:getLoguot");
            $login->get('/forgot',"login:getForgot");
        });

        $app->mount('/admin', function($admin) use($app) {
            $admin->get('/',"admin:getIndex");
            $admin->get('/category/{slug}',"admin:getCategory")->value('slug',null);
            $admin->before(function() use($app) {

                if (!$app['session']->has('token')) {
                    return new RedirectResponse('/login');
                }

                $token = $app['session']->get('token');

                if (!$app['auth']->validationToken(base64_decode($token))) {
                    return new RedirectResponse('/login');
                }

            });
        });
    }
}