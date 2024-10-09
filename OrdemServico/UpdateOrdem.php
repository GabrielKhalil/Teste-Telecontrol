<?php
include("../connection.php");

header('Content-Type: application/json');

$response = [
    'success' => false,
    'message' => ''
];

$id_produto = isset($_POST['id_produto']) ? trim($_POST['id_produto']) : '';
$data_abertura = isset($_POST['data_abertura']) ? trim($_POST['data_abertura']) : '';
$id_cliente = isset($_POST['id_cliente']) ? trim($_POST['id_cliente']) : '';
$id_ordem = isset($_POST['id']) ? trim($_POST['id']) : '';

if ($data_abertura) {
    $data = DateTime::createFromFormat('d/m/Y', $data_abertura);
    if ($data) {
        $data_abertura = $data->format('Y-m-d');
    } else {
        $data_abertura = '';
    }
}

if ($id_ordem !== '') {
    $sql = "UPDATE ordens_servico SET id_produto = ?, data_abertura = ?, id_cliente = ? WHERE id = ?";

    if ($stmt = $connection->prepare($sql)) {
        $stmt->bind_param('issi', $id_produto, $data_abertura, $id_cliente, $id_ordem);

        try {
            if ($stmt->execute()) {
                if ($stmt->affected_rows > 0) {
                    $response['success'] = true;
                    $response['message'] = 'Ordem atualizada com sucesso!';
                } else {
                    $response['message'] = 'Nenhuma alteração feita ou Ordem não encontrada.';
                }
            } else {
                $response['message'] = 'Erro ao executar a atualização.';
            }
        } catch (mysqli_sql_exception $e) {
            $response['message'] = 'Erro ao atualizar Ordem: ' . $e->getMessage();
        }
        $stmt->close();
    } else {
        $response['message'] = 'Erro ao preparar a atualização: ' . $connection->error;
    }
} else {
    $response['message'] = 'ID da Ordem não fornecido.';
}

echo json_encode($response);
$connection->close();
