<?php

$mysqli = new mysqli("localhost", "root", "", "legacy_db");

if ($mysqli->connect_error) {
    die("Erro DB");
}

$action = $_GET['action'] ?? 'list';

function onlyDigits($s)
{
    return preg_replace('/\D+/', '', $s);
}

if ($action === 'create') {
    $nome = $_POST['nome'] ?? '';
    $cnpj = onlyDigits($_POST['cnpj'] ?? '');
    $email = $_POST['email'] ?? '';

    if (strlen($nome) < 3) die("Nome curto");
    if (strlen($cnpj) != 14) die("CNPJ inválido");

    $sql = "INSERT INTO fornecedores (nome, cnpj, email, criado_em) VALUES ('$nome', '$cnpj', '$email', NOW())";
    if (!$mysqli->query($sql)) {
        die("Erro insert: " . $mysqli->error);
    }

    echo "OK";
} else {
    $q = $_GET['q'] ?? '';
    $sql = "SELECT id, nome, cnpj, email, criado_em FROM fornecedores WHERE nome LIKE '%$q%' ORDER BY criado_em DESC LIMIT 50";
    $res = $mysqli->query($sql);
    $data = [];
    while ($row = $res->fetch_assoc()) {
        $data[] = $row;
    }

    header('Content-Type: application/json');
    echo json_encode($data);
}
