<?php

declare(strict_types=1);

namespace Biblioteca\Models;


class Emprestimo
{
    private ?int $id = null;
    private ?int $usuario_id = null;
    private ?int $livro_id = null;
    private string $data_emprestimo = '';
    private string $data_devolucao = '';
    private ?string $usuario_nome = null;
    private ?string $livro_titulo = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsuarioId(): ?int
    {
        return $this->usuario_id;
    }

    public function setUsuarioId(int $usuarioId): static
    {
        $this->usuario_id = $usuarioId;
        return $this;
    }

    public function getLivroId(): ?int
    {
        return $this->livro_id;
    }

    public function setLivroId(int $livroId): static
    {
        $this->livro_id = $livroId;
        return $this;
    }

    public function getDataEmprestimo(): string
    {
        return $this->data_emprestimo;
    }

    public function setDataEmprestimo(string $data): static
    {
        $this->data_emprestimo = $data;
        return $this;
    }

    public function getDataDevolucao(): string
    {
        return $this->data_devolucao;
    }

    public function setDataDevolucao(string $data): static
    {
        $this->data_devolucao = $data;
        return $this;
    }

    public function getUsuarioNome(): ?string
    {
        return $this->usuario_nome;
    }

    public function getLivroTitulo(): ?string
    {
        return $this->livro_titulo;
    }
}
