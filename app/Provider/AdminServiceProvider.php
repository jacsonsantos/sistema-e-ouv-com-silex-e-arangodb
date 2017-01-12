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
use JSantos\Controllers\AdminController;

class AdminServiceProvider implements ServiceProviderInterface
{
    public function register(Container $pimple)
    {
        $pimple['admin'] = function () use ($pimple) {
            return new AdminController($pimple);
        };
    }
}