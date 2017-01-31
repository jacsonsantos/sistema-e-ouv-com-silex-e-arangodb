<?php
/**
 * Created by PhpStorm.
 * User: jacson
 * Date: 30/01/2017
 * Time: 14:52
 */
namespace JSantos\Provider;

use Pimple\Container;
use Pimple\ServiceProviderInterface;
use JSantos\Model\ArangoModel;

class ArangoModelServiceProvider implements ServiceProviderInterface
{
    public function register(Container $app)
    {
        return $app['arango'] = new ArangoModel($app);
    }
}