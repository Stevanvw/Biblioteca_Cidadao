<?php

declare(strict_types=1);

namespace Biblioteca\Core;


abstract class Controller
{
    /**
     * Mostra uma View dentro do template (cabeçalho -> conteúdo -> rodapé).
     *
     * @param string $view  caminho dentro de views/, sem .php (ex.: 'livros/index')
     * @param array  $dados variáveis que ficam disponíveis na View. Também aceita:
     *                      'titulo' (<title>), 'menu' (item ativo do menu) e 'semMenu' (true na tela de login)
     */
    protected function render(string $view, array $dados = []): void
    {
        $dados += [
            'titulo'  => 'Sistema de Biblioteca',
            'menu'    => '',
            'semMenu' => false,
        ];

        (static function (string $__view, array $__dados): void {
            extract($__dados, EXTR_SKIP);
            $flashes = Sessao::consumirFlashes();

            require BASE_PATH . '/views/layout/template.php';
        })($view, $dados);
    }

    protected function redirecionar(string $caminho): never
    {
        header('Location: ' . Url::para($caminho));
        exit;
    }

    /** Lê um campo do POST já sem espaços nas pontas (sempre devolve string). */
    protected function campo(string $nome): string
    {
        $valor = $_POST[$nome] ?? '';

        return is_string($valor) ? trim($valor) : '';
    }

    /** Mensagens de erro: guarda cada uma, lembra o que foi digitado e volta para o formulário. */
    protected function voltarComErros(array $erros, string $rota, array $antigos = []): never
    {
        foreach ($erros as $erro) {
            Sessao::flash('erro', $erro);
        }

        Sessao::guardarAntigos($antigos);
        $this->redirecionar($rota);
    }
}
