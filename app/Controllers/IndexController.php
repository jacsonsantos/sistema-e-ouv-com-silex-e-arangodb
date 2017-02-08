<?php

/**
 * Created by PhpStorm.
 * User: jacson
 * Date: 06/01/17
 * Time: 00:06
 */
namespace JSantos\Controllers;

use Ratchet\Http\HttpServer;
use Ratchet\Server\IoServer;
use Ratchet\WebSocket\WsServer;
use Silex\Application;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

class IndexController
{
    private $app;

    public function __construct(Application $application)
    {
        $this->app = $application;
    }

    public function getIndex()
    {
        $arango = $this->app['arango'];

        $docsOrg = $arango->getAllDocument('orgao');
        $docsCat = $arango->getAllDocument('categoria');
        $collections = [];
        $categorys = [];
        foreach ($docsOrg as $doc) {
            $doc->_values['key'] = $doc->getId();
            array_push($collections, $doc->_values);
        }
        foreach ($docsCat as $doc) {
            $doc->_values['key'] = $doc->getId();
            array_push($categorys, $doc->_values);
        }

        return $this->app['twig']->render('index.twig',compact('collections','categorys'));
    }

    public function postIndex(Request $request)
    {
        $data = $request->request->all();
        $data['mimetype'] = '';
        $data['enviado'] = date('d/m/Y H:i:s');
        $data['visualizado'] = false;
        $data['pendente'] = true;

        $arango = $this->app['arango'];

        if(!$arango->createDocument('mensagem',$data)) {
            echo "<script>alert('Erro ao enviar mensagem!')</script>";
            return new RedirectResponse('/');
        }
        echo "<script>alert('Mensagem enviada')</script>";

        return new RedirectResponse('/');
    }

    public function getChat(Request $request)
    {
        $server = IoServer::factory(
            new HttpServer(
                new WsServer(
                    $this->app['chat']
                )
            ),
            8080
        );

        $server->run();
    }
}