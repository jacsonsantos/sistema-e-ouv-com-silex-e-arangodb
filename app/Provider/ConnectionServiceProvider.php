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
use triagens\ArangoDb\Connection as ArangoConnection;
use triagens\ArangoDb\ConnectionOptions as ArangoConnectionOptions;
use triagens\ArangoDb\Exception as ArangoException;
use triagens\ArangoDb\UpdatePolicy as ArangoUpdatePolicy;

class ConnectionServiceProvider implements ServiceProviderInterface
{
    public function register(Container $pimple)
    {
        $pimple['connection'] = function () {
            // set up some basic connection options
            $connectionOptions = [
                // database name
                ArangoConnectionOptions::OPTION_DATABASE => 'milagres_e_ouv',
                // server endpoint to connect to
                ArangoConnectionOptions::OPTION_ENDPOINT => 'tcp://127.0.0.1:8529',
                // authorization type to use (currently supported: 'Basic')
                ArangoConnectionOptions::OPTION_AUTH_TYPE => 'Basic',
                // user for basic authorization
                ArangoConnectionOptions::OPTION_AUTH_USER => 'root',
                // password for basic authorization
                ArangoConnectionOptions::OPTION_AUTH_PASSWD => '',
                // connection persistence on server. can use either 'Close' (one-time connections) or 'Keep-Alive' (re-used connections)
                ArangoConnectionOptions::OPTION_CONNECTION => 'Keep-Alive',
                // connect timeout in seconds
                ArangoConnectionOptions::OPTION_TIMEOUT => 3,
                // whether or not to reconnect when a keep-alive connection has timed out on server
                ArangoConnectionOptions::OPTION_RECONNECT => true,
                // optionally create new collections when inserting documents
                ArangoConnectionOptions::OPTION_CREATE => true,
                // optionally create new collections when inserting documents
                ArangoConnectionOptions::OPTION_UPDATE_POLICY => ArangoUpdatePolicy::LAST,
            ];

// turn on exception logging (logs to whatever PHP is configured)
            ArangoException::enableLogging();

            return new ArangoConnection($connectionOptions);
        };
    }
}