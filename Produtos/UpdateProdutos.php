<?php
include("../connection.php");

header('Content-Type: application/json');

$response = [
    'success' => false,
    'message' => ''
];

$id_produto = isset($_POST['id_produto']) ? trim($_POST['id_produto']) : '';
$descricao = isset($_POST['descricao']) ? trim($_POST['descricao']) : '';
$codigo = isset($_POST['codigo']) ? trim($_POST['codigo']) : '';
$status = isset($_POST['status']) ? trim($_POST['status']) : '';
$meses_garantia = isset($_POST['meses_garantia']) ? trim($_POST['meses_garantia']) : '';

if ($id_produto !== '') {
    $sql = "UPDATE produtos SET descricao = ?, codigo = ?, status = ?, meses_garantia = ? WHERE id_produto = ?";

    if ($stmt = $connection->prepare($sql)) {
        $stmt->bind_param('sssii', $descricao, $codigo, $status, $meses_garantia, $id_produto);

        try {
            if ($stmt->execute()) {
                if ($stmt->affected_rows > 0) {
                    $response['success'] = true;
                    $response['message'] = 'Produto atualizado com sucesso!';
                } else {
                    $response['message'] = 'Nenhuma alteração feita ou produto não encontrado.';
                }
            }
        } catch (mysqli_sql_exception $e) {
            $response['message'] = 'Erro ao atualizar produto: ' . $e->getMessage();
        }
        $stmt->close();
    } else {
        $response['message'] = 'Erro ao preparar atualização: ' . $connection->error;
    }
} else {
    $response['message'] = 'ID do produto não fornecido.';
}

echo json_encode($response);
$connection->close();
