<?php
session_start();
    if (!isset($_SESSION["logado"]) || $_SESSION["logado"] != "true") {
    header("Location: login.html");
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
    <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Início · Sistema de Biblioteca</title>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@400;500;600;700&family=PT+Serif:wght@400;700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="style.css" />

</head>
<body>

  <header class="site-header">
    <div class="site-header__identity">
      <a href="index.php">
        <span class="site-brand">Biblioteca Cidadão<span></span></span>
        <p class="site-tagline">Sistema interno de gestão da biblioteca</p>
      </a>
      <button class="nav-toggle" aria-expanded="false" aria-controls="menu-principal">Menu</button>
    </div>
    <nav class="drawer-nav" id="menu-principal" aria-label="Navegação principal">
      <ul>
        <li><a href="index.php" aria-current="page">Início</a></li>
        <li><a href="livros.php">Livros</a></li>
        <li><a href="usuarios.php">Usuários</a></li>
        <li><a href="emprestimos.php">Empréstimos</a></li>
        <li><a href="login.html">Encerrar sessão</a></li>
      </ul>
    </nav>
  </header>

  <main class="page-main">
    <h1 class="page-title">Painel</h1>

    <section class="card-grid">
      <article class="info-card">
        <h2>Livros</h2>
        <p>Título, autor, categoria, editora e ISBN.</p>
        <a href="livros.php">Ir para o cadastro de livros</a>
      </article>

      <article class="info-card">
        <h2>Usuários</h2>
        <p>Nome, e-mail e senha para um novo usúario que irá utilizar o sistema.</p>
        <a href="usuarios.php">Ir para o cadastro de usuários</a>
      </article>

      <article class="info-card">
        <h2>Empréstimos</h2>
        <p>Datas de empréstimo e devolução.</p>
        <a href="emprestimos.php">Ir para o registro de empréstimos</a>
      </article>
    </section>
  </main>

  <footer class="site-footer">
     Projeto acadêmico UTFPR, Web servidor — Autores: Luis Stevan, Rayane Alves e Gleice Emilly.
  </footer>

  <script src="script.js"></script>
</body>
</html>