<?php

/**
 * Created by PhpStorm.
 * User: jacson
 * Date: 06/01/17
 * Time: 00:06
 */
namespace JSantos\Controllers;

use Silex\Application;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminController
{
    private $app;

    const categorys = [
        'reclamacao' => '447270',
        'elogio' => '447185',
        'sugestao' => '447214',
        'solicitacao' => '447131',
        'denuncia' => '445071',
    ];

    public function __construct(Application $application)
    {
        $this->app = $application;
    }

    public function getIndex(Request $request)
    {
        return $this->app['twig']->render('admin.twig');
    }

    public function getReclamacao(Request $request)
    {
        $this->verificy($request);

        $arango = $this->app['arango'];
        $reclamacaoPendente = "LET count = (FOR m IN mensagem FOR o IN orgao FILTER m.orgao == o._key AND m.category == '" . self::categorys['reclamacao'] . "' AND m.pendente == true RETURN m._key) RETURN {count:LENGTH(count)}";
        $reclamacaoPendente = $arango->query($reclamacaoPendente);
        $reclamacoesPendente = $reclamacaoPendente[0]->count;

        $reclamacoesResolvido = "LET count = (FOR m IN mensagem FOR o IN orgao FILTER m.orgao == o._key AND m.category == '" . self::categorys['reclamacao'] . "' AND m.pendente == false RETURN m._key) RETURN {count:LENGTH(count)}";
        $reclamacoesResolvido = $arango->query($reclamacoesResolvido);
        $reclamacoesResolvido = $reclamacoesResolvido[0]->count;

        $reclamacao = [
            'pendente' => $reclamacoesPendente,
            'resolvido' => $reclamacoesResolvido,
            'mensagem' => ($reclamacoesPendente + $reclamacoesResolvido),
        ];

        return new JsonResponse($reclamacao);
    }
    public function getSugestao(Request $request)
    {
        $this->verificy($request);

        $arango = $this->app['arango'];
        $sugestaoPendente = "LET count = (FOR m IN mensagem FOR o IN orgao FILTER m.orgao == o._key AND m.category == '".self::categorys['sugestao']."' AND m.pendente == true RETURN m._key) RETURN {count:LENGTH(count)}";
        $sugestaoPendente = $arango->query($sugestaoPendente);
        $sugestoesPendente = $sugestaoPendente[0]->count;

        $sugestoesResolvido = "LET count = (FOR m IN mensagem FOR o IN orgao FILTER m.orgao == o._key AND m.category == '".self::categorys['sugestao']."' AND m.pendente == false RETURN m._key) RETURN {count:LENGTH(count)}";
        $sugestoesResolvido = $arango->query($sugestoesResolvido);
        $sugestoesResolvido = $sugestoesResolvido[0]->count;

        $sugestao = [
            'pendente' => $sugestoesPendente,
            'resolvido' => $sugestoesResolvido,
            'mensagem' => ($sugestoesResolvido + $sugestoesPendente),
        ];

        return new JsonResponse($sugestao);
    }
    public function getElogio(Request $request)
    {
        $this->verificy($request);

        $arango = $this->app['arango'];
        $elogioPendente = "LET count = (FOR m IN mensagem FOR o IN orgao FILTER m.orgao == o._key AND m.category == '".self::categorys['elogio']."' AND m.pendente == true RETURN m._key) RETURN {count:LENGTH(count)}";
        $elogioPendente = $arango->query($elogioPendente);
        $elogioPendente = $elogioPendente[0]->count;

        $elogioResolvido = "LET count = (FOR m IN mensagem FOR o IN orgao FILTER m.orgao == o._key AND m.category == '".self::categorys['elogio']."' AND m.pendente == false RETURN m._key) RETURN {count:LENGTH(count)}";
        $elogioResolvido = $arango->query($elogioResolvido);
        $elogioResolvido = $elogioResolvido[0]->count;

        $elogio = [
            'pendente' => $elogioPendente,
            'resolvido' => $elogioResolvido,
            'mensagem' => ($elogioPendente + $elogioResolvido),
        ];

        return new JsonResponse($elogio);
    }
    public function getDenuncia(Request $request)
    {
        $this->verificy($request);

        $arango = $this->app['arango'];
        $denunciaPendente = "LET count = (FOR m IN mensagem FOR o IN orgao FILTER m.orgao == o._key AND m.category == '".self::categorys['denuncia']."' AND m.pendente == true RETURN m._key) RETURN {count:LENGTH(count)}";
        $denunciaPendente = $arango->query($denunciaPendente);
        $denunciaPendente = $denunciaPendente[0]->count;

        $denunciaResolvido = "LET count = (FOR m IN mensagem FOR o IN orgao FILTER m.orgao == o._key AND m.category == '".self::categorys['denuncia']."' AND m.pendente == false RETURN m._key) RETURN {count:LENGTH(count)}";
        $denunciaResolvido = $arango->query($denunciaResolvido);
        $denunciaResolvido = $denunciaResolvido[0]->count;

        $denuncia = [
            'pendente' => $denunciaPendente,
            'resolvido' => $denunciaResolvido,
            'mensagem' => ($denunciaPendente + $denunciaResolvido),
        ];

        return new JsonResponse($denuncia);
    }
    public function getSolicitacao(Request $request)
    {
        $this->verificy($request);

        $arango = $this->app['arango'];
        $solicitacaoPendente = "LET count = (FOR m IN mensagem FOR o IN orgao FILTER m.orgao == o._key AND m.category == '".self::categorys['solicitacao']."' AND m.pendente == true RETURN m._key) RETURN {count:LENGTH(count)}";
        $solicitacaoPendente = $arango->query($solicitacaoPendente);
        $solicitacaoPendente = $solicitacaoPendente[0]->count;

        $solicitacaoResolvido = "LET count = (FOR m IN mensagem FOR o IN orgao FILTER m.orgao == o._key AND m.category == '".self::categorys['solicitacao']."' AND m.pendente == false RETURN m._key) RETURN {count:LENGTH(count)}";
        $solicitacaoResolvido = $arango->query($solicitacaoResolvido);
        $solicitacaoResolvido = $solicitacaoResolvido[0]->count;

        $solicitacao = [
            'pendente' => $solicitacaoPendente,
            'resolvido' => $solicitacaoResolvido,
            'mensagem' => ($solicitacaoPendente + $solicitacaoResolvido),
        ];

        return new JsonResponse($solicitacao);
    }
    public function getToken(Request $request)
    {

        if (!$this->app['session']->has('token')) {
            return new JsonResponse('error',401);
        }
        $token = $this->app['session']->get('token');

        return new JsonResponse($token);
    }
    public function getCategory($slug, Request $request)
    {
        if (is_null($slug)) {
            return new RedirectResponse('/admin');
        }

        return $this->app['twig']->render('category.twig');
    }
    public function getPanel(Request $request)
    {
        $this->verificy($request);

        return new JsonResponse([]);
    }
    public function getUsers(Request $request)
    {
        $this->verificy($request);
        $arango = $this->app['arango'];

        $docs = $arango->getAllDocument('user');

        $users = [];
        foreach ($docs as $doc) {
            array_push($users, ['name'=> $doc->name,'key'=> $doc->getId()]);
        }

        return new JsonResponse($users);
    }
    public function postUsers(Request $request)
    {
        $this->verificy($request);

        $user = $request->request->all();
        $user['password'] = password_hash($user['password'],PASSWORD_DEFAULT,['cost'=>12]);

        $arango = $this->app['arango'];

        if(!$arango->createDocument('user',$user)) {
            return new JsonResponse('error Token',401);
        }

        return new JsonResponse($user);
    }
    public function deleteUsers($key, Request $request)
    {
        $this->verificy($request);

        if (is_null($key)) {
            return new JsonResponse('error',401);
        }

        $arango = $this->app['arango'];

        if (!$arango->removeDocument(['user'=> $key])) {
            return new JsonResponse('error',401);
        }

        return $this->getUsers($request);
    }
    public function getOrgaos(Request $request)
    {
        $this->verificy($request);
        $arango = $this->app['arango'];

        $docs = $arango->getAllDocument('orgao');
        $collections = [];
        foreach ($docs as $doc) {
            array_push($collections, ['name'=>$doc->orgao,'key'=> $doc->getId()]);
        }

        return new JsonResponse($collections);
    }
    public function postOrgaos(Request $request)
    {
        $this->verificy($request);
        $arango = $this->app['arango'];

        return new JsonResponse('success');
    }
    private function clearToken(Request $request)
    {
        $token = $request->headers->get('Authorization');
        $token = trim(str_replace("Bearer", "", $token));
        return base64_decode($token);
    }
    private function verificy(Request $request)
    {
        $token = $this->clearToken($request);

        if (!$this->app['auth']->validationToken($token)) {
            return new JsonResponse('error Token',401);
        }
    }
}