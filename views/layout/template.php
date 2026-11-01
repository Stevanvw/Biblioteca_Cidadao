<?php
/**
 * TEMPLATE ÚNICO do sistema: do cabeçalho ao fim da página.
 * Quem chama é o Controller::render(); a View de cada página entra no meio.
 *
 * Variáveis disponíveis: $titulo, $menu, $semMenu, $flashes e as que o Controller enviou.
 */

require __DIR__ . '/cabecalho.php';
require __DIR__ . '/mensagens.php';

require BASE_PATH . '/views/' . $__view . '.php';

require __DIR__ . '/rodape.php';
