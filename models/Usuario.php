<?php

declare(strict_types=1);

namespace Biblioteca\Models;

/** Entidade: cliente da biblioteca (tabela "usuarios"). */
class Usuario
{
    private ?int $id = null;
    private string $nome = '';
    private string $email = '';
    private string $senha = '';

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNome(): string
    {
        return $this->nome;
    }

    public function setNome(string $nome): static
    {
        $this->nome = $nome;
        return $this;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;
        return $this;
    }

    /** Hash da senha (nunca o texto puro). */
    public function getSenha(): string
    {
        return $this->senha;
    }

    /** Recebe a senha digitada e guarda só o hash. */
    public function definirSenha(string $senhaDigitada): static
    {
        $this->senha = password_hash($senhaDigitada, PASSWORD_DEFAULT);
        return $this;
    }
}
