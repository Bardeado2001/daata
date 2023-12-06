<?php
session_start();

// Verificar se o usuário está autenticado
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include 'conexao.php';

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
$userID = $_SESSION['user_id'];
$dadosUsuario = obterDadosUsuario($conn, $userID);

if ($dadosUsuario) {
    // Processar dados do formulário
    $nome = $_POST['nome'];
    $apelido = $_POST['apelido'];
    $email = $_POST['email'];
    $telefone = $_POST['telefone'];
    $nomeUsuario = $_POST['nome_usuario'];

    // Verificar se a senha atual foi fornecida e se é correta
    if (!empty($_POST['senha_atual']) && !empty($_POST['nova_senha']) && !empty($_POST['confirmar_nova_senha'])) {
        $senhaAtual = $_POST['senha_atual'];
        $senhaAtualHash = $dadosUsuario['Senha'];

        if (password_verify($senhaAtual, $senhaAtualHash)) {
            // Senha atual correta, verificar se a nova senha é igual à confirmação da senha
            $novaSenha = $_POST['nova_senha'];
            $confirmarNovaSenha = $_POST['confirmar_nova_senha'];

            if ($novaSenha === $confirmarNovaSenha) {
                // Nova senha igual à confirmação, processar alteração de senha
                $novaSenhaHash = password_hash($novaSenha, PASSWORD_DEFAULT);
                $sqlSenha = "UPDATE Utilizadores SET Senha = '$novaSenhaHash' WHERE ID = $userID";
                $conn->query($sqlSenha);
            } else {
                // Nova senha e confirmação de senha não coincidem, redirecionar com mensagem de erro
                header("Location: editar_perfil.php?erro=nova_senha_incorreta");
                exit();
            }
        } else {
            // Senha atual incorreta, redirecionar com mensagem de erro
            header("Location: editar_perfil.php?erro=senha_incorreta");
            exit();
        }
    }

    // Atualizar os outros dados do perfil
    $sql = "UPDATE Utilizadores SET Nome = '$nome', Apelido = '$apelido', Email = '$email', Telefone = '$telefone', NomeUsuario = '$nomeUsuario' WHERE ID = $userID";
    $conn->query($sql);

    // Redirecionar com mensagem de sucesso
    header("Location: minha_conta.php?sucesso=alteracoes_salvas");
    exit();
} else {
    // Erro ao obter dados do usuário, redirecionar com mensagem de erro
    header("Location: editar_perfil.php?erro=obter_dados");
    exit();
}

// Fechar a conexão
$conn->close();
?>
