<?php
session_start();

// Verificar se o usuário está autenticado como administrador
if (!isset($_SESSION['user_id']) || !$_SESSION['isAdmin']) {
    header("Location: user/login.php");
    exit();
}

// Conectar ao banco de dados
include '../user/conexao.php';
// Consultar todos os projetos
$sql = "SELECT * FROM projetos";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciar Projetos</title>
    <style>
        body {
            font-family: -apple-system, system-ui, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        h2,
        #txt h2 {
            text-align: center;
            color: #2c3e50;
        }

        table {
            width: 90%;
            border-collapse: collapse;
            margin: 20px auto;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
        }

        td {
            padding: 10px;
            text-align: center;
        }

        th {
            background-color: #f2f2f2;
            border-radius: 20px;
            padding-top: 20px;
            text-align: center;
        }

        a {
            text-decoration: none;
            color: #3498db;
            cursor: pointer;
            margin-right: 10px;
        }

        a:hover {
            color: #e74c3c;
        }

        a.add-project {
            display: block;
            text-align: center;
            margin-top: 20px;
            color: #3498db;
        }

        a.add-project:hover {
            color: #e74c3c;
        }

        #txt {
            width: 80%;
            margin: 20px auto;
            margin-bottom: 50px;
        }

        p {
            text-align: center;
        }
    </style>
</head>

<body>
    <div id="txt">
        <h2>Área Administrativa - Gerenciar Projetos</h2>
        <p><a href="../index.php">Voltar para página inicial</a></p>
        <h2><a href="area_admin.php">Gerenciar Usuários</a></h2>
        <h2><a href="gerenciar_noticias.php">Gerenciar Notícias</a></h2>
        <h2><a href="pedidos.php">Pedidos de Marcação</a></h2>

        <a href="adicionar_projeto.php">Adicionar Novo Projeto</a>
    </div>

    <?php
    if ($result->num_rows > 0) {
        echo "<table>
                <tr>
                    <th>ID</th>
                    <th>Projeto</th>
                    <th>Início</th>
                    <th>Término</th>
                    <th>Responsável</th>
                    <th>Tecnologia Usada</th>
                    <th>Imagem</th>
                    <th>Ações</th>
                </tr>";

        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>{$row['ID']}</td>
                    <td>{$row['NomeProjeto']}</td>
                    <td>{$row['DataInicio']}</td>
                    <td>{$row['DataTerminoPrevista']}</td>
                    <td>{$row['ResponsavelProjeto']}</td>
                    <td>{$row['TecnologiaUsada']}</td>
                    <td><img src='data:image/jpeg;base64," . base64_encode($row['ImagemProjeto']) . "' width='100' height='100'></td>
                    <td>
                        <a href='editar_projeto.php?id={$row['ID']}'>Editar</a>
                        <a href='excluir_projeto.php?id={$row['ID']}' onclick='return confirmarExclusao()'>Excluir</a>
                    </td>
                </tr>";
        }

        echo "</table>";
    } else {
        echo "Nenhum projeto encontrado.";
    }

    // Fechar a conexão
    $conn->close();
    ?>
    <script>
        function confirmarExclusao() {
            return confirm('Tem certeza de que deseja excluir o projeto?');
        }
    </script>
</body>

</html>