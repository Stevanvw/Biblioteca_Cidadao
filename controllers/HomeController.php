<?php

declare(strict_types=1);

namespace Biblioteca\Controllers;
use Biblioteca\Core\Controller;

class HomeController extends Controller {
    public function index(): void {
        $this->render('home/index', [
            'titulo' => 'Início · Sistema de Biblioteca',
            'menu'   => 'inicio',
        ]);
    }
}