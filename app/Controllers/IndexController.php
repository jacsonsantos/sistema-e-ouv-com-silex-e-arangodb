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
use Symfony\Component\HttpFoundation\Session\Flash\FlashBag;

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
        $hasPhoto = false;
        $data = $request->request->all();

        if ($request->files->has('photo')) {
            $file = $request->files->get("photo");
            $newName = md5($file->getClientOriginalName());
            $ext = $file->getClientOriginalExtension();
            $data['anexo'] = $newName.'.'.$ext;
            $data['mimetype'] = $file->getClientMimeType();
            $hasPhoto = true;
        }

        $data['category'] = (string)$data['category'];
        $data['orgao'] = (string)$data['orgao'];
        $data['name'] = (string)$data['name'];
        $data['email'] = (string)$data['email'];
        $data['subject'] = (string)$data['subject'];
        $data['message'] = (string)$data['message'];

        $data['enviado'] = date('d/m/Y H:i:s');
        $data['visualizado'] = false;
        $data['pendente'] = true;

        $arango = $this->app['arango'];

        if ($hasPhoto && !file_exists('/uploads/'.$newName.'.'.$ext)) {
            if ($file->move('/uploads',$newName.'.'.$ext)) {
                if(!$arango->createDocument('mensagem',$data)) {
                    $this->app['session']->getFlashBag()->add('error','Erro ao enviar manifestação');
                    return new RedirectResponse('/#message');
                }
            }
        } else {
            if (!$arango->createDocument('mensagem', $data)) {
                $this->app['session']->getFlashBag()->add('error', 'Erro ao enviar manifestação');
                return new RedirectResponse('/#message');
            }
        }

        $this->app['session']->getFlashBag()->add('success','Manifestação enviada');

        return new RedirectResponse('/#message');
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