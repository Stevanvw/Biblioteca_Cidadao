<?php

declare(strict_types=1);

namespace Biblioteca\Core;

use PDO;


abstract class Dao implements DaoInterface
{
    protected PDO $bd;

    public function __construct(?PDO $bd = null)
    {
        $this->bd = $bd ?? BD::conectar();
    }


    abstract protected function tabela(): string;

    abstract protected function entidade(): string;

    public function listarTodos(): array
    {
        $query = $this->bd->prepare('SELECT * FROM ' . $this->tabela() . ' ORDER BY id');
        $query->execute();

        return $query->fetchAll(PDO::FETCH_CLASS, $this->entidade());
    }

    public function buscarPorId(int $id): ?object
    {
        $query = $this->bd->prepare('SELECT * FROM ' . $this->tabela() . ' WHERE id = :id');
        $query->bindParam(':id', $id, PDO::PARAM_INT);
        $query->execute();

        $query->setFetchMode(PDO::FETCH_CLASS, $this->entidade());
        $registro = $query->fetch();

        return $registro === false ? null : $registro;
    }

    /** Executa um SELECT com parâmetros e devolve um objeto da entidade (ou null). */
    protected function buscarUm(string $sql, array $parametros): ?object
    {
        $query = $this->bd->prepare($sql);
        $this->vincular($query, $parametros);
        $query->execute();

        $query->setFetchMode(PDO::FETCH_CLASS, $this->entidade());
        $registro = $query->fetch();

        return $registro === false ? null : $registro;
    }

    /** bindParam de todos os parâmetros do array [':nome' => valor]. */
    protected function vincular(\PDOStatement $query, array &$parametros): void
    {
        foreach ($parametros as $nome => &$valor) {
            $query->bindParam($nome, $valor, is_int($valor) ? PDO::PARAM_INT : PDO::PARAM_STR);
        }
    }
}
