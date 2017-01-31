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
        $app->post('/',"index:postIndex");

        $app->mount('/login', function($login) {
            $login->get('/',"login:getIndex");
            $login->post('/input',"login:postInput");
            $login->get('/loguot',"login:getLoguot");
            $login->get('/forgot',"login:getForgot");
        });

        $app->mount('/admin', function($admin) use($app) {
            $admin->get('/',"admin:getIndex");
            $admin->get('/token',"admin:getToken");
            $admin->get('/panel',"admin:getPanel");
            $admin->get('/users',"admin:getUsers");
            $admin->get('/users/{key}',"admin:getDelete")->value('key',null);
            $admin->post('/users',"admin:postUsers");
            $admin->get('/orgaos',"admin:getOrgaos");
            $admin->get('/category/{slug}',"admin:getCategory")->value('slug',null);
            $admin->before(function() use($app) {

                $token = '';
                if ($app['session']->has('token')) {
                    $token = base64_decode($app['session']->get('token'));
                }

                if (!$token) {
                    return new RedirectResponse('/login');
                }
                if (!$app['auth']->validationToken($token)) {
                    return new RedirectResponse('/login');
                }

            });
        });
    }
}