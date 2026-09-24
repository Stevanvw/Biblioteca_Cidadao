<?php

//Somente leitura — o cadastro de autores é feito em outro lugar.

class Autor
{
    private string $arquivoJson;

    public function __construct(string $arquivoJson = __DIR__ . '/../data/autores.json')
    {
        $this->arquivoJson = $arquivoJson;
    }

    //Lê todos os autores do arquivo JSON.
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