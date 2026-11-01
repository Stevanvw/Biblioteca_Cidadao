<?php

declare(strict_types=1);

namespace Biblioteca\Models;

use Biblioteca\Core\Dao;
use PDO;

class EmprestimoDao extends Dao
{
    protected function tabela(): string
    {
        return 'emprestimos';
    }

    protected function entidade(): string
    {
        return Emprestimo::class;
    }

    /** Lista com o nome do usuário e o título do livro (JOIN). */
    public function listarTodos(): array
    {
        $query = $this->bd->prepare(
            'SELECT e.id, e.usuario_id, e.livro_id, e.data_emprestimo, e.data_devolucao,
                    u.nome AS usuario_nome, l.titulo AS livro_titulo
               FROM emprestimos e
               JOIN usuarios u ON u.id = e.usuario_id
               JOIN livros l   ON l.id = e.livro_id
              ORDER BY e.id'
        );
        $query->execute();

        return $query->fetchAll(PDO::FETCH_CLASS, Emprestimo::class);
    }

    /** O livro continua emprestado enquanto a data de devolução for hoje ou depois. */
    public function livroIndisponivel(int $livroId, string $hoje): bool
    {
        $query = $this->bd->prepare(
            'SELECT COUNT(*) FROM emprestimos WHERE livro_id = :livro_id AND data_devolucao >= :hoje'
        );
        $query->bindParam(':livro_id', $livroId, PDO::PARAM_INT);
        $query->bindParam(':hoje', $hoje);
        $query->execute();

        return (int) $query->fetchColumn() > 0;
    }

    /** Grava o empréstimo e devolve o id gerado. */
    public function inserir(Emprestimo $emprestimo): int
    {
        $usuarioId = $emprestimo->getUsuarioId();
        $livroId = $emprestimo->getLivroId();
        $dataEmprestimo = $emprestimo->getDataEmprestimo();
        $dataDevolucao = $emprestimo->getDataDevolucao();

        $query = $this->bd->prepare(
            'INSERT INTO emprestimos (usuario_id, livro_id, data_emprestimo, data_devolucao)
             VALUES (:usuario_id, :livro_id, :data_emprestimo, :data_devolucao)'
        );
        $query->bindParam(':usuario_id', $usuarioId, PDO::PARAM_INT);
        $query->bindParam(':livro_id', $livroId, PDO::PARAM_INT);
        $query->bindParam(':data_emprestimo', $dataEmprestimo);
        $query->bindParam(':data_devolucao', $dataDevolucao);
        $query->execute();

        return (int) $this->bd->lastInsertId();
    }
}