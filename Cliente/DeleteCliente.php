<?php
include("../connection.php");

header('Content-Type: application/json');

$response = [
    'success' => false,
    'message' => ''
];

$id_cliente = isset($_POST['id_cliente']) ? trim($_POST['id_cliente']) : '';

if ($id_cliente !== '') {
    $sql = "DELETE FROM clientes WHERE id_cliente = ?";

    if ($stmt = $connection->prepare($sql)) {
        $stmt->bind_param('i', $id_cliente);

        try {
            if ($stmt->execute()) {
                if ($stmt->affected_rows > 0) {
                    $response['success'] = true;
                    $response['message'] = 'cliente deletado com sucesso!';
                } else {
                    $response['message'] = 'cliente não encontrado.';
                }
            }
        } catch (mysqli_sql_exception $e) {
            $response['message'] = 'Erro ao deletar cliente: ' . $e->getMessage();
        }
        $stmt->close();
    } else {
        $response['message'] = 'Erro ao preparar a consulta: ' . $connection->error;
    }
} else {
    $response['message'] = 'ID do cliente não fornecido.';
}

echo json_encode($response);
$connection->close();
