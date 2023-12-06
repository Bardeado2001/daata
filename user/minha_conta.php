<?php
session_start();

// Verificar se o usuário está autenticado
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Conectar ao banco de dados (substitua com suas credenciais)
include 'conexao.php';

// Função para obter dados do usuário
function obterDadosUsuario($conn, $userID)
{
    $sql = "SELECT * FROM Utilizadores WHERE ID = $userID";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        return $result->fetch_assoc();
    } else {
        return null;
    }
}

// Função para obter consultas futuras do usuário
function obterConsultasFuturas($conn, $nomeUsuario)
{
    $sql = "SELECT * FROM pedidosmarcacao WHERE NomeUsuario = '$nomeUsuario' AND DataConsulta > NOW()";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        return $result->fetch_all(MYSQLI_ASSOC);
    } else {
        return null;
    }
}

$userID = $_SESSION['user_id'];
$dadosUsuario = obterDadosUsuario($conn, $userID);
$consultasFuturas = obterConsultasFuturas($conn, $_SESSION['nome_usuario']);

// Fechar a conexão
$conn->close();
?>

<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Minha Conta</title>
    <style>
        body {
            font-family: -apple-system, system-ui, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        #pedidos {
            background-color: #fff;
            padding: 20px;
            width: 50%;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin: 20px auto;
        }

        h2,
        h3 {
            text-align: center;
            color: #2c3e50;
        }

        p {
            text-align: center;
        }

        a {
            display: block;
            text-align: center;
            margin-top: 20px;
            color: #3498db;
            text-decoration: none;
        }

        a:hover {
            color: #e74c3c;
        }

        button {
            display: block;
            margin: 10px auto;
            padding: 5px 10px;
            background-color: #3498db;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background-color: #e74c3c;
        }

        form {
            max-width: 300px;
            margin: 20px auto;
        }

        label {
            display: block;
            margin-bottom: 5px;
        }

        input[type="datetime-local"],
        textarea {
            width: 100%;
            padding: 5px;
            margin-bottom: 10px;
        }

        ul {
            list-style: none;
            padding: 0;
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin: 20px auto;
            width: 50%;

        }

        li {
            margin-bottom: 10px;
            text-align: center;
            max-width: 100%;
            white-space: normal;
            word-wrap: break-word;
            margin: 20px auto;
        }

        li a {
            color: #e74c3c;
            margin-left: 10px;
            text-decoration: none;
        }

        li a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <h2>Minha Conta</h2>

    <?php if ($dadosUsuario) : ?>

        <h3>Dados Pessoais</h3>
        <p>Nome: <?php echo $dadosUsuario['Nome']; ?></p>
        <p>Email: <?php echo $dadosUsuario['Email']; ?></p>
        <p>Telefone: <?php echo $dadosUsuario['Telefone']; ?></p>
        <a href="editar_perfil.php" style="text-decoration: none;"><button type="button">Editar Perfil</button></a>

        <?php if ($_SESSION['isAdmin']) : ?>
            <!-- Mostrar opções adicionais para administradores, se necessário. Mas não vai ser, pq o admim altera os seus dados na area adm -->
        <?php endif; ?>
        <a href="../index.php">Voltar Para a Página Inicial</a><br>

        <div id="pedidos">
            <h3>Pedido de Marcação</h3>
            <form action="processar_pedido.php" method="post">
                <label for="data_consulta">Data da Consulta:</label>
                <input type="datetime-local" id="data_consulta" name="data_consulta" required><br>
                <label for="observacoes">Observações:</label>
                <textarea id="observacoes" name="observacoes"></textarea><br>
                <input type="submit" value="Solicitar Consulta">
            </form>
        </div>

        <h3>Consultas Futuras</h3>
        <?php if ($consultasFuturas) : ?>
            <ul>
                <?php foreach ($consultasFuturas as $consulta) : ?>
                    <?php
                    $dataAtual = time();
                    $dataConsulta = strtotime($consulta['DataConsulta']);
                    $diferencaTempo = $dataConsulta - $dataAtual;
                    $podeModificar = $diferencaTempo > 72 * 3600; // 72 horas em segundos
                    ?>
            <li>Data: <?php echo $consulta['DataConsulta']; ?><br>Observações:<br><?php echo $consulta['Observacoes']; ?>
            <?php if ($podeModificar) : ?>
                    <a href="modificar_consulta.php?id=<?php echo $consulta['ID']; ?>">Modificar</a>
                <?php endif; ?>
            <a href="cancelar_consulta.php?id=<?php echo $consulta['ID']; ?>">Cancelar</a>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else : ?>
            <p>Não há consultas futuras.</p>
        <?php endif; ?>

    <?php else : ?>
        <p>Erro ao obter dados do usuário.</p>
    <?php endif; ?>

</body>

</html>