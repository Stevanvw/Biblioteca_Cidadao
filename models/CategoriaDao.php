<?php 

declare(strict_types=1);

namespace Biblioteca\Models;

use Biblioteca\Core\Dao;

/** Somente leitura. */
class CategoriaDao extends Dao
{
    protected function tabela(): string
    {
        return 'categorias';
    }

    protected function entidade(): string
    {
        return Categoria::class;
    }
}
