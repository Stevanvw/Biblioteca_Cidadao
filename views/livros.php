<?php
require_once __DIR__ . '/../controllers/livroController.php';

$controller = new LivroController();
$resultado = $controller->processar();

$livros = $resultado['livros'];
$autores = $resultado['autores'];
$categorias = $resultado['categorias'];
$erros = $resultado['erros'];
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Cadastro de livros · Sistema de Biblioteca</title>
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@400;500;600;700&family=PT+Serif:wght@400;700&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="style.css" />
</head>
<body>

  <header class="site-header">
    <div class="site-header__identity">
      <a href="index.html">
        <span class="site-brand">Biblioteca Cidadão<span></span></span>
        <p class="site-tagline">Sistema interno de gestão da biblioteca</p>
      </a>
      <button class="nav-toggle" aria-expanded="false" aria-controls="menu-principal">Menu</button>
    </div>
    <nav class="drawer-nav" id="menu-principal" aria-label="Navegação principal">
      <ul>
        <li><a href="index.php">Início</a></li>
        <li><a href="livros.php" aria-current="page">Livros</a></li>
        <li><a href="usuarios.php">Usuários</a></li>
        <li><a href="emprestimos.php">Empréstimos</a></li>
        <li><a href="login.html">Encerrar sessão</a></li>
      </ul>
    </nav>
  </header>

  <main class="page-main">
    <h1 class="page-title">Cadastro de livros</h1>

    <?php if (!empty($erros)): ?>
      <script>
        alert(<?= json_encode(implode("\n", $erros)) ?>);
      </script>
    <?php endif; ?>

    <?php if (isset($_GET['sucesso'])): ?>
      <script>
        alert('Livro cadastrado com sucesso!');
      </script>
    <?php endif; ?>

    <div class="ficha">
      <div class="ficha__cabecalho">
        <div><strong>Informações do livro</strong></div>
        <span class="ficha__codigo">novo cadastro</span>
      </div>

      <form method="POST" action="livros.php">

        <div class="campo">
          <label for="livro-titulo">Título <span class="obrigatorio">*</span></label>
          <input type="text" id="livro-titulo" name="titulo" />
        </div>

        <div class="linha-campos">
          <div class="campo">
            <label for="livro-autor">Autor <span class="obrigatorio">*</span></label>
            <select id="livro-autor" name="autor">
              <option value="" selected disabled>Selecionar</option>

              <?php foreach ($autores as $autor): ?>
                <option value="<?= htmlspecialchars($autor['nome']) ?>">
                  <?= htmlspecialchars($autor['nome']) ?>
                </option>
              <?php endforeach; ?>
            </select>
          </div>

          <div class="campo">
            <label for="livro-categoria">Categoria <span class="obrigatorio">*</span></label>
            <select id="livro-categoria" name="categoria">
              <option value="" selected disabled>Selecionar</option>

              <?php foreach ($categorias as $categoria): ?>
                <option value="<?= htmlspecialchars($categoria['nome']) ?>">
                  <?= htmlspecialchars($categoria['nome']) ?>
                </option>
              <?php endforeach; ?>
            </select>
          </div>
        </div>

        <div class="linha-campos">
          <div class="campo">
            <label for="livro-editora">Editora <span class="obrigatorio">*</span></label>
            <input
              type="text"
              id="livro-editora"
              name="editora"
              placeholder="Ex.: Companhia das Letras"
            />
          </div>

          <div class="campo">
            <label for="livro-isbn">ISBN <span class="obrigatorio">*</span></label>
            <input
              type="text"
              id="livro-isbn"
              name="isbn"
              placeholder="9781234567890"
            />
          </div>
        </div>

        <div class="acoes-ficha">
          <button type="submit" class="botao botao--primario">Cadastrar</button>
          <button type="reset" class="botao botao--secundario">Limpar</button>
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
          </tr>
        </thead>
        <tbody>
          <?php foreach ($livros as $livro): ?>
            <tr>
              <td><?= htmlspecialchars($livro['titulo']) ?></td>
              <td><?= htmlspecialchars($livro['autor']) ?></td>
              <td><?= htmlspecialchars($livro['categoria']) ?></td>
              <td><?= htmlspecialchars($livro['isbn']) ?></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </main>

  <footer class="site-footer">
    Projeto acadêmico UTFPR, Web servidor — Autores: Luis Stevan, Rayane Alves e Gleice Emilly.
  </footer>

  <script src="script.js"></script>
</body>
</html>
