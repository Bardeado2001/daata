<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulário de Registro</title>
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

        input,
        select {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 4px;
            box-sizing: border-box;
            background-color: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
        }

        select {
            appearance: none;
        }

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
        include 'conexao.php';
        // Recuperar dados do formulário
        $nome = $_POST['nome'];
        $apelido = $_POST['apelido'];
        $email = $_POST['email'];
        $telefone = $_POST['telefone'];
        $funcao = $_POST['funcao'];
        $nome_usuario = $_POST['nome_usuario'];
        $senha_usuario = $_POST['senha'];
        $senha_admin = $_POST['senha_admin'];

        // Verificar se o email já está registrado
        $sql_email_check = "SELECT * FROM Utilizadores WHERE Email='$email'";
        $result_email_check = $conn->query($sql_email_check);
        if ($result_email_check->num_rows > 0) {
            echo "<p>Email já registrado. Escolha outro email.</p>";
            $conn->close();
        }

        // Verificar se o nome de usuário já está registrado
        $sql_username_check = "SELECT * FROM Utilizadores WHERE NomeUsuario='$nome_usuario'";
        $result_username_check = $conn->query($sql_username_check);
        if ($result_username_check->num_rows > 0) {
            echo "<p>Nome de usuário já registrado. Escolha outro nome de usuário.</p>";
            $conn->close();
        }

        // Verificar a senha de adm
        if ($funcao == 'administrador') {
            if ($senha_admin != 'admsenha') {
                echo "<p>Senha de administrador incorreta.</p>";
                $conn->close();
            }
        }

        // Se não houver erros, inserir dados na tabela Utilizadores
        if (empty($email_error) && empty($username_error) && empty($admin_password_error)) {
            $senha = password_hash($senha_usuario, PASSWORD_DEFAULT);
            $sql = "INSERT INTO Utilizadores (Nome, Apelido, Email, Telefone, Funcao, NomeUsuario, Senha)
                VALUES ('$nome', '$apelido', '$email', '$telefone', '$funcao', '$nome_usuario', '$senha')";
            if ($conn->query($sql) === TRUE) {
                // Após o código de registro bem-sucedido
                header("Location: login.php");
                exit();
            } else {
                echo "<p>Erro ao registrar: </p>" . $conn->error;
            }
        }
        // Fechar a conexão
        $conn->close();
    }
    ?>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <h2>Registro</h2>
        <input type="text" id="nome" name="nome" placeholder="Nome" required><br>
        <input type="text" id="apelido" name="apelido" placeholder="Apelido" required><br>
        <input type="email" id="email" name="email" placeholder="Email" required><br>
        <input type="tel" id="telefone" name="telefone" placeholder="Telefone" required><br>
        <select id="funcao" name="funcao" required onchange="toggleAdminPassword()">
            <option value="usuario">Usuário</option>
            <option value="administrador">Administrador</option>
        </select><br>
        <div id="adminPassword" style="display: none;">
            <label for="senha_admin">Senha de Administrador:</label><br>
            <input type="password" id="senha_admin" name="senha_admin"><br><br>
        </div>
        <input type="text" id="nome_usuario" name="nome_usuario" placeholder="Username" required><br>
        <input type="password" id="senha" name="senha" placeholder="Senha" required>
        <input type="submit" value="Registrar">
        <a href="login.php">
            <input type="button" value="Fazer login">
        </a>
        <p><a href="../index.php">Voltar para página inicial</a></p>
    </form>
    <!-- SCRIPTS -->
    <script>
        function toggleAdminPassword() {
            var select = document.getElementById("funcao");
            var adminPasswordDiv = document.getElementById("adminPassword");

            if (select.value === "administrador") {
                adminPasswordDiv.style.display = "block";
            } else {
                adminPasswordDiv.style.display = "none";
            }
        }
    </script>
    <?php include 'scripts.php'; ?>
</body>

</html>

