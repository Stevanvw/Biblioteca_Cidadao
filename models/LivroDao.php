<?php

declare(strict_types=1);

namespace Biblioteca\Models;

use Biblioteca\Core\Dao;
use PDO;

class LivroDao extends Dao
{
    protected function tabela(): string
    {
        return 'livros';
    }

    protected function entidade(): string
    {
        return Livro::class;
    }

    /**
     * Lista todos os livros com os nomes dos autores e categorias.
     */
    public function listarTodos(): array
    {
        $query = $this->bd->prepare(
            'SELECT l.id, l.titulo, l.autor_id, l.categoria_id,
                    l.editora, l.isbn,
                    a.nome AS autor_nome,
                    c.nome AS categoria_nome
             FROM livros l
             JOIN autores a ON a.id = l.autor_id
             JOIN categorias c ON c.id = l.categoria_id
             ORDER BY l.id'
        );

        $query->execute();

        return $query->fetchAll(PDO::FETCH_CLASS, Livro::class);
    }

    /**
     * Busca um livro pelo ISBN.
     */
    public function buscarPorIsbn(string $isbn): ?Livro
    {
        return $this->buscarUm(
            'SELECT * FROM livros WHERE isbn = :isbn',
            [':isbn' => $isbn]
        );
    }

    /**
     * Insere um novo livro e retorna o ID gerado.
     */
    public function inserir(Livro $livro): int
    {
        $titulo = $livro->getTitulo();
        $autorId = $livro->getAutorId();
        $categoriaId = $livro->getCategoriaId();
        $editora = $livro->getEditora();
        $isbn = $livro->getIsbn();

        $query = $this->bd->prepare(
            'INSERT INTO livros
                (titulo, autor_id, categoria_id, editora, isbn)
             VALUES
                (:titulo, :autor_id, :categoria_id, :editora, :isbn)'
        );

        $query->bindParam(':titulo', $titulo);
        $query->bindParam(':autor_id', $autorId, PDO::PARAM_INT);
        $query->bindParam(':categoria_id', $categoriaId, PDO::PARAM_INT);
        $query->bindParam(':editora', $editora);
        $query->bindParam(':isbn', $isbn);

        $query->execute();

        return (int) $this->bd->lastInsertId();
    }

    /**
     * Atualiza os dados de um livro existente.
     */
    public function atualizar(Livro $livro): bool
    {
        $id = $livro->getId();
        $titulo = $livro->getTitulo();
        $autorId = $livro->getAutorId();
        $categoriaId = $livro->getCategoriaId();
        $editora = $livro->getEditora();
        $isbn = $livro->getIsbn();

        $query = $this->bd->prepare(
            'UPDATE livros
             SET titulo = :titulo,
                 autor_id = :autor_id,
                 categoria_id = :categoria_id,
                 editora = :editora,
                 isbn = :isbn
             WHERE id = :id'
        );

        $query->bindParam(':titulo', $titulo);
        $query->bindParam(':autor_id', $autorId, PDO::PARAM_INT);
        $query->bindParam(':categoria_id', $categoriaId, PDO::PARAM_INT);
        $query->bindParam(':editora', $editora);
        $query->bindParam(':isbn', $isbn);
        $query->bindParam(':id', $id, PDO::PARAM_INT);

        return $query->execute();
    }

    /**
     * Exclui um livro pelo seu ID.
     */
    public function excluir(int $id): bool
    {
        $query = $this->bd->prepare(
            'DELETE FROM livros WHERE id = :id'
        );

        $query->bindParam(':id', $id, PDO::PARAM_INT);

        return $query->execute();
    }
}
