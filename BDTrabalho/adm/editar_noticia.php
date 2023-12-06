<?php
session_start();

// Verificar se o usuário está autenticado como administrador
if (!isset($_SESSION['user_id']) || !$_SESSION['isAdmin']) {
    header("Location: login.php");
    exit();
}

// Conectar ao banco de dados
include '../user/conexao.php';

// Verificar se a notícia_id foi passada via GET
if (isset($_GET['noticia_id'])) {
    $noticia_id = $_GET['noticia_id'];

    // Consultar a notícia específica
    $sql = "SELECT * FROM Noticias WHERE id = $noticia_id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $tema = $row['tema'];
        $descricao = $row['descricao'];
        $data = $row['data'];
        $imagem = base64_encode($row['imagem']);
    } else {
        echo "Notícia não encontrada.";
        exit();
    }
} else {
    echo "ID da notícia não fornecido.";
    exit();
}

// Processar o formulário quando for enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verificar se é uma operação de editar
    if (isset($_POST['editar_noticia'])) {
        // Editar notícia existente
        $tema = $_POST['tema'];
        $descricao = $_POST['descricao'];
        $data = $_POST['data'];

        // Tratamento da imagem
        if ($_FILES['imagem']['size'] > 0) {
            $imagem = addslashes(file_get_contents($_FILES['imagem']['tmp_name']));
            $sql = "UPDATE Noticias SET tema='$tema', descricao='$descricao', data='$data', imagem='$imagem' 
                    WHERE id=$noticia_id";
        } else {
            $sql = "UPDATE Noticias SET tema='$tema', descricao='$descricao', data='$data' 
                    WHERE id=$noticia_id";
        }

        if ($conn->query($sql) === TRUE) {
            header("Location: gerenciar_noticias.php");
        } else {
            echo "Erro ao editar notícia: " . $conn->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Notícia</title>
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
            max-width: 500px;
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

        img {
            max-width: 100%;
            height: auto;
            border-radius: 4px;
            margin-bottom: 15px;
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
    <h2>Editar Notícia</h2>
    <p><a href="gerenciar_noticias.php">Voltar para Gerenciar Notícias</a></p>
    <form method="post" enctype="multipart/form-data">
        <label for="tema">Tema:</label>
        <input type="text" name="tema" value="<?php echo $tema; ?>" required>
        <br>

        <label for="descricao">Descrição:</label>
        <textarea name="descricao" required><?php echo $descricao; ?></textarea>
        <br>

        <label for="data">Data:</label>
        <input type="date" name="data" value="<?php echo $data; ?>" required>
        <br>

        <label for="imagem">Imagem Atual:</label>
        <img src='data:image/jpeg;base64,<?php echo $imagem; ?>' style='max-width: 300px;' />
        <br>

        <label for="nova_imagem">Nova Imagem (opcional):</label>
        <input type="file" name="imagem">
        <br>

        <input type="submit" name="editar_noticia" value="Editar Notícia">
    </form>

</body>

</html>