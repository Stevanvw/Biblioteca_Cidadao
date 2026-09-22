<?php
$id = $_GET["id"] ?? null;

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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar usuário</title>
</head>

<body>

    <h1>Editar usuário</h1>

    <form action="atualizar-usuario.php" method="POST">

        <input
            type="hidden"
            name="id"
            value="<?= htmlspecialchars($usuarioEncontrado["id"]) ?>">

        <label for="nome">Nome:</label>
        <input
            type="text"
            id="nome"
            name="nome"
            value="<?= htmlspecialchars($usuarioEncontrado["nome"]) ?>"
            required>

        <label for="email">E-mail:</label>
        <input
            type="email"
            id="email"
            name="email"
            value="<?= htmlspecialchars($usuarioEncontrado["email"]) ?>"
            required>

        <label for="senha">Nova senha:</label>
        <input
            type="password"
            id="senha"
            name="senha">

        <p>Deixe a senha em branco para manter a senha atual.</p>

        <button type="submit">Salvar alterações</button>

    </form>

    <a href="usuarios.php">Voltar</a>

</body>

</html>