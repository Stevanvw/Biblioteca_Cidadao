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

if ($senha === "") {
    $erros[] = "A senha é obrigatória.";
}

if (!empty($erros)) {
    echo "<h2>Erro no cadastro</h2>";

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

foreach ($usuarios as $usuario) {
    if (strtolower($usuario["email"]) === strtolower($email)) {
        header("Location: usuarios.php?erro=email");
        exit;
    }
}

$novoId = count($usuarios) + 1;

$novoUsuario = [
    "id" => $novoId,
    "nome" => $nome,
    "email" => $email,
    "senha" => $senha
];

$usuarios[] = $novoUsuario;

file_put_contents(
    $arquivoUsuarios,
    json_encode($usuarios, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)
);

header("Location: usuarios.php?sucesso=cadastro");
exit;
