<?php

declare(strict_types=1);

use Biblioteca\Core\Sessao;
use Biblioteca\Core\Url;



if (!function_exists('e')) {
    
    function e(mixed $valor): string
    {
        return htmlspecialchars((string) $valor, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
    }
}

if (!function_exists('url')) {
    
    function url(string $caminho = '/'): string
    {
        return Url::para($caminho);
    }
}

if (!function_exists('asset')) {
    
    function asset(string $arquivo): string
    {
        return Url::para('assets/' . ltrim($arquivo, '/'));
    }
}

if (!function_exists('antigo')) {
   
    function antigo(string $campo, string $padrao = ''): string
    {
        return Sessao::antigo($campo, $padrao);
    }
}

if (!function_exists('dataBr')) {

    function dataBr(string $dataIso): string
    {
        $data = DateTimeImmutable::createFromFormat('Y-m-d', $dataIso);

        return $data ? $data->format('d/m/Y') : $dataIso;
    }
}
