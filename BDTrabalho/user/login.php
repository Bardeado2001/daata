<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>

        /* PC */
        body {
            font-family: -apple-system, system-ui, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            background-image: url('bK.jpg');
            background-size: 300%;
            background-position: center;
            margin: 0;
            padding: 0;
        }

        h2 {
            text-align: center;
            color: #2c3e50;
        }

        form {
            max-width: 300px;
            margin: 20px auto;
            background-color: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        input {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 4px;
            box-sizing: border-box;
            background-color: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
        }

        /* Estilos para o botão */
        input[type="submit"] {
            background-color: #7D0098;
            color: #fff;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        input[type="button"] {
            background-color: #530065;
            color: #fff;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
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
            color: #2c3e50;
        }

        @media screen and (max-width: 768px) {
            body {
                background-image: url('bk2.jpg');
                background-size: 210%;
            }
        }
    </style>
</head>

<body>
    <?php
    // Verificar se o formulário foi enviado
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Conectar ao banco de dados
        $host = "localhost";
        $username = "root";
        $password = "patosgordos17";
        $dbname = "janiobd";
        $conn = new mysqli($host, $username, $password, $dbname);
        // Verificar a conexão
        if ($conn->connect_error) {
            die("Conexão falhou: " . $conn->connect_error);
        }
        // Recuperar dados do formulário
        $email = $_POST['email'];
        $senha = $_POST['senha'];
        // Consultar o banco de dados para verificar as credenciais
        $sql = "SELECT * FROM Utilizadores WHERE Email = '$email'";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            if (password_verify($senha, $row['Senha'])) {
                // Credenciais corretas, iniciar a sessão
                session_start();
                $_SESSION['user_id'] = $row['ID'];
                $_SESSION['nome_usuario'] = $row['NomeUsuario'];
                $_SESSION['isAdmin'] = ($row['Funcao'] == 'administrador');
                // Redirecionar para a página inicial
                header("Location: ../index.php");
                exit();
            } else {
                echo "<p>Senha incorreta.</p>";
            }
        } else {
            echo "<p>Usuário não encontrado.</p>";
        }
        // Fechar a conexão
        $conn->close();
    }
    ?>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <h2>Login</h2>
        <input type="email" id="email" name="email" placeholder="email" required><br>
        <input type="password" id="senha" name="senha" placeholder="senha" required><br>
        <input type="submit" value="Login">
        <a href="processar_registro.php">
            <input type="button" value="Registrar-se">
        </a>
        <p><a href="../index.php">Voltar para página inicial</a></p>
    </form>
</body>

</html>