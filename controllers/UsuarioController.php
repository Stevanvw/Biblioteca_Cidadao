<?php

declare(strict_types=1);

namespace Biblioteca\Controllers;

use Biblioteca\Core\Controller;
use Biblioteca\Core\Sessao;
use Biblioteca\Models\Usuario;
use Biblioteca\Models\UsuarioDao;

class UsuarioController extends Controller
{
    private UsuarioDao $usuarioDao;

    public function __construct()
    {
        $this->usuarioDao = new UsuarioDao();
    } 

    public function index(): void
    {
        $this->render('usuarios/index', [
            'titulo'   => 'Usuários · Sistema de Biblioteca',
            'menu'     => 'usuarios',
            'usuarios' => $this->usuarioDao->listarTodos(),
        ]);
    }

   
    public function salvar(): void
    {
        $nome = $this->campo('nome');
        $email = $this->campo('email');
        $senha = $this->campo('senha');

        $erros = [];

        if ($nome === '') {
            $erros[] = 'O nome é obrigatório!';
        } elseif (mb_strlen($nome) > 150) {
            $erros[] = 'O nome não pode ter mais de 150 caracteres.';
        }

        if ($email === '') {
            $erros[] = 'O e-mail é obrigatório!';
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL) || mb_strlen($email) > 150) {
            $erros[] = 'Digite um e-mail válido!';
        } elseif ($this->usuarioDao->buscarPorEmail($email) !== null) {
            $erros[] = 'Este e-mail já está cadastrado!';
        }

        if ($senha === '') {
            $erros[] = 'A senha é obrigatória.';
        }

        if ($erros) {
            // A senha nunca volta para o formulário
            $this->voltarComErros($erros, '/usuarios', ['nome' => $nome, 'email' => $email]);
        }

        $usuario = (new Usuario())
            ->setNome($nome)
            ->setEmail($email)
            ->definirSenha($senha);

        $this->usuarioDao->inserir($usuario);

        Sessao::flash('sucesso', 'Usuário cadastrado com sucesso.');
        $this->redirecionar('/usuarios');
    }
}
