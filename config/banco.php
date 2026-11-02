<?php

declare(strict_types=1);

return [
    'host'    => $_ENV['BD_HOST'] ?? 'localhost',
    'porta'   => $_ENV['BD_PORTA'] ?? '3306',
    'banco'   => $_ENV['BD_NOME'] ?? 'biblioteca_cidadao',
    'usuario' => $_ENV['BD_USUARIO'] ?? 'root',
    'senha'   => $_ENV['BD_SENHA'] ?? '',
    'charset' => 'utf8mb4',
];
