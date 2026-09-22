<?php

/**
 * Model responsável por ler as categorias do arquivo JSON.
 * Somente leitura — o cadastro de categorias é feito em outro lugar.
 */
class Categoria
{
    private string $arquivoJson;

    public function __construct(string $arquivoJson = __DIR__ . '/data/categorias.json')
    {
        $this->arquivoJson = $arquivoJson;
    }

    /**
     * Lê todas as categorias do arquivo JSON.
     * Espera o formato: {"categorias": [{"id": 1, "nome": "..."}]}
     * Retorna um array vazio se o arquivo não existir ainda.
     */
    public function listarTodas(): array
    {
        if (!file_exists($this->arquivoJson)) {
            return [];
        }

        $conteudo = file_get_contents($this->arquivoJson);
        $dados = json_decode($conteudo, true);

        return $dados['categorias'] ?? [];
    }
}
