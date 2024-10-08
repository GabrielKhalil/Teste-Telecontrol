<?php
include("../connection.php");

header('Content-Type: application/json');

$response = [
    'success' => false,
    'message' => ''
];

$descricao = isset($_POST['descricao']) ? trim($_POST['descricao']) : '';
$codigo = isset($_POST['codigo']) ? trim($_POST['codigo']) : '';
$status = isset($_POST['status']) ? trim($_POST['status']) : '';
$meses_garantia = isset($_POST['meses_garantia']) ? trim($_POST['meses_garantia']) : '';


$sql = "INSERT INTO produtos (descricao, codigo, status, meses_garantia) VALUES (?, ?, ?, ?)";

if ($stmt = $connection->prepare($sql)) {
    $stmt->bind_param('sssi', $descricao, $codigo, $status, $meses_garantia);

    try {
        if ($stmt->execute()) {
            $response['success'] = true;
            $response['message'] = 'Produto cadastrado com sucesso!';
        }
    } catch (mysqli_sql_exception $e) {
        $response['message'] = 'Erro ao cadastrar produto: ' . $e->getMessage();
    }
    $stmt->close();
} else {
    $response['message'] = 'Erro ao preparar a consulta: ' . $connection->error;
}

echo json_encode($response);

$connection->close();
