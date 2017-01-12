<?php

/**
 * Created by PhpStorm.
 * User: jacson
 * Date: 06/01/17
 * Time: 00:06
 */
namespace JSantos\Controllers;

use Lcobucci\JWT\Parser;
use Lcobucci\JWT\Signer\Rsa\Sha256;
use Silex\Application;
use Lcobucci\JWT\Builder;

class AuthController
{
    private $app;
    private $signer;

    public function __construct(Application $application)
    {
        $this->app = $application;
        $this->signer = new Sha256();
    }

    public function generateToken($key, $secret = 'q521jf7wpk')
    {
        $token = (new Builder())
            ->setIssuer('http://localhost:4040') // Configures the issuer (iss claim)
            ->setAudience('http://localhost:4040') // Configures the audience (aud claim)
            ->setId('4f1g23a12aa', true) // Configures the id (jti claim), replicating as a header item
            ->setIssuedAt(time()) // Configures the time that the token was issue (iat claim)
            ->setNotBefore(time() + 60) // Configures the time that the token can be used (nbf claim)
            ->setExpiration(time() + 3600) // Configures the expiration time of the token (nbf claim)
            ->set('uid', $key) // Configures a new claim, called "uid"
            ->sign($this->signer, $secret) // creates a signature using "testing" as key
            ->getToken(); // Retrieves the generated token

        return $token;
    }

    public function validationToken($token, $secret = 'q521jf7wpk')
    {
        $token = (new Parser())->parse($token);
        return $token->verify($this->signer, $secret);
    }
}