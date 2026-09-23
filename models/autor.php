<?php

/**
 * Model responsável por ler os autores do arquivo JSON.
 * Somente leitura — o cadastro de autores é feito em outro lugar.
 */
class Autor
{
    private string $arquivoJson;

    public function __construct(string $arquivoJson = __DIR__ . '/../data/autores.json')
    {
        $this->arquivoJson = $arquivoJson;
    }

    /**
     * Lê todos os autores do arquivo JSON.
     * Espera o formato: {"autores": [{"id": 1, "nome": "..."}]}
     * Retorna um array vazio se o arquivo não existir ainda.
     */
    public function listarTodos(): array
    {
        if (!file_exists($this->arquivoJson)) {
            return [];
        }

        $conteudo = file_get_contents($this->arquivoJson);
        $dados = json_decode($conteudo, true);

        return $dados['autores'] ?? [];
    }
}
