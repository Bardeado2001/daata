<?php
session_start();

// Verificar se o usuário está autenticado como administrador
if (!isset($_SESSION['user_id']) || !$_SESSION['isAdmin']) {
    header("Location: login.php");
    exit();
}

// Conectar ao banco de dados
include '../user/conexao.php';

// Verificar se o ID do projeto foi passado pela URL
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];

    // Excluir o projeto da tabela
    $sql = "DELETE FROM projetos WHERE ID = $id";

    if ($conn->query($sql) === TRUE) {
        // Redirecionar para a página de gerenciamento de projetos com mensagem de sucesso
        header("Location: gerenciar_projetos.php?sucesso=projeto_excluido");
        exit();
    } else {
        echo "Erro ao excluir projeto: " . $conn->error;
    }
} else {
    echo "ID do projeto não fornecido.";
}

// Fechar a conexão
$conn->close();
