<?php

declare(strict_types=1);

use Biblioteca\Models\Livro;

/** @var Livro $livro */
/** @var array $autores */
/** @var array $categorias */

?>

<section class="pagina">
    <h1 class="page-title">Editar livro</h1>

    <form method="POST" action="<?= url('/livros/editar') ?>">
        <input type="hidden" name="id" value="<?= e((string) $livro->getId()) ?>">

        <div class="campo">
            <label for="titulo">Título</label>
            <input
                type="text"
                id="titulo"
                name="titulo"
                maxlength="150"
                value="<?= e($livro->getTitulo()) ?>"
                required>
        </div>

        <div class="campo">
            <label for="autor_id">Autor</label>
            <select id="autor_id" name="autor_id" required>
                <option value="">Selecione um autor</option>

                <?php foreach ($autores as $autor): ?>
                    <option
                        value="<?= e((string) $autor->getId()) ?>"
                        <?= $autor->getId() === $livro->getAutorId() ? 'selected' : '' ?>>
                        <?= e($autor->getNome()) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="campo">
            <label for="categoria_id">Categoria</label>
            <select id="categoria_id" name="categoria_id" required>
                <option value="">Selecione uma categoria</option>

                <?php foreach ($categorias as $categoria): ?>
                    <option
                        value="<?= e((string) $categoria->getId()) ?>"
                        <?= $categoria->getId() === $livro->getCategoriaId() ? 'selected' : '' ?>>
                        <?= e($categoria->getNome()) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="campo">
            <label for="editora">Editora</label>
            <input
                type="text"
                id="editora"
                name="editora"
                maxlength="50"
                value="<?= e($livro->getEditora()) ?>"
                required>
        </div>

        <div class="campo">
            <label for="isbn">ISBN</label>
            <input
                type="text"
                id="isbn"
                name="isbn"
                maxlength="13"
                minlength="13"
                pattern="[0-9]{13}"
                value="<?= e($livro->getIsbn()) ?>"
                required>
        </div>

        <button type="submit" class="botao botao--primario">
            Salvar alterações
        </button>

        <a href="<?= e(url('/livros')) ?>" class="botao botao--secundario">
            Cancelar
        </a>
    </form>
</section>