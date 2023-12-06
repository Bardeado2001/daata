
<div class="navbar">
  <a href="javascript:void(0);" onclick="carregarPagina('chamadas/contactos.html')">Contactos</a>
  <a href="javascript:void(0);" onclick="carregarPagina('chamadas/pedido-de-orcamento.html')">Pedido de Orçamento</a>
  <a href="javascript:void(0);" onclick="carregarPagina('chamadas/projetos.php')">Projetos</a>
  <?php
  session_start();
  if (isset($_SESSION['user_id'])) {
    // Se o usuário estiver logado, exibe links para áreas restritas
    if (!$_SESSION['isAdmin']) { // Não exibir para admin, ele pode editar os seus dados na area adm
      echo '<a href="user/minha_conta.php">Minha Conta</a>';
    }
    
    if ($_SESSION['isAdmin']) {
      echo '<a href="adm/area_admin.php">Área Administrativa</a>';
    }
    echo '<a href="user/logout.php">Logout</a>';
  } else {
    // Se o usuário não estiver logado, exibe link para a página de login e de registro
    echo '<a href="user/login.php">Login</a>';
    echo '<a href="user/processar_registro.php">Registro</a>';
  }
  ?>
</div>
