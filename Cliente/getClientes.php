<?php
include("../connection.php");

$sql = "SELECT * FROM clientes";
$result = mysqli_query($connection, $sql);

$clientes = array();

if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $clientes[] = $row;
    }
    echo json_encode($clientes);
} else {
    echo json_encode(array("error" => "Erro ao executar a consulta."));
}

mysqli_close($connection);
?>
