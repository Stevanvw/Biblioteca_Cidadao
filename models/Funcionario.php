<?php

declare(strict_types=1);

namespace Biblioteca\Models;

class Funcionario
{
    private ?int $id = null;
    private string $email = '';
    private string $senha = '';

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function verificarSenha(string $senhaDigitada): bool
    {
        return password_verify($senhaDigitada, $this->senha);
    }
}
