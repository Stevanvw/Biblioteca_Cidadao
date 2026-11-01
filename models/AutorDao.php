<?php

declare(strict_types=1);

namespace Biblioteca\Models;

use Biblioteca\Core\Dao;

/** Somente leitura — o cadastro de autores é feito em outro lugar. */
class AutorDao extends Dao
{
    protected function tabela(): string
    {
        return 'autores';
    }

    protected function entidade(): string
    {
        return Autor::class;
    }
}
