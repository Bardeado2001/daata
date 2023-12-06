<?php
session_start();

// Verificar se o usuário está autenticado como administrador
if (!isset($_SESSION['user_id']) || !$_SESSION['isAdmin']) {
    header("Location: login.php");
    exit();
}

// Conectar ao banco de dados (substitua com suas credenciais)
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

// Fechar a conexão
$conn->close();
?>

<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Usuário</title>
    <style>
        body {
            font-family: -apple-system, system-ui, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
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

        input,
        select {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
            background-color: #e8f0fe;
        }

        select {
            margin-bottom: 20px;
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

        .message {
            text-align: center;
            margin-top: 20px;
            padding: 10px;
            border-radius: 5px;
        }

        .success {
            background-color: #2ecc71;
            color: #fff;
        }

        .error {
            background-color: #e74c3c;
            color: #fff;
        }
        p {
            text-align: center;
        }
        a {
            text-decoration: none;
        }
    </style>
</head>

<body>
    <div>
        <h2>Área Administrativa - Editar Usuários</h2>
        <p><a href="area_admin.php">Voltar para Gerenciar Usuários</a></p>
    </div>
    <?php if ($dadosUsuario) : ?>
        <form action="processar_edicao_usuario.php?id=<?php echo $userID; ?>" method="post">
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
            <label for="funcao">Função:</label><br>
            <select id="funcao" name="funcao" required>
                <option value="usuario" <?php echo ($dadosUsuario['Funcao'] === 'usuario') ? 'selected' : ''; ?>>Usuário</option>
                <option value="administrador" <?php echo ($dadosUsuario['Funcao'] === 'administrador') ? 'selected' : ''; ?>>Administrador</option>
            </select><br>
            <?php if ($_SESSION['isAdmin'] && $userID == $_SESSION['user_id']) : ?>
                <!-- Adicione estas linhas apenas se o usuário for um administrador editando sua própria senha -->
                <label for="senha">Senha:</label>
                <input type="password" id="senha" name="senha" required><br>
                <label for="confirmar_senha">Confirmar Senha:</label>
                <input type="password" id="confirmar_senha" name="confirmar_senha" required><br>
            <?php endif; ?>
            <input type="submit" value="Salvar Alterações">
        </form>
    <?php else : ?>
        <p>Erro ao obter dados do usuário.</p>
    <?php endif; ?>
</body>

</html>