<?php
session_start();

// Verificar se o usuário está autenticado como administrador
if (!isset($_SESSION['user_id']) || !$_SESSION['isAdmin']) {
    header("Location: login.php");
    exit();
}

include '../user/conexao.php';

// Inicializar variáveis para os campos do formulário
$nomeProjeto = $descricaoProjeto = $dataInicio = $dataTerminoPrevista = $responsavelProjeto = $tecnologiaUsada = $imagemProjeto = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recuperar dados do formulário
    $nomeProjeto = $_POST['nome_projeto'];
    $descricaoProjeto = $_POST['descricao_projeto'];
    $dataInicio = $_POST['data_inicio'];
    $dataTerminoPrevista = $_POST['data_termino_prevista'];
    $responsavelProjeto = $_POST['responsavel_projeto'];
    $tecnologiaUsada = $_POST['tecnologia_usada'];

    // Processar a imagem do projeto
    $imagemProjeto = file_get_contents($_FILES['imagem_projeto']['tmp_name']); // Obter dados binários da imagem para poder mostar a imagem da base direto para o site :)

    // Inserir dados na tabela Projetos usando uma declaração preparada
    $stmt = $conn->prepare("INSERT INTO projetos (NomeProjeto, DescricaoProjeto, DataInicio, DataTerminoPrevista, ResponsavelProjeto, TecnologiaUsada, ImagemProjeto) VALUES (?, ?, ?, ?, ?, ?, ?)");

    $stmt->bind_param("sssssss", $nomeProjeto, $descricaoProjeto, $dataInicio, $dataTerminoPrevista, $responsavelProjeto, $tecnologiaUsada, $imagemProjeto);

    if ($stmt->execute()) {
        // Redirecionar para a página de gerenciamento de projetos com mensagem de sucesso
        header("Location: gerenciar_projetos.php?sucesso=projeto_adicionado");
        exit();
    } else {
        echo "Erro ao adicionar projeto: " . $stmt->error;
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
    <title>Adicionar Projeto</title>
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

        p {
            text-align: center;
        }

        a {
            text-decoration: none;
        }
    </style>
</head>

<body>
    <h2>Adicionar Projeto</h2>
    <p><a href="gerenciar_projetos.php">Voltar para Gerenciar Projetos</a></p>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
        <label for="nome_projeto">Nome do Projeto:</label>
        <input type="text" id="nome_projeto" name="nome_projeto" required><br>
        <label for="descricao_projeto">Descrição do Projeto:</label>
        <textarea id="descricao_projeto" name="descricao_projeto" required></textarea><br>
        <label for="data_inicio">Data de Início:</label>
        <input type="date" id="data_inicio" name="data_inicio" required><br>
        <label for="data_termino_prevista">Data de Término Prevista:</label>
        <input type="date" id="data_termino_prevista" name="data_termino_prevista" required><br>
        <label for="responsavel_projeto">Responsável pelo Projeto:</label>
        <input type="text" id="responsavel_projeto" name="responsavel_projeto" required><br>
        <label for="tecnologia_usada">Tecnologia Usada:</label>
        <input type="text" id="tecnologia_usada" name="tecnologia_usada" required><br>
        <label for="imagem_projeto">Imagem do Projeto:</label>
        <input type="file" id="imagem_projeto" name="imagem_projeto" accept="image/*" required><br>
        <input type="submit" value="Adicionar Projeto">
    </form>
</body>

</html>