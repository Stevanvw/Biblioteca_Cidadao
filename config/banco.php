<?php

declare(strict_types=1);

return [
    'host'    => getenv('BD_HOST') ?: 'localhost',
    'porta'   => getenv('BD_PORTA') ?: '3306',
    'banco'   => getenv('BD_NOME') ?: 'biblioteca_cidadao',
    'usuario' => getenv('BD_USUARIO') ?: 'root',
    'senha'   => getenv('BD_SENHA') !== false ? getenv('BD_SENHA') : '',
    'charset' => 'utf8mb4',
];
