<?php
include("../connection.php");

$descricao = isset($_POST['descricao']) ? trim($_POST['descricao']) : '';
$codigo = isset($_POST['codigo']) ? trim($_POST['codigo']) : '';
$status = isset($_POST['status']) ? trim($_POST['status']) : '';
$meses_garantia = isset($_POST['meses_garantia']) ? trim($_POST['meses_garantia']) : '';


$sql = "INSERT INTO produtos (descricao, codigo, status, meses_garantia) VALUES (?, ?, ?, ?)";

if ($stmt = $connection->prepare($sql)) {
    $stmt->bind_param('sssi', $descricao, $codigo, $status, $meses_garantia);

    if ($stmt->execute()) {
        echo
        "<script>
            alert('Produto cadastrado com sucesso!');
            window.location.href = '../index.html';
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

<!-- adicionar try e catch -->
<!-- buscar sql injection -->
<!-- alterar nome do arquivo ProdutoService -->