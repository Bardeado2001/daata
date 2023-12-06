<?php
include 'user/conexao.php'
?>
<!DOCTYPE html>
<html lang="pt">

<head>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="seuarquivo.css">
</head>

<body>
  <!-- NAVBAR -->
  <?php include 'chamadas/navbar.php'; ?>

  <!-- INICIAL PAGE -->
  <?php include 'chamadas/pagina_inicial.php'; ?>

  <!--CONTEÚDO DINÂMICO-->
  <div id="dinamic">
  </div>
  
  <!--FEED NOTÍCIAS-->
  <div id="feed">
    <h1>Notícias</h1>
    <?php
    // Conectar ao banco de dados
    $conn = new mysqli($host, $username, $password, $dbname);
    // Verificar a conexão
    if ($conn->connect_error) {
      die("Falha na conexão com o banco de dados: " . $conn->connect_error);
    }

    // Consultar todas as notícias
    $sql = "SELECT * FROM Noticias";
    $result = $conn->query($sql);

    // Exibir notícias existentes
    if ($result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
        echo "<div class='noti'>";
        echo "<a href='javascript:void(0);' onclick='carregarPagina(\"chamadas/noticia_completa.php?id=" . $row['id'] . "\")' class='noticia-link'>";
        echo "<p class='notema'><strong>Tema:</strong> " . $row['tema'] . "</p>";
        echo "<img class='notiimagem' src='data:image/jpeg;base64," . base64_encode($row['imagem']) . "' />";
        echo "</a>";
        echo "</div>";
      }
    } else {
      echo "<p>Nenhuma notícia encontrada.</p>";
    }

    // Fechar a conexão
    $conn->close();
    ?>
  </div>
  </div>
  <footer>
    <div class="footer-content">
      <div class="contact-info">
        <h4>Entre em Contato</h4>
        <p>Email: info@janioentertainment.com</p>
        <p>Telefone: (XX) XXXX-XXXX</p>
      </div><br>
      <div class="social-links">
        <a href="https://facebook.com/janioentertainment" target="_blank"><i class="fab fa-facebook"></i></a>
        <a href="https://twitter.com/janioentertain" target="_blank"><i class="fab fa-twitter"></i></a>
        <a href="https://instagram.com/janioentertainment" target="_blank"><i class="fab fa-instagram"></i></a>
      </div>
    </div><br>
    <div class="footer-bottom">
      <p>&copy; 2023 Janio Entertainment. Todos os direitos reservados.</p>
    </div>
  </footer>
  <!-- SCRIPTS -->
  <?php include 'chamadas/scripts.php'; ?>
</body>

</html>