<?php
$host = "localhost";
$username = "root";
$password = "minhabase17";
$dbname = "janiobd";
$conn = new mysqli($host, $username, $password, $dbname);
// Verificar a conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}
