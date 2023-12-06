<?php
session_start();

// Verificar se o usuário está autenticado como administrador
if (!isset($_SESSION['user_id']) || !$_SESSION['isAdmin']) {
    header("Location: user/login.php");
    exit();
}

// Conectar ao banco de dados
include '../user/conexao.php';

// Processar a exclusão da notícia quando o formulário for enviado
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['excluir_noticia'])) {
    $noticia_id = $_POST['noticia_id'];

    // Excluir notícia
    $sql = "DELETE FROM Noticias WHERE id=$noticia_id";

    if ($conn->query($sql) === TRUE) {
        echo "<p>Notícia excluída com sucesso.</p>";
    } else {
        echo "Erro ao excluir notícia: " . $conn->error;
    }
}

// Consultar todas as notícias
$sql = "SELECT * FROM Noticias";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciar Notícias</title>
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

        p {
            text-align: center;
        }
        
        #txt p {
            text-align: center;
        }

        a {
            text-decoration: none;
            color: #3498db;
            cursor: pointer;
            text-align: center;
        }

        a:hover {
            color: #e74c3c;
        }

        .table {
            width: 80%;
            border-collapse: collapse;
            margin: 20px auto;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            padding: 30px;
            background-color: rgb(255, 255, 255);

        }

        .notiimagem {
            height: auto;
            border-radius: 8px;
            margin: 10px auto;
        }

        #txt {
            width: 80%;
            margin: auto;
        }

    </style>

</head>

<body>
    <div id="txt">
        <h2>Área Administrativa - Gerenciar Notícias</h2>
        <p><a href="../index.php">Voltar para página inicial</a></p>
        <h2><a href="area_admin.php">Gerenciar Usuários</a></h2>
        <h2><a href="gerenciar_projetos.php">Gerenciar Projetos</a></h2>
        <h2><a href="pedidos.php">Pedidos de Marcação</a></h2>

    </div><br>
    <p><a href='criar_noticia.php'>Criar Nova Notícia</a></p>
    <br><br><br>

    <?php
    // Exibir notícias existentes
    if ($result->num_rows > 0) {
        echo
        "<div id='txt'>
        Notícias Existentes: <br>
        
        </div>";

        while ($row = $result->fetch_assoc()) {
            echo "<div class='table'>";
            echo "<p><strong>Tema:</strong> " . $row['tema'] . "</p>";
            echo "<p><strong>Descrição:</strong> " . $row['descricao'] . "</p>";
            echo "<p><strong>Data:</strong> " . $row['data'] . "</p>";
            echo "<img class='notiimagem' src='data:image/jpeg;base64," . base64_encode($row['imagem']) . "' style='max-width: 300px;' />";

            // botões de editar e excluir com links para editar_noticia.php
            echo "<form method='get' action='editar_noticia.php'>";
            echo "<input type='hidden' name='noticia_id' value='" . $row['id'] . "'>";
            echo "<input type='submit' name='editar_noticia' value='Editar'>";
            echo "</form>";

            echo "<form method='post'>";
            echo "<input type='hidden' name='noticia_id' value='" . $row['id'] . "'>";
            echo "<input type='submit' name='excluir_noticia' value='Excluir'>";
            echo "</form>";

            echo "</div>";
        }
    } else {
        echo "<p>Nenhuma notícia encontrada.</p>";
    }
    ?>

</body>

</html>