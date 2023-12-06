<?php
session_start();
// Verificar se o usuário está autenticado
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
include 'conexao.php';
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
$userID = $_SESSION['user_id'];
$dadosUsuario = obterDadosUsuario($conn, $userID);
$conn->close();
?>

<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Perfil</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        h2 {
            text-align: center;
            color: #2c3e50;
        }

        form {
            max-width: 400px;
            margin: 20px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        label {
            display: block;
            margin-bottom: 8px;
        }

        input {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        h3 {
            color: #3498db;
        }

        input[type="submit"] {
            background-color: #3498db;
            color: #fff;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #2980b9;
        }

        .error {
            color: #e74c3c;
            text-align: center;
            margin-top: 10px;
        }

        p,
        a {
            text-align: center;
            text-decoration: none;
        }
    </style>
</head>

<body>
    <h2>Editar Perfil</h2>
    <p><a href="minha_conta.php">Voltar para minha conta</a></p>

    <?php if ($dadosUsuario) : ?>
        <form action="processar_edicao_perfil.php" method="post">
            <!-- Se houver um erro de senha incorreta, exibir a mensagem -->
            <?php if (isset($_GET['erro'])) : ?>
                <?php if ($_GET['erro'] == 'senha_incorreta') : ?>
                    <p style="color: red;">Senha atual incorreta. Tente novamente.</p>
                <?php elseif ($_GET['erro'] == 'nova_senha_incorreta') : ?>
                    <p style="color: red;">Nova senha e confirmação de senha não coincidem. Tente novamente.</p>
                <?php endif; ?>
            <?php endif; ?>


            <label for="nome">Nome:</label>
            <input type="text" id="nome" name="nome" value="<?php echo $dadosUsuario['Nome']; ?>" required><br>
            <label for="apelido">Apelido:</label>
            <input type="text" id="apelido" name="apelido" value="<?php echo $dadosUsuario['Apelido']; ?>" required><br>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?php echo $dadosUsuario['Email']; ?>" required><br>
            <label for="telefone">Telefone:</label>
            <input type="tel" id="telefone" name="telefone" value="<?php echo $dadosUsuario['Telefone']; ?>" required><br>
            <label for="nome_usuario">Nome de Usuário:</label>
            <input type="text" id="nome_usuario" name="nome_usuario" value="<?php echo $dadosUsuario['NomeUsuario']; ?>" required><br>
            <h3>Alterar Senha:</h3>
            <label for="senha_atual">Senha Atual:</label>
            <input type="password" id="senha_atual" name="senha_atual"><br>
            <label for="nova_senha">Nova Senha:</label>
            <input type="password" id="nova_senha" name="nova_senha"><br>
            <label for="confirmar_nova_senha">Confirmar Nova Senha:</label>
            <input type="password" id="confirmar_nova_senha" name="confirmar_nova_senha"><br>
            <input type="submit" value="Salvar Alterações">
        </form>
    <?php else : ?>
        <p>Erro ao obter dados do usuário.</p>
    <?php endif; ?>
</body>

</html>