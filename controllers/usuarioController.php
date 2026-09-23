<?php

require_once __DIR__ . '/../models/usuario.php';

class UsuarioController
{
    private Usuario $usuarioModel;
    private array $erros = [];

    public function __construct()
    {
        $this->usuarioModel = new Usuario();
    }

    public function processar(): array
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->salvarUsuario();
        }

        return [
            'usuarios' => $this->usuarioModel->listarTodos(),
            'erros' => $this->erros
        ];
    }

    private function salvarUsuario(): void
    {
        $dados = $this->validarDados($_POST);

        if (!empty($this->erros)) {
            return;
        }
        if ($this->usuarioModel->buscarPorEmail($dados['email']) !== null) {
            $this->erros[] = 'Este e-mail já está cadastrado.';
            return;
        }
        $salvou = $this->usuarioModel->salvar($dados);

        if ($salvou) {
            header('Location:usuarios.php?sucesso=1');
            exit;
        }
        $this->erros[] = 'Não foi possivel salvar o usuario! Tente novamente.';
    }

    private function validarDados(array $post): array
    {
        $campos = ['nome', 'email', 'senha'];
        $dados = [];

        foreach ($campos as $campo) {
            $valor = trim($post[$campo] ?? '');

            if ($valor === '') {
                $this->erros[] = "O campo '$campo' é obrigatório.";
            }

            $dados[$campo] = htmlspecialchars(
                $valor,
                ENT_QUOTES,
                'UTF-8'
            );
        }


        if ($dados['email'] !== '' && !filter_var($dados['email'], FILTER_VALIDATE_EMAIL)) {
            $this->erros[] = 'E-mail inválido.';
        }

        return $dados;
    }
}
