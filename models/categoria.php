<?php

//Somente leitura
class Categoria
{
    private string $arquivoJson;

    public function __construct(string $arquivoJson = __DIR__ . '/../data/categorias.json')
    {
        $this->arquivoJson = $arquivoJson;
    }

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
