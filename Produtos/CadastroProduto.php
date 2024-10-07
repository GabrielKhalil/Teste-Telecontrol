<?php
include("../connection.php");

$descricao = isset($_POST['descricao']) ? trim($_POST['descricao']) : '';
$codigo = isset($_POST['codigo']) ? trim($_POST['codigo']) : '';
$status = isset($_POST['status']) ? trim($_POST['status']) : '';
$tempo_garantia = isset($_POST['tempo_garantia']) ? trim($_POST['tempo_garantia']) : '';

if (empty($descricao) || empty($codigo) || empty($status) || empty($tempo_garantia)) {
    echo "<script>
        alert('Por favor, preencha todos os campos.');
    </script>";
    exit;
}

$sql = "INSERT INTO produtos (descricao, codigo, status, tempo_garantia) VALUES (?, ?, ?, ?)";

if ($stmt = $connection->prepare($sql)) {
    $stmt->bind_param('sssi', $descricao, $codigo, $status, $tempo_garantia);

    if ($stmt->execute()) {
        echo 
        "<script>
            alert('Produto cadastrado com sucesso!');
            window.location.href = '../index.html';  // Redireciona para a página de cadastro
        </script>";
    } else {
        echo "<script>
            alert('Erro ao cadastrar produto: " . $stmt->error . "');
        </script>";
    }

    $stmt->close();
} else {
    echo "<script>
        alert('Erro ao fazer cadastro no banco: " . $connection->error . "');
    </script>";
}

$connection->close();
?>
