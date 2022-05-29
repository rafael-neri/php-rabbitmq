<?php

use PlugRoute\RouteFactory;

$router = RouteFactory::create();

/** Rotas de Producer e Consumer */
$router->get('/producer', 'Src\\controller\\Producer@send');
$router->get('/consumer', 'Src\\controller\\Consumer@receive');

/** Rota Padrão - Quando não encontrada */
$router->get('{anything}', 'Src\\controller\\Index@index');

$router->on();
