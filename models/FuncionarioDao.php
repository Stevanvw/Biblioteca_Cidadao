<?php

declare(strict_types=1);

namespace Biblioteca\Models;

use Biblioteca\Core\Dao;

class FuncionarioDao extends Dao
{
    protected function tabela(): string
    {
        return 'funcionarios';
    }

    protected function entidade(): string
    {
        return Funcionario::class;
    }

    public function buscarPorEmail(string $email): ?Funcionario
    {
        return $this->buscarUm('SELECT * FROM funcionarios WHERE email = :email', [':email' => $email]);
    }
}