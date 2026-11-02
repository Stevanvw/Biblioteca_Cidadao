    <h1 class="page-title">Cadastro de livros</h1>

    <div class="ficha">
      <div class="ficha__cabecalho">
        <div><strong>Informações do livro</strong></div>
        <span class="ficha__codigo">novo cadastro</span>
      </div>

      <form method="POST" action="<?= e(url('/livros')) ?>">

        <div class="campo">
          <label for="livro-titulo">Título <span class="obrigatorio">*</span></label>
          <input type="text" id="livro-titulo" name="titulo" value="<?= e(antigo('titulo')) ?>" />
        </div>

        <div class="linha-campos">
          <div class="campo">
            <?php $autorAntigo = antigo('autor_id'); ?>
            <label for="livro-autor">Autor <span class="obrigatorio">*</span></label>
            <select id="livro-autor" name="autor_id">
              <option value="" disabled<?= $autorAntigo === '' ? ' selected' : '' ?>>Selecionar</option>
              <?php foreach ($autores as $autor): ?>
                <option value="<?= e($autor->getId()) ?>" <?= $autorAntigo === (string) $autor->getId() ? ' selected' : '' ?>>
                  <?= e($autor->getNome()) ?>
                </option>
              <?php endforeach; ?>
            </select>
          </div>

          <div class="campo">
            <?php $categoriaAntiga = antigo('categoria_id'); ?>
            <label for="livro-categoria">Categoria <span class="obrigatorio">*</span></label>
            <select id="livro-categoria" name="categoria_id">
              <option value="" disabled<?= $categoriaAntiga === '' ? ' selected' : '' ?>>Selecionar</option>
              <?php foreach ($categorias as $categoria): ?>
                <option value="<?= e($categoria->getId()) ?>" <?= $categoriaAntiga === (string) $categoria->getId() ? ' selected' : '' ?>>
                  <?= e($categoria->getNome()) ?>
                </option>
              <?php endforeach; ?>
            </select>
          </div>
        </div>

        <div class="linha-campos">
          <div class="campo">
            <label for="livro-editora">Editora <span class="obrigatorio">*</span></label>
            <input type="text" id="livro-editora" name="editora" value="<?= e(antigo('editora')) ?>" placeholder="Ex.: Companhia das Letras" />
          </div>

          <div class="campo">
            <label for="livro-isbn">ISBN <span class="obrigatorio">*</span></label>
            <input type="text" id="livro-isbn" name="isbn" value="<?= e(antigo('isbn')) ?>" placeholder="9781234567890" />
          </div>
        </div>

        <div class="acoes-ficha">
          <button type="submit" class="botao botao--primario">Cadastrar</button>
          <a href="<?= e(url('/livros')) ?>" class="botao botao--secundario">Limpar</a>
        </div>

      </form>
    </div>

    <div class="tabela-wrapper">
      <table>
        <thead>
          <tr>
            <th scope="col">Título</th>
            <th scope="col">Autor</th>
            <th scope="col">Categoria</th>
            <th scope="col">ISBN</th>
            <th scope="col">Ações</th>
          </tr>
        </thead>
        <tbody>
          <?php if (empty($livros)): ?>
            <tr>
              <td colspan="5">Nenhum livro cadastrado.</td>
            </tr>
          <?php else: ?>
            <?php foreach ($livros as $livro): ?>
              <tr>
                <td><?= e($livro->getTitulo()) ?></td>
                <td><?= e($livro->getAutorNome()) ?></td>
                <td><?= e($livro->getCategoriaNome()) ?></td>
                <td><?= e($livro->getIsbn()) ?></td>
                <td>
                  <a
                    href="<?= e(url('/livros/editar?id=' . $livro->getId())) ?>"
                    class="botao botao--secundario">
                    Editar
                  </a>

                  <form method="POST"
                    action="<?= e(url('/livros/excluir')) ?>"
                    style="display: inline-block;"
                    onsubmit="return confirm('Tem certeza que deseja excluir este livro?');">

                    <input type="hidden" name="id" value="<?= e((string) $livro->getId()) ?>">

                    <button type="submit" class="botao botao--secundario">
                      Excluir
                    </button>
                  </form>
                </td>
              </tr>
            <?php endforeach; ?>
          <?php endif; ?>
        </tbody>
      </table>
    </div>