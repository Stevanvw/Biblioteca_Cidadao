<?php

declare(strict_types=1);

/**
 * Front controller: TODA requisição entra por aqui.
 * O Router descobre qual Controller/método responde pela URL, e o Controller
 * é quem chama a View.
 */

require __DIR__ . '/../config/bootstrap.php';

use Biblioteca\Core\Router;

$router = new Router();

$registrarRotas = require BASE_PATH . '/config/rotas.php';
$registrarRotas($router);

$router->despachar();
