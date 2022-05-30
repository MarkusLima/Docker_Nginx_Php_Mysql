<?php

require_once realpath($_SERVER["DOCUMENT_ROOT"]) .'/src/controllers/ApiController.php';
require_once realpath($_SERVER["DOCUMENT_ROOT"]) .'/src/controllers/ViewController.php';

$entity = ['client', 'owner', 'property', 'contract', 'monthlyfee', 'transfer'];
$call = ['find', 'all', 'add', 'update', 'delete'];
$view = ['list', 'create', 'show', 'edit'];

foreach ($entity as $e) {
    foreach ($call as $c) {
        $rotas[$e.'_'.$c] = 'ApiController@'.$c;
    }

    foreach ($view as $v) {
        $rotas[$e.'_'.$v] = 'ViewController@'.$v;
    }
}
// $rotas = [
//     'client_find' => 'Controller@find',
//     'client_all' => 'Controller@all',
//     'client_add' => 'Controller@add',
//     'client_update' => 'Controller@update',
//     'client_delete' => 'Controller@delete'
// ];

$acao = 'client_list';

if (isset($_GET['route'])) {
    if (!key_exists($_GET['route'], $rotas)) {
        $acao = 'client_list';
    } else {
        $acao = $_GET['route'];
    }
}

$model = explode('_', $acao);

$partes = explode('@', $rotas[$acao]);

$controlador = $partes[0];
$metodo = $partes[1];

$ctr = new $controlador(ucfirst($model[0]));
$ctr->$metodo();
