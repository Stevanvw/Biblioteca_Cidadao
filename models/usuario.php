<?php

class Usuario
{
    private string $arquivoJson;
    public function __construct(string $arquivoJson = __DIR__ . "/../data/cadastro_usuarios.json")
    {
        $this->arquivoJson = $arquivoJson;
    }

    public function listarTodos(): array
    {
        if (!file_exists($this->arquivoJson)) {
            return [];
        }

        $conteudo = file_get_contents($this->arquivoJson);
        $dados = json_decode($conteudo, true);

        return $dados['usuarios'] ?? [];
    }

    public function buscarPorId(int $id): ?array
    {
        $usuarios = $this->listarTodos();

        foreach ($usuarios as $usuario) {
            if ((int) $usuario['id'] === $id) {
                return $usuario;
            }
        }

        return null;
    }

    public function buscarPorEmail(string $email): ?array
    {
        $usuarios = $this->listarTodos();

        foreach ($usuarios as $usuario) {
            if (strtolower($usuario['email']) === strtolower($email)) {
                return $usuario;
            }
        }

        return null;
    }

    public function salvar(array $novoUsuario): bool
    {
        $usuarios = $this->listarTodos();

        $novoUsuario['id'] = count($usuarios) + 1;

        $usuarios[] = $novoUsuario;

        $dados = ['usuarios' => $usuarios];

        $resultado = file_put_contents(
            $this->arquivoJson,
            json_encode($dados, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)
        );

        return $resultado !== false;
    }

    public function atualizar(int $id, array $dadosAtualizados): bool
    {
        $usuarios = $this->listarTodos();

        foreach ($usuarios as $indice => $usuario) {
            if ((int) $usuario['id'] === $id) {
                $dadosAtualizados['id'] = $id;
                $usuarios[$indice] = $dadosAtualizados;

                $dados = ['usuarios' => $usuarios];

                $resultado = file_put_contents(
                    $this->arquivoJson,
                    json_encode($dados, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)
                );

                return $resultado !== false;
            }
        }

        return false;
    }
}
