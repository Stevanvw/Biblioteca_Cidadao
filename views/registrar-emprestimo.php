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

$erros = [];

if ($usuarioId === "") {
    $erros[] = "Selecione o usuário.";
}

if ($livroId === "") {
    $erros[] = "Selecione o livro.";
}

if ($dataEmprestimo === "") {
    $erros[] = "A data de empréstimo é obrigatória.";
}

if ($dataDevolucao === "") {
    $erros[] = "A data de devolução é obrigatória.";
} elseif ($dataDevolucao < $dataEmprestimo) {
    $erros[] = "A data de devolução não pode ser antes da data de empréstimo.";
}

$arquivoEmprestimos = __DIR__ . "/../data/emprestimos.cad.json";

if (file_exists($arquivoEmprestimos)) {
    $dados = file_get_contents($arquivoEmprestimos);
    $emprestimos = json_decode($dados, true);
} else {
    $emprestimos = [];
}

if ($livroId !== "") {
    $diaHoje = date("Y-m-d");
    foreach ($emprestimos as $registro) {
        if ((string) $registro["livro_id"] === (string) $livroId && $registro["data_devolucao"] >= $diaHoje) {
            $erros[] = "Este livro já está emprestado e ainda não foi devolvido.";
            break;
    }
 }
}

if (!empty($erros)) {
    $mensagem = implode(" ", $erros);
    header("Location: emprestimos.php?erro=1&msg=" . urlencode($mensagem));
    exit;
}

$novoId = count($emprestimos) + 1;

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

header("Location: emprestimos.php");
exit;

?>