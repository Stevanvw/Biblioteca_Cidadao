<?php

declare(strict_types=1);

namespace Biblioteca\Core;


final class Url
{
    public static function base(): string
    {
        $script = str_replace('\\', '/', $_SERVER['SCRIPT_NAME'] ?? '');
        $pastaPublic = rtrim(dirname($script), '/');          // ex.: /Biblioteca_Cidadao/public
        $uri = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/';

        if ($pastaPublic === '') {
            return '';
        }

     
        if ($uri === $pastaPublic || str_starts_with($uri, $pastaPublic . '/')) {
            return $pastaPublic;
        }

       
        $pai = rtrim(dirname($pastaPublic), '/');

        return $pai === '.' ? '' : $pai;
    }


    public static function para(string $caminho = '/'): string
    {
        return self::base() . '/' . ltrim($caminho, '/');
    }

    
    public static function caminhoAtual(): string
    {
        $uri = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/';
        $uri = rawurldecode($uri);
        $base = self::base();

        if ($base !== '' && str_starts_with($uri, $base)) {
            $uri = substr($uri, strlen($base));
        }

        if (str_ends_with($uri, '/index.php')) {
            $uri = substr($uri, 0, -strlen('index.php'));
        }

        $uri = '/' . trim($uri, '/');

        return $uri === '' ? '/' : $uri;
    }
}
