<?php

declare(strict_types=1);

namespace Biblioteca\Core;


interface DaoInterface
{
    public function listarTodos(): array;

    public function buscarPorId(int $id): ?object;
}
