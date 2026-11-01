<?php

declare(strict_types=1);

namespace Biblioteca\Controllers;

use Biblioteca\Core\Controller;
use Biblioteca\Core\Sessao;
use Biblioteca\Models\AutorDao;
use Biblioteca\Models\CategoriaDao;
use Biblioteca\Models\Livro;
use Biblioteca\Models\LivroDao;

class LivroController extends Controller
{
    private LivroDao $livroDao;
    private AutorDao $autorDao;
    private CategoriaDao $categoriaDao;

    public function __construct()
    {
        $this->livroDao = new LivroDao();
        $this->autorDao = new AutorDao();
        $this->categoriaDao = new CategoriaDao();
    }

    /** GET /livros — formulário + lista de livros */
    public function index(): void
    {
        $this->render('livros/index', [
            'titulo'     => 'Cadastro de livros · Sistema de Biblioteca',
            'menu'       => 'livros',
            'livros'     => $this->livroDao->listarTodos(),
            'autores'    => $this->autorDao->listarTodos(),
            'categorias' => $this->categoriaDao->listarTodos(),
        ]);
    }

    /** POST: livros — valida e salva um novo livro */
    public function salvar(): void
    {
        $dados = [];
        foreach (['titulo', 'autor_id', 'categoria_id', 'editora', 'isbn'] as $campo) {
            $dados[$campo] = $this->campo($campo);
        }

        $erros = $this->validar($dados);

        // Evita ISBN duplicado
        if (!$erros && $this->livroDao->buscarPorIsbn($dados['isbn']) !== null) {
            $erros[] = 'Já existe um livro cadastrado com esse ISBN.';
        }

        if ($erros) {
            $this->voltarComErros($erros, '/livros', $dados);
        }

        $livro = (new Livro())
            ->setTitulo($dados['titulo'])
            ->setAutorId((int) $dados['autor_id'])
            ->setCategoriaId((int) $dados['categoria_id'])
            ->setEditora($dados['editora'])
            ->setIsbn($dados['isbn']);

        $this->livroDao->inserir($livro);


        Sessao::flash('sucesso', 'Livro cadastrado com sucesso!');
        $this->redirecionar('/livros');
    }


    private function validar(array $dados): array
    {
        $erros = [];

        $rotulos = [
            'titulo'       => 'Título',
            'autor_id'     => 'Autor',
            'categoria_id' => 'Categoria',
            'editora'      => 'Editora',
            'isbn'         => 'ISBN',
        ];

        foreach ($rotulos as $campo => $rotulo) {
            if ($dados[$campo] === '') {
                $erros[] = "O campo $rotulo é obrigatório.";
            }
        }

        if ($dados['titulo'] !== '' && mb_strlen($dados['titulo']) > 150) {
            $erros[] = 'O título não pode ter mais de 150 caracteres.';
        }

        if ($dados['editora'] !== '' && mb_strlen($dados['editora']) > 50) {
            $erros[] = 'O nome da editora não pode ter mais de 50 caracteres.';
        }

        if ($dados['autor_id'] !== '' && (!ctype_digit($dados['autor_id']) || $this->autorDao->buscarPorId((int) $dados['autor_id']) === null)) {
            $erros[] = 'O autor selecionado é inválido.';
        }

        if ($dados['categoria_id'] !== '' && (!ctype_digit($dados['categoria_id']) || $this->categoriaDao->buscarPorId((int) $dados['categoria_id']) === null)) {
            $erros[] = 'A categoria selecionada é inválida.';
        }

        // ISBN: só números e exatamente 13 dígitos
        if ($dados['isbn'] !== '') {
            if (!ctype_digit($dados['isbn'])) {
                $erros[] = 'O ISBN deve conter somente números.';
            } elseif (strlen($dados['isbn']) !== 13) {
                $erros[] = 'O ISBN deve conter 13 dígitos.';
            }
        }

        return $erros;
    }
}
