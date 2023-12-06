<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portfólio de Projetos</title>
    <link rel="stylesheet" type="text/css" href="seuarquivo2.css">
    <style>
        body {
            background-color: #f4f4f4;
        }

        h6 {
            padding-top: 30px;
            font-size: 20px;
        }

        .galeria {
            display: flex;
            flex-direction: row;
            align-items: center;
            justify-content: center;
            text-align: center;
            width: 100%;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            height: 100%;
        }

        .imgs {
            width: 50%;
            margin: 2px;
        }

        .imgs img {
            width: 100%;
            cursor: pointer;
        }

        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.094);
            text-align: center;
        }

        .modal-content {
            max-width: 50%;
            margin: 0 auto;
            margin-top: 5%;
            color: rgb(0, 0, 0);
            background-color: rgb(255, 255, 255);
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }

        #modalImg {
            width: 40%;
            margin-bottom: 30px;
        }

        #closeBtn {
            position: absolute;
            top: 10px;
            right: 10px;
            font-size: 20px;
            cursor: pointer;
            color: red;
        }

        @media only screen and (max-width: 600px) {
            .modal-content {
                max-width: 100%;
                /* Ajuste a largura conforme necessário */
                max-height: 400px;
                margin-top: 0%;
                /* Ajuste a margem superior conforme necessário */
                font-size: 13px;
                background-color: #f4f4f4;
                margin-bottom: 400px;
                /* Adicione o valor desejado para o espaço vazio abaixo da div */

            }

            .modal {
                background-color: #f4f4f4;
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            }
            .galeria {
                background-color: rgb(255, 255, 255);
                padding-bottom: 150px;
            }
        }
    </style>

</head>

<body>
    <h1>Portfólio de Projetos</h1>
    <div class="galeria">
        <?php
        // Conectar ao banco de dados
        include '../user/conexao.php';

        // Consultar todos os projetos
        $sql = "SELECT * FROM projetos";
        $result = $conn->query($sql);

        // Exibir os projetos
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<div class='imgs'>
                        <img src='data:image/jpeg;base64," . base64_encode($row['ImagemProjeto']) . "' alt='Projeto' onclick=\"openModal('" . base64_encode($row['ImagemProjeto']) . "', '" . $row['DescricaoProjeto'] . "', '" . $row['DataInicio'] . "', '" . $row['DataTerminoPrevista'] . "', '" . $row['ResponsavelProjeto'] . "')\">
                        <h6>{$row['NomeProjeto']}</h6>
                    </div>";
            }
        } else {
            echo "Nenhum projeto encontrado.";
        }

        // Fechar a conexão
        $conn->close();
        ?>
    </div>

    <div class="modal" id="myModal">
        <div class="modal-content">
            <span id="closeBtn" onclick="closeModal()">&times;</span>
            <img id="modalImg" alt="Imagem de projeto">
            <p id="modalDescription"></p>
        </div>
    </div>

    <script>
        // Função para abrir o modal com a imagem e descrição
        function openModal(imageSrc, description, dataInicio, dataTermino, responsavel) {
            const modal = document.getElementById("myModal");
            const modalImg = document.getElementById("modalImg");
            const modalDescription = document.getElementById("modalDescription");

            modal.style.display = "block";
            modalImg.src = "data:image/jpeg;base64," + imageSrc;
            modalDescription.innerHTML = `
        <p>${description}</p><br>
        <p><strong>Data de Início:</strong> ${dataInicio}</p>
        <p><strong>Data de Término:</strong> ${dataTermino}</p>
        <p><strong>Responsável:</strong> ${responsavel}</p>`;
        }


        // Função para fechar o modal
        function closeModal() {
            const modal = document.getElementById("myModal");
            modal.style.display = "none";
        }

        // Fechar o modal ao clicar fora da imagem
        window.onclick = function(event) {
            const modal = document.getElementById("myModal");
            if (event.target === modal) {
                closeModal();
            }
        }
    </script>
</body>

</html>