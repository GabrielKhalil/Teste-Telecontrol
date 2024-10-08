<?php
include("../connection.php");

$sql = "SELECT * FROM produtos where status = 'A'";
$result = mysqli_query($connection, $sql);

$produtos = array();

if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $produtos[] = $row;
    }
    echo json_encode($produtos);
} else {
    echo json_encode(array("error" => "Erro ao executar a consulta."));
}

mysqli_close($connection);
?>
