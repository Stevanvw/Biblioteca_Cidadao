<?php

declare(strict_types=1);

namespace Biblioteca\Models;


class Livro
{
    private ?int $id = null;
    private string $titulo = '';
    private ?int $autor_id = null;
    private ?int $categoria_id = null;
    private string $editora = '';
    private string $isbn = '';
    private ?string $autor_nome = null;
    private ?string $categoria_nome = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitulo(): string
    {
        return $this->titulo;
    }

    public function setTitulo(string $titulo): static
    {
        $this->titulo = $titulo;
        return $this;
    }

    public function getAutorId(): ?int
    {
        return $this->autor_id;
    }

    public function setAutorId(int $autorId): static
    {
        $this->autor_id = $autorId;
        return $this;
    }

    public function getCategoriaId(): ?int
    {
        return $this->categoria_id;
    }

    public function setCategoriaId(int $categoriaId): static
    {
        $this->categoria_id = $categoriaId;
        return $this;
    }

    public function getEditora(): string
    {
        return $this->editora;
    }

    public function setEditora(string $editora): static
    {
        $this->editora = $editora;
        return $this;
    }

    public function getIsbn(): string
    {
        return $this->isbn;
    }

    public function setIsbn(string $isbn): static
    {
        $this->isbn = $isbn;
        return $this;
    }

    public function getAutorNome(): ?string
    {
        return $this->autor_nome;
    }

    public function getCategoriaNome(): ?string
    {
        return $this->categoria_nome;
    }
}