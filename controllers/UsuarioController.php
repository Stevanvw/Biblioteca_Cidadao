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
        } elseif (mb_strlen($nome) < 3 || mb_strlen($nome) > 150) {
            $erros[] = 'O nome deve ter entre 3 e 150 caracteres.';
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
        } elseif (mb_strlen($senha) < 8) {
            $erros[] = 'A senha deve ter pelo menos 8 caracteres.';
        }

        if ($erros) {
            $this->voltarComErros(
                $erros,
                '/usuarios',
                ['nome' => $nome, 'email' => $email]
            );
        }

        $usuario = (new Usuario())
            ->setNome($nome)
            ->setEmail($email)
            ->definirSenha($senha);

        $this->usuarioDao->inserir($usuario);

        Sessao::flash('sucesso', 'Usuário cadastrado com sucesso.');
        $this->redirecionar('/usuarios');
    }

    public function editar(): void
    {
        $id = filter_var($_GET['id'] ?? null, FILTER_VALIDATE_INT);

        if (!$id || $id < 1) {
            Sessao::flash('erro', 'Usuário não encontrado.');
            $this->redirecionar('/usuarios');
        }

        $usuario = $this->usuarioDao->buscarPorId($id);

        if (!$usuario instanceof Usuario) {
            Sessao::flash('erro', 'Usuário não encontrado.');
            $this->redirecionar('/usuarios');
        }

        $this->render('usuarios/editar', [
            'titulo'  => 'Editar usuário · Sistema de Biblioteca',
            'menu'    => 'usuarios',
            'usuario' => $usuario,
        ]);
    }

    public function atualizar(): void
    {
        $id = filter_var($_GET['id'] ?? null, FILTER_VALIDATE_INT);

        if (!$id || $id < 1) {
            Sessao::flash('erro', 'Usuário não encontrado.');
            $this->redirecionar('/usuarios');
        }

        $usuario = $this->usuarioDao->buscarPorId($id);

        if (!$usuario instanceof Usuario) {
            Sessao::flash('erro', 'Usuário não encontrado.');
            $this->redirecionar('/usuarios');
        }

        $nome = $this->campo('nome');
        $email = $this->campo('email');
        $senha = $this->campo('senha');

        $erros = [];

        if ($nome === '') {
            $erros[] = 'O nome é obrigatório.';
        } elseif (mb_strlen($nome) < 3 || mb_strlen($nome) > 150) {
            $erros[] = 'O nome deve ter entre 3 e 150 caracteres.';
        }

        if ($email === '') {
            $erros[] = 'O e-mail é obrigatório.';
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL) || mb_strlen($email) > 150) {
            $erros[] = 'Digite um e-mail válido.';
        } else {
            $existente = $this->usuarioDao->buscarPorEmail($email);

            if ($existente !== null && $existente->getId() !== $usuario->getId()) {
                $erros[] = 'Este e-mail já está cadastrado.';
            }
        }

        if ($senha !== '' && mb_strlen($senha) < 8) {
            $erros[] = 'A nova senha deve ter pelo menos 8 caracteres.';
        }

        if ($erros) {
            $this->voltarComErros(
                $erros,
                '/usuarios/editar?id=' . $id,
                ['nome' => $nome, 'email' => $email]
            );
        }

        $usuario->setNome($nome)->setEmail($email);

        if ($senha !== '') {
            $usuario->definirSenha($senha);
        }

        $this->usuarioDao->atualizar($usuario);

        Sessao::flash('sucesso', 'Usuário atualizado com sucesso.');
        $this->redirecionar('/usuarios');
    }
}
