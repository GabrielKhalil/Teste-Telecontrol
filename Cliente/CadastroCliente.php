<?php

include("../connection.php");

$nome = isset($_POST['nome']) ? trim($_POST['nome']) : '';
$cpf = isset($_POST['cpf']) ? trim($_POST['cpf']) : '';
$endereco = isset($_POST['endereco']) ? trim($_POST['endereco']) : '';

if (empty($nome) || empty($cpf) || empty($endereco)) {
    echo 
    "<script>
        alert('Por favor, preencha todos os campos.');
    </script>";
    exit;
}


$sql = "INSERT INTO clientes (nome, cpf, endereco) VALUES (?, ?, ?)";

if ($stmt = $connection->prepare($sql)) {
    $stmt->bind_param('sss', $nome, $cpf, $endereco);

    if ($stmt->execute()) {
        echo 
        "<script>
            alert('Cliente cadastrado com sucesso!');
            window.location.href = '../index.html';  // Redireciona para a página de cadastro
        </script>";
    } else {
        echo 
        "<script>
            alert('Erro ao cadastrar cliente: " . $stmt->error . "');
        </script>";
    }

    $stmt->close();
} else {
    echo 
    "<script>
        alert('Erro ao cadastrar no banco: " . $connection->error . "');
    </script>";
}

$connection->close();

?>
