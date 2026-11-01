<?php

declare(strict_types=1);

namespace Biblioteca\Core;

use PDO;
use PDOException;
use RuntimeException;


final class BD
{
    private static ?PDO $conexao = null;

    public static function conectar(): PDO
    {
        if (self::$conexao === null) {
            $c = require BASE_PATH . '/config/banco.php';

            $dsn = "mysql:host={$c['host']};port={$c['porta']};dbname={$c['banco']};charset={$c['charset']}";

            try {
                self::$conexao = new PDO($dsn, $c['usuario'], $c['senha'], [
                    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
                    PDO::ATTR_EMULATE_PREPARES   => false,
                ]);
            } catch (PDOException $e) {
                throw new RuntimeException('Erro na conexão: ' . $e->getMessage());
            }
        }

        return self::$conexao;
    }
}
