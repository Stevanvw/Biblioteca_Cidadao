<?php 
session_start();

if (!isset($_SESSION["logado"]) || $_SESSION["logado"] != true) {
    header("Location: login.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: emprestimos.php");
    exit;
}

$usuarioId = trim($_POST["usuario_id"] ?? "");
$livroId = trim($_POST["livro_id"] ?? "");
$dataEmprestimo = trim($_POST["data_emprestimo"] ?? "");
$dataDevolucao = trim($_POST["data_devolucao"] ?? "");

// 1. Validação de campos vazios genéricos
$errosCampos = [];

if ($usuarioId === "") {
    $errosCampos[] = "Selecione o usuário.";
}

if ($livroId === "") {
    $errosCampos[] = "Selecione o livro.";
}

if ($dataEmprestimo === "") {
    $errosCampos[] = "A data de empréstimo é obrigatória.";
}

if ($dataDevolucao === "") {
    $errosCampos[] = "A data de devolução é obrigatória.";
}

if (!empty($errosCampos)) {
    $mensagem = implode(" ", $errosCampos);
    header("Location: emprestimos.php?erro=1&msg=" . urlencode($mensagem));
    exit;
}

// 2. Validação específica: Data de devolução antes do empréstimo
if ($dataDevolucao < $dataEmprestimo) {
    header("Location: emprestimos.php?erro=data_invalida");
    exit;
}

// Carrega os empréstimos cadastrados
$arquivoEmprestimos = __DIR__ . "/../data/emprestimos.cad.json";

if (file_exists($arquivoEmprestimos)) {
    $dados = file_get_contents($arquivoEmprestimos);
    $emprestimos = json_decode($dados, true) ?? [];
} else {
    $emprestimos = [];
}

// 3. Validação específica: Livro já emprestado e ainda não devolvido
if ($livroId !== "") {
    $diaHoje = date("Y-m-d");
    foreach ($emprestimos as $registro) {
        if ((string) $registro["livro_id"] === (string) $livroId && $registro["data_devolucao"] >= $diaHoje) {
            header("Location: emprestimos.php?erro=livro_indisponivel");
            exit;
        }
    }
}

// Se passou por todas as validações, calcula o ID e salva o novo empréstimo
$novoId = 1;
if (!empty($emprestimos)) {
    $ids = array_column($emprestimos, 'id');
    $novoId = max($ids) + 1;
}

$novoEmprestimo = [
    "id" => $novoId,
    "usuario_id" => $usuarioId,
    "livro_id" => $livroId,
    "data_emprestimo" => $dataEmprestimo,
    "data_devolucao" => $dataDevolucao
];

$emprestimos[] = $novoEmprestimo;

file_put_contents(
    $arquivoEmprestimos,
    json_encode($emprestimos, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)
);

// Redireciona informando que o empréstimo foi feito com sucesso
header("Location: emprestimos.php?sucesso=emprestimo");
exit;
?>