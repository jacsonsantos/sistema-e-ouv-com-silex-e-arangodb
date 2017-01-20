<?php

/**
 * Created by PhpStorm.
 * User: jacson
 * Date: 06/01/17
 * Time: 00:06
 */
namespace JSantos\Controllers;

use Lcobucci\JWT\Parser;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Silex\Application;
use Lcobucci\JWT\Builder;

class AuthController
{
    /**
     * @var Application
     */
    private $app;
    /**
     * @var Sha256
     */
    private $signer;

    /**
     * AuthController constructor.
     * @param Application $application
     */
    public function __construct(Application $application)
    {
        $this->app = $application;
        $this->signer = new Sha256();
    }

    /**
     * @param $key
     * @param string $secret
     * @return \Lcobucci\JWT\Token
     */
    public function generateToken($key, $secret = 'q521jf7wpk')
    {
        $builder = new Builder();
        $token = $builder
            ->setIssuer('http://localhost:4040')
            ->setAudience('http://localhost:4040')
            ->setId('4f1g23a12aa', true)
            ->setIssuedAt(time())
            ->setNotBefore(time() + 60)
            ->setExpiration(time() + 3600)
            ->set('uid', $key)
            ->sign($this->signer, $secret)
            ->getToken();

        return $token;
    }

    /**
     * @param $token
     * @param string $secret
     * @return bool
     */
    public function validationToken($token, $secret = 'q521jf7wpk')
    {
        $parse = (new Parser())->parse($token);
        return $parse->verify($this->signer, $secret);
    }
}