<?php

include("../connection.php");

$nome = isset($_POST['nome']) ? trim($_POST['nome']) : '';
$cpf = isset($_POST['cpf']) ? trim($_POST['cpf']) : '';
$endereco = isset($_POST['endereco']) ? trim($_POST['endereco']) : '';


$sql = "INSERT INTO clientes (nome, cpf, endereco) VALUES (?, ?, ?)";

if ($stmt = $connection->prepare($sql)) {
    $stmt->bind_param('sss', $nome, $cpf, $endereco);

    try {
        if ($stmt->execute()) {
            echo
            "<script>
                alert('Cliente cadastrado com sucesso!');
                window.location.href = '../index.html';
            </script>";
        }
    } catch (mysqli_sql_exception $e) {
        echo
        "<script>
            alert('Erro ao cadastrar cliente: " . addslashes($e->getMessage()) . "');
            window.location.href = 'CadastroCliente.html';
        </script>";
    }

    $stmt->close();
}

$connection->close();

// sql injection procurar.
// <!-- alterar nome do arquivo ProdutoService -->