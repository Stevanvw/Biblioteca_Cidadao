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
  <title>Usuários · Sistema de Biblioteca</title>
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
        <li><a href="index.php">Início</a></li>
        <li><a href="livros.php">Livros</a></li>
        <li><a href="usuarios.php" aria-current="page">Usuários</a></li>
        <li><a href="emprestimos.php">Empréstimos</a></li>
        <li><a href="login.html">Encerrar sessão</a></li>
      </ul>
    </nav>
  </header>

  <main class="page-main">
    <h1 class="page-title">Cadastro de usuários</h1>

    <div class="ficha">
      <div class="ficha__cabecalho">
        <div><strong>Informações para o cadastro do usúario</strong></div>
        <span class="ficha__codigo">novo cadastro</span>
      </div>

      <!-- TODO (PHP): troque a action pelo nome do seu script, ex.: "cadastrar-usuario.php" -->
      <form method="POST" action="cadastrar-usuario.php">
        <div class="campo">
          <label for="usuario-nome">Nome <span class="obrigatorio">*</span></label>
          <input type="text" id="usuario-nome" name="nome" required />
        </div>

        <div class="campo">
          <label for="usuario-email">E-mail <span class="obrigatorio">*</span></label>
          <input type="email" id="usuario-email" name="email" required />
        </div>

        <div class="campo">
          <label for="usuario-senha">Senha <span class="obrigatorio">*</span></label>
          <input type="password" id="usuario-senha" name="senha" required autocomplete="new-password" />
        </div>

        <div class="acoes-ficha">
          <button type="submit" class="botao botao--primario">Cadastrar</button>
          <button type="reset" class="botao botao--secundario">Limpar</button>
        </div>
      </form>
    </div>

    <div class="tabela-wrapper">
      <table>
        <!-- TODO (PHP): fazer um loop nos usuários do .json e gerar uma <tr> por usuário dentro do <tbody> -->
        <thead>
          <tr>
            <th scope="col">Nome</th>
            <th scope="col">E-mail</th>
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
