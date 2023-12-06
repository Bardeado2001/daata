<?php
session_start();

if (!isset($_SESSION['user_id']) || !$_SESSION['isAdmin']) {
    header("Location: login.php");
    exit();
}

include '../user/conexao.php';

// Processar o formulário quando for enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verificar se é uma operação de adicionar
    if (isset($_POST['adicionar_noticia'])) {
        // Adicionar nova notícia
        $tema = $_POST['tema'];
        $descricao = $_POST['descricao'];
        $data = $_POST['data'];

        // Tratamento da imagem
        $imagem = addslashes(file_get_contents($_FILES['imagem']['tmp_name']));

        $sql = "INSERT INTO Noticias (tema, descricao, data, imagem) 
                VALUES ('$tema', '$descricao', '$data', '$imagem')";

        if ($conn->query($sql) === TRUE) {
            echo "Notícia adicionada com sucesso. <br>";
            header("Location: gerenciar_noticias.php");
        } else {
            echo "Erro ao adicionar notícia: " . $conn->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Criar Notícia</title>
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
        textarea,
        select {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
            background-color: #e8f0fe;

        }

        textarea {
            resize: vertical;
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
    <h2>Criar Notícia</h2>
    <p><a href="gerenciar_noticias.php">Voltar para Gerenciar Notícias</a></p>
    <form method="post" enctype="multipart/form-data">
        <label for="tema">Tema:</label>
        <input type="text" name="tema" required>
        <br>

        <label for="descricao">Descrição:</label>
        <textarea name="descricao" required></textarea>
        <br>

        <label for="data">Data:</label>
        <input type="date" name="data" required>
        <br>

        <label for="imagem">Imagem:</label>
        <input type="file" name="imagem">
        <br>

        <input type="submit" name="adicionar_noticia" value="Adicionar Notícia">
    </form>
</body>

</html>