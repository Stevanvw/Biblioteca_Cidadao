<?php

require_once __DIR__ . '/../models/livro.php';
require_once __DIR__ . '/../models/autor.php';
require_once __DIR__ . '/../models/categoria.php';

/**
 * Controller responsável por receber os dados vindos da view livros.php,
 * validar, e decidir o que fazer usando o Model Livro.
 */

class LivroController
{
    private Livro $livroModel;
    private Autor $autorModel;
    private Categoria $categoriaModel;
    private array $erros = [];

    public function __construct()
    {
        $this->livroModel = new Livro();
        $this->autorModel = new Autor();
        $this->categoriaModel = new Categoria();
    }

    /**
     * Ponto de entrada: decide o que fazer com base no método da requisição.
     * Chame esse método a partir de livros.php.
     */
    public function processar(): array
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->salvarLivro();
        }

        // Sempre retorna a lista atualizada + autores + categorias + eventuais erros,
        // pra view exibir
        return [
            'livros' => $this->livroModel->listarTodos(),
            'autores' => $this->autorModel->listarTodos(),
            'categorias' => $this->categoriaModel->listarTodas(),
            'erros' => $this->erros
        ];
    }

    /**
     * Valida e salva um novo livro vindo do formulário.
     */
    private function salvarLivro(): void
    {
        $dados = $this->validarDados($_POST);

        if (!empty($this->erros)) {
            return; // não salva se tiver erro
        }

        // Evita ISBN duplicado
        if ($this->livroModel->buscarPorIsbn($dados['isbn']) !== null) {
            $this->erros[] = 'Já existe um livro cadastrado com esse ISBN.';
            return;
        }

        $salvou = $this->livroModel->salvar($dados);

        if ($salvou) {
            // PRG: redireciona pra evitar reenvio do form ao dar F5
            header('Location: livros.php?sucesso=1');
            exit;
        }

        $this->erros[] = 'Não foi possível salvar o livro. Tente novamente.';
    }

    /**
     * Valida os campos recebidos do formulário.
     * Retorna os dados já limpos (trim + htmlspecialchars).
     */
    private function validarDados(array $post): array
    {
        $campos = ['titulo', 'autor', 'categoria', 'editora', 'isbn'];
        $dados = [];

        foreach ($campos as $campo) {
            $valor = trim($post[$campo] ?? '');

            if ($valor === '') {
                $this->erros[] = "O campo '$campo' é obrigatório.";
            }

            // Remove tags HTML/JS pra evitar XSS
            $dados[$campo] = htmlspecialchars($valor, ENT_QUOTES, 'UTF-8');
        }

        // Validação específica de ISBN: só números e hífens, 10 a 17 caracteres
        if ($dados['isbn'] !== '' && !preg_match('/^[0-9\-]{10,17}$/', $dados['isbn'])) {
            $this->erros[] = 'ISBN inválido. Use apenas números e hífens.';
        }

        return $dados;
    }
}

// Uso direto (se esse arquivo for chamado a partir de livros.php):
// $controller = new LivroController();
// $resultado = $controller->processar();
// $livros = $resultado['livros'];
// $erros = $resultado['erros'];
