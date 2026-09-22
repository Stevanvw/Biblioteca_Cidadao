<?php

/**
 * Model responsável por ler e salvar livros no arquivo JSON.
 * Segue o padrão MVC: essa classe só lida com os dados,
 * sem se preocupar com formulários ou HTML.
 */
class Livro
{
    private string $arquivoJson;

    public function __construct(string $arquivoJson = __DIR__ . '/data/livros.json')
    {
        $this->arquivoJson = $arquivoJson;
    }

    /**
     * Lê todos os livros do arquivo JSON.
     * Retorna um array vazio se o arquivo não existir ainda.
     */
    public function listarTodos(): array
    {
        if (!file_exists($this->arquivoJson)) {
            return [];
        }

        $conteudo = file_get_contents($this->arquivoJson);
        $dados = json_decode($conteudo, true);

        return $dados['livros'] ?? [];
    }

    /**
     * Busca um livro específico pelo ISBN.
     * Retorna null se não encontrar.
     */
    public function buscarPorIsbn(string $isbn): ?array
    {
        $livros = $this->listarTodos();

        foreach ($livros as $livro) {
            if ($livro['isbn'] === $isbn) {
                return $livro;
            }
        }

        return null;
    }

    /**
     * Salva um novo livro no arquivo JSON.
     * Espera um array com: titulo, autor, categoria, editora, isbn.
     * Retorna true se salvou com sucesso, false caso contrário.
     */
    public function salvar(array $novoLivro): bool
    {
        $livros = $this->listarTodos();

        // Gera um id simples baseado na posição na lista
        $novoLivro['id'] = count($livros) + 1;

        $livros[] = $novoLivro;

        $dados = ['livros' => $livros];

        // JSON_PRETTY_PRINT deixa o arquivo legível
        // JSON_UNESCAPED_UNICODE evita que acentos virem \uXXXX
        $resultado = file_put_contents(
            $this->arquivoJson,
            json_encode($dados, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)
        );

        return $resultado !== false;
    }
}
