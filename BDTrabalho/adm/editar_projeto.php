<?php
session_start();

// Verificar se o usuário está autenticado como administrador
if (!isset($_SESSION['user_id']) || !$_SESSION['isAdmin']) {
    header("Location: login.php");
    exit();
}

// Conectar ao banco de dados
include '../user/conexao.php';

// Inicializar variáveis
$id = $nomeProjeto = $descricaoProjeto = $dataInicio = $dataTerminoPrevista = $responsavelProjeto = $tecnologiaUsada = $imagemProjeto = "";

// Verificar se o ID do projeto foi passado pela URL
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];

    // Consultar o projeto específico
    $sql = "SELECT * FROM projetos WHERE ID = $id";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $nomeProjeto = $row['NomeProjeto'];
        $descricaoProjeto = $row['DescricaoProjeto'];
        $dataInicio = $row['DataInicio'];
        $dataTerminoPrevista = $row['DataTerminoPrevista'];
        $responsavelProjeto = $row['ResponsavelProjeto'];
        $tecnologiaUsada = $row['TecnologiaUsada'];
        $imagemProjeto = $row['ImagemProjeto'];
    } else {
        echo "Projeto não encontrado.";
        exit();
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recuperar dados do formulário
    $nomeProjeto = $_POST['nome_projeto'];
    $descricaoProjeto = $_POST['descricao_projeto'];
    $dataInicio = $_POST['data_inicio'];
    $dataTerminoPrevista = $_POST['data_termino_prevista'];
    $responsavelProjeto = $_POST['responsavel_projeto'];
    $tecnologiaUsada = $_POST['tecnologia_usada'];

    // Verificar se o campo de upload de imagem está vazio
    if (!empty($_FILES['imagem_projeto']['tmp_name'])) {
        // Processar a nova imagem do projeto apenas se o campo não estiver vazio
        $imagemProjeto = file_get_contents($_FILES['imagem_projeto']['tmp_name']);
    }

    // Atualizar os dados na tabela Projetos usando uma declaração preparada
    if (isset($imagemProjeto)) {
        $stmt = $conn->prepare("UPDATE projetos SET NomeProjeto=?, DescricaoProjeto=?, DataInicio=?, DataTerminoPrevista=?, ResponsavelProjeto=?, TecnologiaUsada=?, ImagemProjeto=? WHERE ID=?");
        $stmt->bind_param("sssssssi", $nomeProjeto, $descricaoProjeto, $dataInicio, $dataTerminoPrevista, $responsavelProjeto, $tecnologiaUsada, $imagemProjeto, $id);
    } else {
        // Se o campo de imagem estiver vazio, não atualize a imagem na base de dados
        $stmt = $conn->prepare("UPDATE projetos SET NomeProjeto=?, DescricaoProjeto=?, DataInicio=?, DataTerminoPrevista=?, ResponsavelProjeto=?, TecnologiaUsada=? WHERE ID=?");
        $stmt->bind_param("ssssssi", $nomeProjeto, $descricaoProjeto, $dataInicio, $dataTerminoPrevista, $responsavelProjeto, $tecnologiaUsada, $id);
    }

    if ($stmt->execute()) {
        // Redirecionar para a página de gerenciamento de projetos com mensagem de sucesso
        header("Location: gerenciar_projetos.php?sucesso=projeto_atualizado");
        exit();
    } else {
        echo "Erro ao editar projeto: " . $stmt->error;
    }
    $stmt->close();
}
// Fechar a conexão
$conn->close();
?>

<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Projeto</title>
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
            max-width: 300px;
            height: auto;
            margin-bottom: 10px;
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
    <h2>Editar Projeto</h2>
    <p><a href="gerenciar_projetos.php">Voltar para Gerenciar Projetos</a></p>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . "?id=" . $id); ?>" method="post" enctype="multipart/form-data">
        <label for="nome_projeto">Nome do Projeto:</label>
        <input type="text" id="nome_projeto" name="nome_projeto" value="<?php echo $nomeProjeto; ?>" required><br>
        <label for="descricao_projeto">Descrição do Projeto:</label>
        <textarea id="descricao_projeto" name="descricao_projeto" required><?php echo $descricaoProjeto; ?></textarea><br>
        <label for="data_inicio">Data de Início:</label>
        <input type="date" id="data_inicio" name="data_inicio" value="<?php echo $dataInicio; ?>" required><br>
        <label for="data_termino_prevista">Data de Término Prevista:</label>
        <input type="date" id="data_termino_prevista" name="data_termino_prevista" value="<?php echo $dataTerminoPrevista; ?>" required><br>
        <label for="responsavel_projeto">Responsável pelo Projeto:</label>
        <input type="text" id="responsavel_projeto" name="responsavel_projeto" value="<?php echo $responsavelProjeto; ?>" required><br>
        <label for="tecnologia_usada">Tecnologia Usada:</label>
        <input type="text" id="tecnologia_usada" name="tecnologia_usada" value="<?php echo $tecnologiaUsada; ?>" required><br>
        <label for="imagem_projeto">Imagem do Projeto:</label>
        <input type="file" id="imagem_projeto" name="imagem_projeto" accept="image/*"><br>
        <img src='data:image/jpeg;base64,<?php echo base64_encode($imagemProjeto); ?>' width='100' height='100'><br>
        <input onclick="confirmarAtualizacao()" type="submit" value="Atualizar Projeto">
    </form>

    <script>
    function confirmarAtualizacao() {
        if (document.getElementById('remover_imagem') && document.getElementById('remover_imagem').checked) {
            // Se a caixa de remoção estiver marcada, confirmar a exclusão da imagem existente
            return confirm('Tem certeza de que deseja remover a imagem existente?');
        }
        return confirm('Tem certeza de que deseja atualizar o projeto?');
    }
</script>
</body>

</html>