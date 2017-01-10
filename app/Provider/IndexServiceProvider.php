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
use JSantos\Controllers\IndexController;

class IndexServiceProvider implements ServiceProviderInterface
{
    public function register(Container $pimple)
    {
        $pimple['index'] = function () use ($pimple) {
            return new IndexController($pimple);
        };
    }
}