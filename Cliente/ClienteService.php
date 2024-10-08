<?php

include("../connection.php");

header('Content-Type: application/json');

$response = [
    'success' => false,
    'message' => ''
];

$nome = isset($_POST['nome']) ? trim($_POST['nome']) : '';
$cpf = isset($_POST['cpf']) ? trim($_POST['cpf']) : '';
$endereco = isset($_POST['endereco']) ? trim($_POST['endereco']) : '';
$cep = isset($_POST['cep']) ? trim($_POST['cep']) : '';
$bairro = isset($_POST['bairro']) ? trim($_POST['bairro']) : '';
$cidade = isset($_POST['cidade']) ? trim($_POST['cidade']) : '';
$estado = isset($_POST['estado']) ? trim($_POST['estado']) : '';
$numero = isset($_POST['numero']) ? trim($_POST['numero']) : '';
$complemento = isset($_POST['complemento']) ? trim($_POST['complemento']) : '';

$cpf = preg_replace('/\D/', '', $cpf);


//pega os cpfs e verifica se ja existe algum cadastrado, se existir manda um erro para o front
$sql = "SELECT cpf FROM clientes WHERE cpf = ?";
if ($stmt = $connection->prepare($sql)) {
    $stmt->bind_param('s', $cpf);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $response['message'] = 'CPF já cadastrado!';
        echo json_encode($response);
        exit;
    }
    $stmt->close();
}

$sql = "INSERT INTO clientes (nome, cpf, endereco, cep, bairro, cidade, estado, numero, complemento) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
if ($stmt = $connection->prepare($sql)) {
    $stmt->bind_param('sssssssss', $nome, $cpf, $endereco, $cep, $bairro, $cidade, $estado, $numero, $complemento);

    try {
        if ($stmt->execute()) {
            $response['success'] = true;
            $response['message'] = 'Cliente cadastrado com sucesso!';
        }
    } catch (mysqli_sql_exception $e) {
        $response['message'] = 'Erro ao cadastrar cliente: ' . $e->getMessage();
    }
    $stmt->close();
} else {
    $response['message'] = 'Ocorreu algum erro ao fazer o cadastro no banco!';
}

echo json_encode($response);
$connection->close();
