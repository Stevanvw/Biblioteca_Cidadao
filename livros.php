<?php 
session_start();

    if (!isset($_SESSION["logado"]) || $_SESSION["logado"] != true) {
    header ("Location: login.html");
    exit;
  }
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
        <li><a href="index.html">Início</a></li>
        <li><a href="livros.html" aria-current="page">Livros</a></li>
        <li><a href="usuarios.html">Usuários</a></li>
        <li><a href="emprestimos.html">Empréstimos</a></li>
        <li><a href="login.html">Encerrar sessão</a></li>
      </ul>
    </nav>
  </header>

  <main class="page-main">
    <h1 class="page-title">Cadastro de livros</h1>

    <div class="ficha">
      <div class="ficha__cabecalho">
        <div><strong>Informações do livro</strong></div>
        <span class="ficha__codigo">novo cadastro</span>
      </div>

      <!-- TODO (PHP): troque a action pelo nome do seu script, ex.: "cadastrar-livro.php" -->
      <form method="POST" action="cadastrar-livro.php">
        <div class="campo">
          <label for="livro-titulo">Título <span class="obrigatorio">*</span></label>
          <input type="text" id="livro-titulo" name="titulo" required />
        </div>

        <div class="linha-campos">
          <div class="campo">
            <label for="livro-autor">Autor <span class="obrigatorio">*</span></label>
            <select id="livro-autor" name="autor_id" required>
              <option value="" selected disabled>Selecionar</option>
              <!-- TODO (PHP): gerar as <option> aqui com um loop lendo os autores do .json -->
            </select>
          </div>

          <div class="campo">
            <label for="livro-categoria">Categoria <span class="obrigatorio">*</span></label>
            <select id="livro-categoria" name="categoria_id" required>
              <option value="" selected disabled>Selecionar</option>
              <option value="1">Romance</option>
              <option value="2">Conto</option>
              <option value="3">Ficção científica</option>
            </select>
          </div>
        </div>

        <div class="linha-campos">
          <div class="campo">
            <label for="livro-editora">Editora <span class="obrigatorio">*</span></label>
            <input type="text" id="livro-editora" name="editora" required placeholder="Ex.: Companhia das Letras" />
          </div>

          <div class="campo">
            <label for="livro-isbn">ISBN <span class="obrigatorio">*</span></label>
            <input
              type="text"
              id="livro-isbn"
              name="isbn"
              required
              pattern="[0-9\-]{10,17}"
              placeholder="978-85-000-0000-0"
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
        <!-- TODO (PHP): fazer um loop nos livros do .json e gerar uma <tr> por livro dentro do <tbody> -->
        <thead>
          <tr>
            <th scope="col">Título</th>
            <th scope="col">Autor</th>
            <th scope="col">Categoria</th>
            <th scope="col">Ações</th>
          </tr>
        </thead>
        <tbody></tbody>
      </table>
    </div>
  </main>

  <footer class="site-footer">
    Projeto acadêmico UTFPR, Web servidor — Autores: Luis Stevan, Rayane Alves e Gleice Emilly.
  </footer>

  <script src="script.js"></script>
</body>
</html>
