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

class RouteServiceProvider implements ServiceProviderInterface
{
    public function register(Container $app)
    {
        $app->get('/',"index:getIndex");
        $app->get('/login',"index:getLogin");

        $app->mount('/admin', function ($admin) {
            $admin->get('/',"index:getAdmin");
            $admin->get('/category/{slug}',"index:getCategory")->value('slug',null);
        })->before(function (){
//                return new RedirectResponse('/login');
            });

    }
}