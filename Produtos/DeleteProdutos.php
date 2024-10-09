<?php
include("../connection.php");

header('Content-Type: application/json');

$response = [
    'success' => false,
    'message' => ''
];

$id_produto = isset($_POST['id_produto']) ? trim($_POST['id_produto']) : '';

if ($id_produto !== '') {
    $sql = "DELETE FROM produtos WHERE id_produto = ?";

    if ($stmt = $connection->prepare($sql)) {
        $stmt->bind_param('i', $id_produto);

        try {
            if ($stmt->execute()) {
                if ($stmt->affected_rows > 0) {
                    $response['success'] = true;
                    $response['message'] = 'Produto deletado com sucesso!';
                } else {
                    $response['message'] = 'Produto não encontrado.';
                }
            }
        } catch (mysqli_sql_exception $e) {
            $response['message'] = 'Erro ao deletar produto: ' . $e->getMessage();
        }
        $stmt->close();
    } else {
        $response['message'] = 'Erro ao preparar a consulta: ' . $connection->error;
    }
} else {
    $response['message'] = 'ID do produto não fornecido.';
}

echo json_encode($response);
$connection->close();
