<?php
session_start();

// Verificar se o usuário está autenticado como administrador
if (!isset($_SESSION['user_id']) || !$_SESSION['isAdmin']) {
    header("Location: user/login.php");
    exit();
}

// Aqui você pode incluir códigos adicionais que deseja executar apenas para administradores
?>

<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Área Administrativa</title>
    <style>

        table {
            width: 80%;
            border-collapse: collapse;
            margin: 20px auto;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
        }

        th,
        td {
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
            border-radius: 10px;
        }

        a {
            text-decoration: none;
            color: #3498db;
            cursor: pointer;
        }

        a:hover {
            color: #e74c3c;
        }

        body {
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            font-family: -apple-system, system-ui, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
        }

        h2 {
            text-align: center;
            color: #2c3e50;
        }

        p {
            text-align: center;
        }

        a.back-link {
            display: block;
            text-align: center;
            margin-top: 20px;
            color: #3498db;
        }

        a.back-link:hover {
            color: #e74c3c;
        }

        #txt {
            width: 80%;
            margin: 20px auto;
            margin-bottom: 50px;
        }
    </style>
</head>

<body>
    <div id="txt">
        <h2>Área Administrativa - Gerenciar Usuários</h2>
        <p><a href="../index.php">Voltar para página inicial</a></p>
        <h2><a href="gerenciar_projetos.php">Gerenciar Projetos</a></h2>
        <h2><a href="gerenciar_noticias.php">Gerenciar Notícias</a></h2>
        <h2><a href="pedidos.php">Pedidos de Marcação</a></h2>
    </div>
    <?php
    // Conectar ao banco de dados
    include '../user/conexao.php';

    // Consultar todos os perfis de usuários
    $sql = "SELECT * FROM Utilizadores";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Exibir uma tabela com os perfis de usuários
        echo "<table>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Apelido</th>
                    <th>Email</th>
                    <th>Telefone</th>
                    <th>Função</th>
                    <th>Nome de Usuário</th>
                    <th>Ações</th>
                </tr>";

        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>{$row['ID']}</td>
                    <td>{$row['Nome']}</td>
                    <td>{$row['Apelido']}</td>
                    <td>{$row['Email']}</td>
                    <td>{$row['Telefone']}</td>
                    <td>{$row['Funcao']}</td>
                    <td>{$row['NomeUsuario']}</td>
                    <td>
                    <a href='editar_usuario.php?id={$row['ID']}'>Editar</a></td>
                </tr>";
        }
        echo "</table>";
    } else {
        echo "Nenhum usuário encontrado.";
    }

    // Fechar a conexão
    $conn->close();
    ?>

</body>

</html>