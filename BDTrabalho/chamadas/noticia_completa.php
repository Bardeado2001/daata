<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        body {
            font-family: -apple-system, system-ui, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            background-color: #f4f4f4;
            color: #333;
            margin: 0;
            padding: 0;
        }

        header {
            background-color: #333;
            color: #fff;
            padding: 10px;
            text-align: center;
        }

        .noticia-container {
            width: 90%;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        h2 {
            color: #333;
        }

        img {
            width: 30%;
            height: auto;
            border-radius: 8px;
            margin: 10px auto;
        }
    </style>
</head>

</html>
<?php
// noticia_completa.php

// Verifique se o ID da notícia foi fornecido na URL
if (isset($_GET['id'])) {
    // Conectar ao banco de dados
include '../user/conexao.php';

    // Obter o ID da notícia da URL
    $noticia_id = $_GET['id'];

    // Consultar a notícia pelo ID
    $sql = "SELECT * FROM Noticias WHERE id = $noticia_id";
    $result = $conn->query($sql);

    // Verificar se a notícia foi encontrada
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // Exibir detalhes completos da notícia
        echo "<div class='noticia-container'>";
        echo "<h2>" . $row['tema'] . "</h2>";
        echo "<p><strong>Descrição:</strong> " . $row['descricao'] . "</p>";
        echo "<p><strong>Data:</strong> " . $row['data'] . "</p>";
        echo "<img src='data:image/jpeg;base64," . base64_encode($row['imagem']) . "' style='max-width: 500px;' />";
        echo "</div>";
    } else {
        echo "<p>Notícia não encontrada.</p>";
    }

    // Fechar a conexão
    $conn->close();
} else {
    echo "<p>ID da notícia não fornecido.</p>";
}
