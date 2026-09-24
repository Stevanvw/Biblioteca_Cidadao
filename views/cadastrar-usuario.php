<?php

session_start();

if (!isset($_SESSION["logado"]) || $_SESSION["logado"] != true) {
    header("Location: login.html");
    exit;
}

$id = $_GET["id"] ?? null;
$erro = $_GET["erro"] ?? "";

if ($id === null) {
    header("Location: usuarios.php");
    exit;
}

$arquivoUsuarios = "usuarios.cad.json";
if (file_exists($arquivoUsuarios)) {
    $dados = file_get_contents($arquivoUsuarios);
    $usuarios = json_decode($dados, true);
} else {
    $usuarios = [];
}

$usuarioEncontrado = null;

foreach ($usuarios as $usuario) {
    if ((string) $usuario["id"] === (string) $id) {
        $usuarioEncontrado = $usuario;
        break;
    }
}

if ($usuarioEncontrado === null) {
    echo "<h2>Usuário não encontrado</h2>";
    echo '<a href="usuarios.php">Voltar</a>';
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Editar usuário · Sistema de Biblioteca</title>

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

            <button class="nav-toggle" aria-expanded="false" aria-controls="menu-principal">
                Menu
            </button>
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

        <?php if ($erro === "email"): ?>
            <div class="modal-erro" role="alert">
                <div class="modal-erro__conteudo">

                    <button
                        type="button"
                        class="modal-erro__fechar"
                        onclick="this.closest('.modal-erro').remove()">
                        ×
                    </button>

                    <h2>Erro na atualização!</h2>
                    <p>Este e-mail já está cadastrado!</p>

                </div>
            </div>
        <?php endif; ?>

        <h1 class="page-title">Editar usuário</h1>


        <div class="ficha">

            <div class="ficha__cabecalho">
                <div>
                    <strong>Informações do usuário</strong>
                </div>

                <span class="ficha__codigo">
                    edição
                </span>
            </div>

            <form method="POST" action="atualizar-usuario.php">

                <input
                    type="hidden"
                    name="id"
                    value="<?= htmlspecialchars($usuarioEncontrado["id"]) ?>" />

                <div class="campo">
                    <label for="usuario-nome">
                        Nome <span class="obrigatorio">*</span>
                    </label>

                    <input
                        type="text"
                        id="usuario-nome"
                        name="nome"
                        value="<?= htmlspecialchars($usuarioEncontrado["nome"]) ?>"
                        required />
                </div>

                <div class="campo">
                    <label for="usuario-email">
                        E-mail <span class="obrigatorio">*</span>
                    </label>

                    <input
                        type="email"
                        id="usuario-email"
                        name="email"
                        value="<?= htmlspecialchars($usuarioEncontrado["email"]) ?>"
                        required />
                </div>

                <div class="campo">
                    <label for="usuario-senha">
                        Nova senha
                    </label>

                    <input
                        type="password"
                        id="usuario-senha"
                        name="senha"
                        autocomplete="new-password" />

                    <small>Deixe em branco para manter a senha atual.</small>
                </div>

                <div class="acoes-ficha">

                    <button
                        type="submit"
                        class="botao botao--primario">
                        Salvar alterações
                    </button>

                    <a
                        href="usuarios.php"
                        class="botao botao--secundario">
                        Cancelar
                    </a>

                </div>

            </form>

        </div>

    </main>

    <footer class="site-footer">
        Projeto acadêmico UTFPR, Web servidor — Autores: Luis Stevan, Rayane Alves e Gleice Emilly.
    </footer>

    <script src="script.js"></script>

</body>

</html>
