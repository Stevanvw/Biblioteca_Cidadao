<?php

declare(strict_types=1);

namespace Biblioteca\Models;

/** Entidade: uma linha da tabela "categorias". */
class Categoria
{
    private ?int $id = null;
    private string $nome = '';

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
}
