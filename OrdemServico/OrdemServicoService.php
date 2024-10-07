<?php

include("../connection.php");

$numero_ordem = isset($_POST['numero_ordem']) ? trim($_POST['numero_ordem']) : '';
$cpf = isset($_POST['cpf']) ? trim($_POST['cpf']) : '';
$nome = isset($_POST['nome']) ? trim($_POST['nome']) : '';
$id_produto = isset($_POST['id_produto']) ? trim($_POST['id_produto']) : '';
$data_abertura = isset($_POST['data_abertura']) ? trim($_POST['data_abertura']) : '';
$id_cliente = isset($_POST['id_cliente']) ? trim($_POST['id_cliente']) : '';

$sql = "SELECT * FROM produtos";
