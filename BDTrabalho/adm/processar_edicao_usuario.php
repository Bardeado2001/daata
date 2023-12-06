<?php
session_start();

// Verificar se o usuário está autenticado
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include '../user/conexao.php';

// Função para obter dados do usuário
function obterDadosUsuario($conn, $userID)
{
    $sql = "SELECT * FROM Utilizadores WHERE ID = $userID";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        return $result->fetch_assoc();
    } else {
        return null;
    }
}

// Obter dados do usuário
$userID = $_GET['id'];
$dadosUsuario = obterDadosUsuario($conn, $userID);

// Verificar se o usuário logado é um administrador
$isAdmin = $_SESSION['isAdmin'];


if ($dadosUsuario) {
    // Processar dados do formulário
    $nome = $_POST['nome'];
    $apelido = $_POST['apelido'];
    $email = $_POST['email'];
    $telefone = $_POST['telefone'];
    $nomeUsuario = $_POST['nome_usuario'];
    $funcao = $_POST['funcao'];

    // Adicionar a lógica para atualizar a senha se os campos de senha foram preenchidos
    if ($isAdmin && $userID == $_SESSION['user_id']) {
        $senha = $_POST['senha'];
        $confirmarSenha = $_POST['confirmar_senha'];

        $sql = "UPDATE Utilizadores SET Nome = '$nome', Apelido = '$apelido', Email = '$email', Telefone = '$telefone', NomeUsuario = '$nomeUsuario', Funcao = '$funcao'";

        if (!empty($senha) && $senha === $confirmarSenha) {
            // Use hash para armazenar a senha com segurança
            $senhaHash = password_hash($senha, PASSWORD_DEFAULT);
            $sql .= ", Senha = '$senhaHash'";
        } elseif (!empty($senha) && $senha !== $confirmarSenha) {
            // Senha e confirmação de senha não coincidem
            echo "Erro: Senha e Confirmação de Senha não coincidem.";
            exit();
        }
    } else {
        // Se não for um administrador editando a senha de outro usuário, apenas atualize os outros campos
        $sql = "UPDATE Utilizadores SET Nome = '$nome', Apelido = '$apelido', Email = '$email', Telefone = '$telefone', NomeUsuario = '$nomeUsuario', Funcao = '$funcao'";
    }

    $sql .= " WHERE ID = $userID";

    if ($conn->query($sql) === TRUE) {
        // Configurar variável de sessão para indicar sucesso
        $_SESSION['edicao_usuario_sucesso'] = true;
    } else {
        echo "Erro ao editar o usuário: " . $conn->error;
    }
} else {
    // Erro ao obter dados do usuário
    echo "Erro ao obter dados do usuário.";
}

// Fechar a conexão
$conn->close();

// Redirecionar de volta para a página de gerenciamento de usuários
header("Location: area_admin.php");
exit();
