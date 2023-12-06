<?php
session_start();

// Verificar se o usuário está autenticado
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Conectar ao banco de dados
include 'conexao.php';

// Recuperar dados do formulário
$userID = $_SESSION['user_id'];
$nomeUsuario = $_SESSION['nome_usuario'];
$dataConsulta = $_POST['data_consulta'];
$observacoes = $_POST['observacoes'];

// Inserir consulta no banco de dados
$sql = "INSERT INTO pedidosmarcacao (NomeUsuario, DataConsulta, Observacoes) VALUES ('$nomeUsuario', '$dataConsulta', '$observacoes')";
if ($conn->query($sql) === TRUE) {
    // Redirecionar para minha_conta.php com parâmetros
    header("Location: minha_conta.php?consulta_sucesso=true&data=$dataConsulta&observacoes=$observacoes");
} else {
    echo "Erro ao solicitar a consulta: " . $conn->error;
}

// Fechar a conexão
$conn->close();
