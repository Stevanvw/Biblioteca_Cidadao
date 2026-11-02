<?php

declare(strict_types=1);

use Biblioteca\Controllers\AuthController;
use Biblioteca\Controllers\EmprestimoController;
use Biblioteca\Controllers\ErroController;
use Biblioteca\Controllers\HomeController;
use Biblioteca\Controllers\LivroController;
use Biblioteca\Controllers\UsuarioController;
use Biblioteca\Core\Router;


return static function (Router $r): void {
    $r->get('/login', [AuthController::class, 'formulario'], publica: true);
    $r->post('/login', [AuthController::class, 'entrar'], publica: true);
    $r->get('/logout', [AuthController::class, 'sair'], publica: true);

    // Área restrita ao funcionário já logados
    $r->get('/', [HomeController::class, 'index']);

    $r->get('/livros', [LivroController::class, 'index']);
    $r->post('/livros', [LivroController::class, 'salvar']);
    $r->get('/livros/editar', [LivroController::class, 'editar']);
    $r->post('/livros/editar', [LivroController::class, 'atualizar']);
    $r->post('/livros/excluir', [LivroController::class, 'excluir']);

    $r->get('/usuarios', [UsuarioController::class, 'index']);
    $r->post('/usuarios', [UsuarioController::class, 'salvar']);
    $r->get('/usuarios/editar', [UsuarioController::class, 'editar']);
    $r->post('/usuarios/editar', [UsuarioController::class, 'atualizar']);
    $r->get('/emprestimos', [EmprestimoController::class, 'index']);
    $r->post('/emprestimos', [EmprestimoController::class, 'salvar']);

    // Páginas de erro
    $r->naoEncontrada([ErroController::class, 'naoEncontrado']);
    $r->erroInterno([ErroController::class, 'erroInterno']);
};
