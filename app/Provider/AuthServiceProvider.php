<?php
/**
 * Created by PhpStorm.
 * User: jacson
 * Date: 05/01/17
 * Time: 23:59
 */
namespace JSantos\Provider;

use Pimple\ServiceProviderInterface;
use Pimple\Container;
use JSantos\Controllers\AuthController;

class AuthServiceProvider implements ServiceProviderInterface
{
    public function register(Container $pimple)
    {
        $pimple['auth'] = function () use ($pimple) {
            return new AuthController($pimple);
        };
    }
}