<?php

include("../connection.php");

$numero_ordem = isset($_POST['numero_ordem']) ? trim($_POST['numero_ordem']) : '';
$cpf = isset($_POST['cpf']) ? trim($_POST['cpf']) : '';
$nome = isset($_POST['nome']) ? trim($_POST['nome']) : '';
$id_produto = isset($_POST['id_produto']) ? trim($_POST['id_produto']) : '';
$data_abertura = isset($_POST['data_abertura']) ? trim($_POST['data_abertura']) : '';
$id_cliente = isset($_POST['id_cliente']) ? trim($_POST['id_cliente']) : '';

// Formatar a data
if ($data_abertura) {
    $data = DateTime::createFromFormat('d/m/Y', $data_abertura);
    if ($data) {
        $data_abertura = $data->format('Y-m-d');
    } else {
        $data_abertura = '';
    }
}

if ($id_cliente === null || $id_cliente === '') {
    $sql = "INSERT INTO clientes (nome, cpf) VALUES (?, ?)";

    if ($stmt = $connection->prepare($sql)) {
        $stmt->bind_param('ss', $nome, $cpf);

        try {
            if ($stmt->execute()) {
                $id_cliente = $connection->insert_id;
            }
        } catch (mysqli_sql_exception $e) {
            echo
            "<script>
                alert('Erro ao cadastrar cliente: " . addslashes($e->getMessage()) . "');
                window.location.href = '../index.html';
                </script>";
            $stmt->close();
            $connection->close();
            exit;
        }

        $stmt->close();
    }
}

$sql = "INSERT INTO ordens_servico (numero_ordem, data_abertura, id_cliente, id_produto) VALUES (?, ?, ?, ?)";

if ($stmt = $connection->prepare($sql)) {
    $stmt->bind_param('ssii', $numero_ordem, $data_abertura, $id_cliente, $id_produto);

    try {
        if ($stmt->execute()) {
            echo
            "<script>
                alert('Ordem de serviço cadastrada com sucesso!');
                window.location.href = '../index.html';
            </script>";
        }
    } catch (mysqli_sql_exception $e) {
        echo
        "<script>
            alert('Erro ao cadastrar ordem de serviço: " . addslashes($e->getMessage()) . "');
            window.location.href = '../index.html';
        </script>";
    }

    $stmt->close();
}

$connection->close();
