<?php

declare(strict_types=1);

namespace Biblioteca\Core;

use Throwable;


final class Router
{
   
    private array $rotas = [];
    private ?array $acaoNaoEncontrada = null;
    private ?array $acaoErroInterno = null;

    public function get(string $caminho, array $acao, bool $publica = false): void
    {
        $this->rotas['GET'][$this->normalizar($caminho)] = ['acao' => $acao, 'publica' => $publica];
    }

    public function post(string $caminho, array $acao, bool $publica = false): void
    {
        $this->rotas['POST'][$this->normalizar($caminho)] = ['acao' => $acao, 'publica' => $publica];
    }

    public function naoEncontrada(array $acao): void
    {
        $this->acaoNaoEncontrada = $acao;
    }

    public function erroInterno(array $acao): void
    {
        $this->acaoErroInterno = $acao;
    }

    public function despachar(): void
    {
        $metodo = $_SERVER['REQUEST_METHOD'] ?? 'GET';
        $caminho = Url::caminhoAtual();
        $rota = $this->rotas[$metodo][$caminho] ?? null;

        try {
            if ($rota === null) {
                http_response_code(404);
                $this->executar($this->acaoNaoEncontrada);
                return;
            }

            // Proteção de sessão centralizada: nenhuma página restrita é executada sem login
            if (!$rota['publica'] && !Sessao::estaLogado()) {
                header('Location: ' . Url::para('/login'));
                exit;
            }

            $this->executar($rota['acao']);
        } catch (Throwable $erro) {
            error_log((string) $erro);
            http_response_code(500);
            $this->executar($this->acaoErroInterno);
        }
    }

    private function executar(?array $acao): void
    {
        if ($acao === null) {
            echo 'Erro.';
            return;
        }

        [$classe, $metodo] = $acao;
        (new $classe())->$metodo();
    }

    private function normalizar(string $caminho): string
    {
        return '/' . trim($caminho, '/');
    }
}
