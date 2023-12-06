<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include 'conexao.php';

// Verificar se o ID da consulta está definido
if (isset($_GET['id'])) {
    $consultaID = $_GET['id'];

    // Excluir a consulta do banco de dados
    $sql = "DELETE FROM pedidosmarcacao WHERE ID = $consultaID";
    if ($conn->query($sql) === TRUE) {
        header("Location: minha_conta.php");
    } else {
        echo "<p>Erro ao cancelar a consulta: </p>" . $conn->error;
    }
} else {
    echo "<p>ID da consulta não especificado.</p>";
}

// Fechar a conexão
$conn->close();
