<?php
include("../connection.php");

header('Content-Type: application/json');

$sql = "SELECT ordens_servico.id AS id_ordem,
                produtos.id_produto,
                clientes.id_cliente,
                clientes.nome, 
                clientes.cpf, 
                produtos.descricao, 
                produtos.codigo, 
                ordens_servico.data_abertura
        FROM ordens_servico 
        LEFT JOIN clientes ON ordens_servico.id_cliente = clientes.id_cliente 
        LEFT JOIN produtos ON ordens_servico.id_produto = produtos.id_produto";

$result = mysqli_query($connection, $sql);

$ordens = array();

if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $ordens[] = $row;
    }
    echo json_encode($ordens);
} else {
    echo json_encode(array("error" => "Erro ao executar a consulta."));
}

mysqli_close($connection);
