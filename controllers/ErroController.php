<?php

declare(strict_types=1);

namespace Biblioteca\Controllers;

use Biblioteca\Core\Controller;

class ErroController extends Controller
{
    public function naoEncontrado(): void {
        $this->render('erro/404', ['titulo' => 'Página não encontrada · Sistema de Biblioteca']);
    }

    public function erroInterno(): void {
        $this->render('erro/500', ['titulo' => 'Erro · Sistema de Biblioteca']);
    }
}
