<?php
session_start();
// Verificar se o usuário está autenticado
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
// Conectar ao banco de dados (substitua com suas credenciais)
include 'conexao.php';
// Verificar se o ID da consulta está presente na URL
if (!isset($_GET['id']) || empty($_GET['id'])) {
    // Redirecionar de volta para a página de consultas futuras
    header("Location: minha_conta.php");
    exit();
}
// Obter o ID da consulta da URL
$idConsulta = $_GET['id'];
// Função para obter dados da consulta
function obterDadosConsulta($conn, $idConsulta)
{
    $sql = "SELECT * FROM pedidosmarcacao WHERE ID = $idConsulta";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        return $result->fetch_assoc();
    } else {
        return null;
    }
}
// Obter dados da consulta
$dadosConsulta = obterDadosConsulta($conn, $idConsulta);
// Verificar se a consulta pode ser modificada
if (!$dadosConsulta) {
    // Consulta não encontrada, redirecionar
    header("Location: minha_conta.php");
    exit();
}
$dataAtual = time();
$dataConsulta = strtotime($dadosConsulta['DataConsulta']);
$diferencaTempo = $dataConsulta - $dataAtual;
$podeModificar = $diferencaTempo > 72 * 3600; // 72 horas em segundos
// Verificar se a consulta pode ser modificada
if (!$podeModificar) {
    // Consulta não pode ser modificada, redirecionar
    header("Location: minha_conta.php");
    exit();
}

// Processar o pedido de modificação da consulta
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obter os dados do formulário
    $novaDataConsulta = $_POST['data_consulta'];
    $novasObservacoes = $_POST['observacoes'];

    // Atualizar os dados da consulta no banco de dados
    $sqlAtualizarConsulta = "UPDATE pedidosmarcacao SET DataConsulta = '$novaDataConsulta', Observacoes = '$novasObservacoes' WHERE ID = $idConsulta";
    $conn->query($sqlAtualizarConsulta);

    // Redirecionar de volta para a página de consultas futuras
    header("Location: minha_conta.php");
    exit();
}

// Fechar a conexão
$conn->close();
?>

<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificar Consulta</title>
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
        textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
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

        p, a{
            text-align: center;
            text-decoration: none;
        }
    </style>
</head>

<body>
    <h2>Modificar Consulta</h2>
    <p><a href="minha_conta.php">Voltar para minha conta</a></p>
    <form action="" method="post">
        <label for="data_consulta">Nova Data da Consulta:</label>
        <input type="datetime-local" id="data_consulta" name="data_consulta" value="<?php echo date('Y-m-d\TH:i', strtotime($dadosConsulta['DataConsulta'])); ?>" required><br>
        <label for="observacoes">Novas Observações:</label>
        <textarea id="observacoes" name="observacoes"><?php echo $dadosConsulta['Observacoes']; ?></textarea><br>
        <input type="submit" value="Atualizar Consulta">
    </form>
</body>

</html>