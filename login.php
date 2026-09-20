<?php
session_start();

// se já estiver logado, ele já vai direto para o painel
    if (isset($_SESSION["logado"]) && $_SESSION["logado"] == true) {
        header("Location: index.php");
        exit;
    }

    $usuario = $_POST["email"] ?? null;
    $senha = $_POST["senha"] ?? null;

    $dados = file_get_contents("usuario.json");
    $credenciais = json_decode($dados, true);

    if ($usuario == $credenciais["usuario"] && $senha == $credenciais["senha"]) {
    $_SESSION['logado'] = true;
    header("Location: index.php");
    exit;

    } else {
    header("Location: login.html?erro=1");
    exit;
    }
?>