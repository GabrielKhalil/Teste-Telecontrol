<?php
include("../connection.php");

header('Content-Type: application/json');

$response = [
    'success' => false,
    'message' => ''
];

// Captura os dados do formulário
$id_cliente = isset($_POST['id_cliente']) ? trim($_POST['id_cliente']) : '';
$nome = isset($_POST['nome']) ? trim($_POST['nome']) : '';
$cpf = isset($_POST['cpf']) ? trim($_POST['cpf']) : '';
$endereco = isset($_POST['endereco']) ? trim($_POST['endereco']) : '';
$cep = isset($_POST['cep']) ? trim($_POST['cep']) : '';
$bairro = isset($_POST['bairro']) ? trim($_POST['bairro']) : '';
$cidade = isset($_POST['cidade']) ? trim($_POST['cidade']) : '';
$estado = isset($_POST['estado']) ? trim($_POST['estado']) : '';
$numero = isset($_POST['numero']) ? trim($_POST['numero']) : '';
$complemento = isset($_POST['complemento']) ? trim($_POST['complemento']) : '';

if ($id_cliente !== '') {
    $sql = "UPDATE clientes SET nome = ?, cpf = ?, endereco = ?, cep = ?, bairro = ?, cidade = ?, estado = ?, numero = ?, complemento = ? WHERE id_cliente = ?";

    if ($stmt = $connection->prepare($sql)) {
        $stmt->bind_param('sssssssssi', $nome, $cpf, $endereco, $cep, $bairro, $cidade, $estado, $numero, $complemento, $id_cliente);

        try {
            if ($stmt->execute()) {
                if ($stmt->affected_rows > 0) {
                    $response['success'] = true;
                    $response['message'] = 'Cliente atualizado com sucesso!';
                } else {
                    $response['message'] = 'Nenhuma alteração feita ou cliente não encontrado.';
                }
            }
        } catch (mysqli_sql_exception $e) {
            $response['message'] = 'Erro ao atualizar cliente: ' . $e->getMessage();
        }
        $stmt->close();
    } else {
        $response['message'] = 'Erro ao preparar atualização: ' . $connection->error;
    }
} else {
    $response['message'] = 'ID do cliente não fornecido.';
}

echo json_encode($response);
$connection->close();
