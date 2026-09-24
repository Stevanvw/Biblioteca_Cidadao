<?php
session_start();
if (!isset($_SESSION["logado"]) || $_SESSION["logado"] != true) {
    header("Location: login.php");
    exit;
}

function buscarPorId($lista, $id) {
    foreach ($lista as $item) {
        if ((string) $item["id"] === (string) $id) {
            return $item;
        }
    }
    return null;
}

$arquivoUsuarios = __DIR__ . "/../data/usuarios.cad.json";
if (file_exists($arquivoUsuarios)) {
    $conteudoUsuarios = file_get_contents($arquivoUsuarios);
    $usuarios = json_decode($conteudoUsuarios, true) ?? [];
} else {
    $usuarios = [];
}

$arquivoLivros = __DIR__ . "/../data/livros.json";
if (file_exists($arquivoLivros)) {
    $conteudoLivros = json_decode(file_get_contents($arquivoLivros), true);
    $livros = $conteudoLivros["livros"] ?? [];
} else {
    $livros = [];
}

$arquivoEmprestimos = __DIR__ . "/../data/emprestimos.cad.json";
$emprestimos = file_exists($arquivoEmprestimos)
    ? json_decode(file_get_contents($arquivoEmprestimos), true)
    : [];

// Captura mensagens de sucesso ou erro da URL
$sucesso = $_GET["sucesso"] ?? "";
$erroTipo = $_GET["erro"] ?? "";
$mensagemErroUrl = $_GET["msg"] ?? "";
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Empréstimos · Sistema de Biblioteca</title>
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
        <li><a href="usuarios.php">Usuários</a></li>
        <li><a href="emprestimos.php" aria-current="page">Empréstimos</a></li>
        <li><a href="logout.php">Encerrar sessão</a></li>
      </ul>
    </nav>
  </header>

  <main class="page-main">
    <h1 class="page-title">Novo empréstimo</h1>

    <!-- Feedback de Sucesso -->
    <?php if ($sucesso === "emprestimo"): ?>
      <div class="modal-sucesso" role="alert" style="margin-bottom: 20px;">
        <div class="modal-sucesso__conteudo" style="padding: 15px; background: #e6f4ea; border: 1px solid #ceead6; border-radius: 4px;">
          <h2 style="margin: 0 0 5px 0; font-size: 1.1rem; color: #137333;">Sucesso!</h2>
          <p style="margin: 0; color: #137333;">Empréstimo registrado com sucesso.</p>
        </div>
      </div>
    <?php endif; ?>

    <!-- Feedback de Erros Separados -->
    <?php if ($erroTipo === "data_invalida"): ?>
      <div class="mensagem-erro" style="display:block; background: #fce8e6; color: #c5221f; padding: 12px; border-radius: 4px; margin-bottom: 20px;">
        A data de devolução não pode ser antes da data de empréstimo.
      </div>
    <?php elseif ($erroTipo === "livro_indisponivel"): ?>
      <div class="mensagem-erro" style="display:block; background: #fce8e6; color: #c5221f; padding: 12px; border-radius: 4px; margin-bottom: 20px;">
        Este livro já está emprestado e ainda não foi devolvido.
      </div>
    <?php elseif ($erroTipo === "1" && !empty($mensagemErroUrl)): ?>
      <div class="mensagem-erro" style="display:block; background: #fce8e6; color: #c5221f; padding: 12px; border-radius: 4px; margin-bottom: 20px;">
        <?= htmlspecialchars($mensagemErroUrl) ?>
      </div>
    <?php endif; ?>

    <div class="ficha">
      <div class="ficha__cabecalho">
        <div><strong>Ficha de empréstimo</strong></div>
      </div>

      <form method="POST" action="registrar-emprestimo.php">
        <div class="linha-campos">
          <div class="campo">
            <label for="emprestimo-usuario">Usuário <span class="obrigatorio">*</span></label>
            <select id="emprestimo-usuario" name="usuario_id" required>
              <option value="" selected disabled>Selecionar</option>
              <?php foreach ($usuarios as $usuario): ?>
                <option value="<?= htmlspecialchars($usuario["id"]) ?>">
                  <?= htmlspecialchars($usuario["nome"]) ?>
                </option>
              <?php endforeach; ?>
            </select>
          </div>

          <div class="campo">
            <label for="emprestimo-livro">Livro <span class="obrigatorio">*</span></label>
            <select id="emprestimo-livro" name="livro_id" required>
              <option value="" selected disabled>Selecionar</option>
              <?php foreach ($livros as $livro): ?>
                <option value="<?= htmlspecialchars($livro["id"]) ?>">
                  <?= htmlspecialchars($livro["titulo"]) ?>
                </option>
              <?php endforeach; ?>
            </select>
          </div>
        </div>

        <div class="linha-campos">
          <div class="campo">
            <label for="emprestimo-data">Data de empréstimo <span class="obrigatorio">*</span></label>
            <input type="date" id="emprestimo-data" name="data_emprestimo" required />
          </div>

          <div class="campo">
            <label for="emprestimo-devolucao">Data prevista de devolução <span class="obrigatorio">*</span></label>
            <input type="date" id="emprestimo-devolucao" name="data_devolucao" required />
          </div>
        </div>

        <div class="acoes-ficha">
          <button type="submit" class="botao botao--primario">Registrar empréstimo</button>
          <button type="reset" class="botao botao--secundario">Limpar</button>
        </div>
      </form>
    </div>

    <div class="tabela-wrapper">
      <table>
        <thead>
          <tr>
            <th scope="col">Usuário</th>
            <th scope="col">Livro</th>
            <th scope="col">Empréstimo</th>
            <th scope="col">Devolução</th>
          </tr>
        </thead>
        <tbody>
          <?php if (empty($emprestimos)): ?>
            <tr>
              <td colspan="4">Nenhum empréstimo registrado.</td>
            </tr>
          <?php else: ?>
            <?php foreach ($emprestimos as $emprestimo): ?>
              <?php
                $usuario = buscarPorId($usuarios, $emprestimo["usuario_id"]);
                $livro = buscarPorId($livros, $emprestimo["livro_id"]);
              ?>
              <tr>
                <td><?= htmlspecialchars($usuario["nome"] ?? "Usuário não encontrado") ?></td>
                <td><?= htmlspecialchars($livro["titulo"] ?? "Livro não encontrado") ?></td>
                <td><?= htmlspecialchars($emprestimo["data_emprestimo"]) ?></td>
                <td><?= htmlspecialchars($emprestimo["data_devolucao"]) ?></td>
              </tr>
            <?php endforeach; ?>
          <?php endif; ?>
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