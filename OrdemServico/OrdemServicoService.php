<?php

include("../connection.php");

header('Content-Type: application/json');

$response = [
    'success' => false,
    'message' => ''
];

$cpf = isset($_POST['cpf']) ? trim($_POST['cpf']) : '';
$nome = isset($_POST['nome']) ? trim($_POST['nome']) : '';
$id_produto = isset($_POST['id_produto']) ? trim($_POST['id_produto']) : '';
$data_abertura = isset($_POST['data_abertura']) ? trim($_POST['data_abertura']) : '';
$id_cliente = isset($_POST['id_cliente']) ? trim($_POST['id_cliente']) : '';


// Formatar data
if ($data_abertura) {
    $data = DateTime::createFromFormat('d/m/Y', $data_abertura);
    if ($data) {
        $data_abertura = $data->format('Y-m-d');
    } else {
        $data_abertura = '';
    }
}

if (empty($id_cliente)) {
    $sql = "INSERT INTO clientes (nome, cpf) VALUES (?, ?)";

    if ($stmt = $connection->prepare($sql)) {
        $stmt->bind_param('ss', $nome, $cpf);

        try {
            if ($stmt->execute()) {
                $id_cliente = $connection->insert_id;
                $response['success'] = true;
                $response['message'] = 'Cliente cadastrado com sucesso.';
            }
        } catch (mysqli_sql_exception $e) {
            $response['message'] = 'Erro ao cadastrar cliente: ' . $e->getMessage();
        }

        $stmt->close();
    }
}

$sql = "INSERT INTO ordens_servico (data_abertura, id_cliente, id_produto) VALUES (?, ?, ?)";

if ($stmt = $connection->prepare($sql)) {
    $stmt->bind_param('ssi', $data_abertura, $id_cliente, $id_produto);

    try {
        if ($stmt->execute()) {
            $response['success'] = true;
            $response['message'] = 'Ordem de serviço cadastrada com sucesso!';
        }
    } catch (mysqli_sql_exception $e) {
        $response['message'] = 'Erro ao cadastrar ordem de serviço: ' . $e->getMessage();
    }

    $stmt->close();
}

echo json_encode($response);

$connection->close();
?>