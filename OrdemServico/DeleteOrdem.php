<?php
include("../connection.php");

header('Content-Type: application/json');

$response = [
    'success' => false,
    'message' => ''
];

$id_ordem = isset($_POST['id']) ? trim($_POST['id']) : '';

if ($id_ordem !== '') {
    $sql = "DELETE FROM ordens_servico WHERE id = ?";

    if ($stmt = $connection->prepare($sql)) {
        $stmt->bind_param('i', $id_ordem);

        try {
            if ($stmt->execute()) {
                if ($stmt->affected_rows > 0) {
                    $response['success'] = true;
                    $response['message'] = 'Ordem deletada com sucesso!';
                } else {
                    $response['message'] = 'Ordem não encontrada.';
                }
            }
        } catch (mysqli_sql_exception $e) {
            $response['message'] = 'Erro ao deletar ordem: ' . $e->getMessage();
        }
        $stmt->close();
    } else {
        $response['message'] = 'Erro ao preparar a consulta: ' . $connection->error;
    }
} else {
    $response['message'] = 'ID da ordem não fornecido.';
}

echo json_encode($response);
$connection->close();
