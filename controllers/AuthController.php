<?php

declare(strict_types=1);

namespace Biblioteca\Controllers;

use Biblioteca\Core\Controller;
use Biblioteca\Core\Sessao;
use Biblioteca\Models\FuncionarioDao;

class AuthController extends Controller {
    private FuncionarioDao $funcionarioDao;

    public function __construct() {
        $this->funcionarioDao = new FuncionarioDao();
    }

    public function formulario(): void {
        if(Sessao::estaLogado()) {
            $this->redirecionar('/');
        }

        $this->render('auth/login', [
        'titulo' => 'Login · Sistema de Biblioteca',
        'semMenu' => true,
        ]);
    }

    public function entrar(): void {
    if (Sessao::estaLogado()) {
        $this->redirecionar('/');
    }

    $email = $this->campo('email');
    $senha = $_POST['senha'] ?? '';

    $funcionario = $this->funcionarioDao->buscarPorEmail($email);

    if ($funcionario !== null && is_string($senha) && $funcionario->verificarSenha($senha)) {
        Sessao::entrar();
        $this->redirecionar('/');
    }

    $this->voltarComErros(['E-mail ou senha incorretos. Tente novamente.'], '/login', ['email' => $email]);
}

    public function sair(): void {
        Sessao::sair();
        Sessao::flash('sucesso', 'Sessão encerrada.');
        $this->redirecionar('/login');
    }
}
