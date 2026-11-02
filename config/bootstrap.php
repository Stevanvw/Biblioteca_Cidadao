<?php

declare(strict_types=1);

use Biblioteca\Core\Sessao;

define('BASE_PATH', dirname(__DIR__));

date_default_timezone_set('America/Sao_Paulo');

$autoloadComposer = BASE_PATH . '/vendor/autoload.php';

if (is_file($autoloadComposer)) {
    require $autoloadComposer;
    $dotenv = Dotenv\Dotenv::createImmutable(BASE_PATH);
    $dotenv->safeLoad();
} else {
    spl_autoload_register(static function (string $classe): void {
        $mapa = [
            'Biblioteca\\Core\\'        => '/core/',
            'Biblioteca\\Controllers\\' => '/controllers/',
            'Biblioteca\\Models\\'      => '/models/',
        ];

        foreach ($mapa as $prefixo => $pasta) {
            if (str_starts_with($classe, $prefixo)) {
                $relativo = substr($classe, strlen($prefixo));
                $arquivo = BASE_PATH . $pasta . str_replace('\\', '/', $relativo) . '.php';

                if (is_file($arquivo)) {
                    require $arquivo;
                }
                return;
            }
        }
    });

    require BASE_PATH . '/core/helpers.php';
}

Sessao::iniciar();
