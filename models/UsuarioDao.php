<?php

declare(strict_types=1);

namespace Biblioteca\Models;

use Biblioteca\Core\Dao;

class UsuarioDao extends Dao
{
    protected function tabela(): string
    {
        return 'usuarios';
    }

    protected function entidade(): string
    {
        return Usuario::class;
    }

    public function buscarPorEmail(string $email): ?Usuario
    {
        return $this->buscarUm('SELECT * FROM usuarios WHERE email = :email', [':email' => $email]);
    }

    /** Grava o usuário e devolve o id gerado. */
    public function inserir(Usuario $usuario): int
    {
        $nome = $usuario->getNome();
        $email = $usuario->getEmail();
        $senha = $usuario->getSenha();

        $query = $this->bd->prepare(
            'INSERT INTO usuarios (nome, email, senha) VALUES (:nome, :email, :senha)'
        );
        $query->bindParam(':nome', $nome);
        $query->bindParam(':email', $email);
        $query->bindParam(':senha', $senha);
        $query->execute();

        return (int) $this->bd->lastInsertId();
    }
}
