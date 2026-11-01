<?php

declare(strict_types=1);

namespace Biblioteca\Controllers;
use Biblioteca\Core\Controller;
use Biblioteca\Core\Sessao;
use Biblioteca\Models\Emprestimo;
use Biblioteca\Models\EmprestimoDao;
use Biblioteca\Models\LivroDao;
use Biblioteca\Models\UsuarioDao;
use DateTimeImmutable;

class EmprestimoController extends Controller {
    private EmprestimoDao $emprestimoDao;
    private UsuarioDao $usuarioDao;
    private LivroDao $livroDao;

    public function __construct() {
        $this->emprestimoDao = new EmprestimoDao();
        $this->usuarioDao = new UsuarioDao();
        $this->livroDao = new LivroDao();
    }

    /** GET emprestimos: ficha de empréstimo + lista de empréstimos */
    public function index(): void {
        $this->render('emprestimos/index', [
            'titulo'      => 'Empréstimos · Sistema de Biblioteca',
            'menu'        => 'emprestimos',
            'usuarios'    => $this->usuarioDao->listarTodos(),
            'livros'      => $this->livroDao->listarTodos(),
            'emprestimos' => $this->emprestimoDao->listarTodos(),
        ]);
    }

    /** POST emprestimos: valida e registra o empréstimo */
    public function salvar(): void {
        $dados = [
            'usuario_id'      => $this->campo('usuario_id'),
            'livro_id'        => $this->campo('livro_id'),
            'data_emprestimo' => $this->campo('data_emprestimo'),
            'data_devolucao'  => $this->campo('data_devolucao'),
        ];

        $erros = $this->validar($dados);

        if ($erros) {
            $this->voltarComErros($erros, '/emprestimos', $dados);
        }

        $emprestimo = (new Emprestimo())
            ->setUsuarioId((int) $dados['usuario_id'])
            ->setLivroId((int) $dados['livro_id'])
            ->setDataEmprestimo($dados['data_emprestimo'])
            ->setDataDevolucao($dados['data_devolucao']);

        $this->emprestimoDao->inserir($emprestimo);

        Sessao::flash('sucesso', 'Empréstimo registrado com sucesso.');
        $this->redirecionar('/emprestimos');
    }

    /** @return string[] lista de mensagens de erro (vazia = tudo certo) */
    private function validar(array $dados): array {
        $erros = [];

        // 1. Campos obrigatórios e existência no banco
        if ($dados['usuario_id'] === '') {
            $erros[] = 'Selecione o usuário.';
        } elseif (!ctype_digit($dados['usuario_id']) || $this->usuarioDao->buscarPorId((int) $dados['usuario_id']) === null) {
            $erros[] = 'O usuário selecionado é inválido.';
        }

        if ($dados['livro_id'] === '') {
            $erros[] = 'Selecione o livro.';
        } elseif (!ctype_digit($dados['livro_id']) || $this->livroDao->buscarPorId((int) $dados['livro_id']) === null) {
            $erros[] = 'O livro selecionado é inválido.';
        }

        if ($dados['data_emprestimo'] === '') {
            $erros[] = 'A data de empréstimo é obrigatória.';
        } elseif (!$this->dataValida($dados['data_emprestimo'])) {
            $erros[] = 'A data de empréstimo é inválida.';
        }

        if ($dados['data_devolucao'] === '') {
            $erros[] = 'A data de devolução é obrigatória.';
        } elseif (!$this->dataValida($dados['data_devolucao'])) {
            $erros[] = 'A data de devolução é inválida.';
        }

        if ($erros) {
            return $erros;
        }

        // 2. Devolução não pode ser antes do empréstimo
        if ($dados['data_devolucao'] < $dados['data_emprestimo']) {
            return ['A data de devolução não pode ser antes da data de empréstimo.'];
        }

        // 3. Livro já emprestado e ainda não devolvido
        if ($this->emprestimoDao->livroIndisponivel((int) $dados['livro_id'], date('Y-m-d'))) {
            return ['Este livro já está emprestado e ainda não foi devolvido.'];
        }

        return [];
    }

    private function dataValida(string $data): bool
    {
        $objeto = DateTimeImmutable::createFromFormat('!Y-m-d', $data);

        return $objeto !== false && $objeto->format('Y-m-d') === $data;
    }
}

