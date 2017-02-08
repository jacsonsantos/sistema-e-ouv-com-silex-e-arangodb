<?php
/**
 * Created by PhpStorm.
 * User: jacson
 * Date: 02/02/2017
 * Time: 14:44
 */
namespace JSantos\Provider;

use Pimple\ServiceProviderInterface;
use Pimple\Container;
use JSantos\Controllers\ChatController;

class ChatServiceProvider implements ServiceProviderInterface
{
    public function register(Container $app)
    {
        $app['chat'] = new ChatController();
    }
}