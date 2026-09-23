<?php

session_start();

if (!isset($_SESSION["logado"]) || $_SESSION["logado"] != true) {
    header("Location: login.html");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: usuarios.php");
    exit;
}

$id = $_POST["id"] ?? "";
$nome = trim($_POST["nome"] ?? "");
$email = trim($_POST["email"] ?? "");
$senha = trim($_POST["senha"] ?? "");

$erros = [];

if ($nome === "") {
    $erros[] = "O nome é obrigatório!";
}

if ($email === "") {
    $erros[] = "O e-mail é obrigatório!";
} elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $erros[] = "Digite um e-mail válido!";
}

if ($id === "") {
    $erros[] = "Usuário inválido!";
}
if (!empty($erros)) {
    echo "<h2>Erro na atualização</h2>";

    foreach ($erros as $erro) {
        echo "<p>" . htmlspecialchars($erro) . "</p>";
    }

    echo '<a href="usuarios.php">Voltar</a>';
    exit;
}
$arquivoUsuarios = "usuarios.cad.json";

if (file_exists($arquivoUsuarios)) {
    $dados = file_get_contents($arquivoUsuarios);
    $usuarios = json_decode($dados, true);
} else {
    $usuarios = [];
}

$indiceUsuario = null;

foreach ($usuarios as $indice => $usuario) {
    if ((string)$usuario["id"] === (string)$id) {
        $indiceUsuario = $indice;
        break;
    }
}
if ($indiceUsuario === null) {
    echo "<h2> Usuario não encontrado</h2>";
    exit;
}

foreach ($usuarios as $indice => $usuario) {
    if ($indice !== $indiceUsuario && strtolower($usuario["email"]) === strtolower($email)) {
        header("Location: editar-usuario.php?id=" . $id . "&erro=email");
        exit;
    }
}

$usuarios[$indiceUsuario]["nome"] = $nome;
$usuarios[$indiceUsuario]["email"] = $email;

if ($senha !== "") {
    $usuarios[$indiceUsuario]["senha"] = $senha;
}

file_put_contents($arquivoUsuarios, json_encode($usuarios, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
header("Location: usuarios.php");
exit;
