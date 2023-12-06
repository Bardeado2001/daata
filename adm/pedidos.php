<?php
session_start();

// Verificar se o usuário está autenticado como administrador
if (!isset($_SESSION['user_id']) || !$_SESSION['isAdmin']) {
    header("Location: login.php");
    exit();
}

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
        <h2>Área Administrativa - Pedidos de Marcação</h2>
        <p><a href="../index.php">Voltar para página inicial</a></p>
        <h2><a href="gerenciar_projetos.php">Gerenciar Projetos</a></h2>
        <h2><a href="gerenciar_noticias.php">Gerenciar Notícias</a></h2>
        <h2><a href="area_admin.php">Gerenciar Usuários</a></h2>

    </div>
    <?php
    // Conectar ao banco de dados
    include '../user/conexao.php';

    // Consultar todos os pedidos de marcação
    $sql = "SELECT * FROM pedidosmarcacao";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Exibir uma tabela com os pedidos de marcação
        echo "<table>
                <tr>
                    <th>ID</th>
                    <th>Nome do Usuário</th>
                    <th>Data da Consulta</th>
                    <th>Observações</th>
                </tr>";

        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>{$row['ID']}</td>
                    <td>{$row['NomeUsuario']}</td>
                    <td>{$row['DataConsulta']}</td>
                    <td>{$row['Observacoes']}</td>
                </tr>";
        }

        echo "</table>";
    } else {
        echo "<p>Nenhum pedido de marcação encontrado.</p>";
    }
    // Fechar a conexão
    $conn->close();
    ?>
</body>

</html>