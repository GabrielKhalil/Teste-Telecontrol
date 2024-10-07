<?php
$server = "localhost";
$user = "root";
$password = "";
$dbname = "telecontrol_ordem_servico";

try {
    $connection = new mysqli($server, $user, $password, $dbname);

    $connection->set_charset("utf8");

    if ($connection->connect_error) {
        throw new Exception("Conexão falhou: " . $connection->connect_error);
    }
} catch (Exception $exception) {
    die("Erro ao se conectar com o banco de dados: " . $exception->getMessage());
}
