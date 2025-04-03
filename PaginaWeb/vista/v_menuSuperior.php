<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>EcoCars</title>
  <script src="/js/fetch.js"></script>
</head>

<header>
  <div class="navbar">
    <a href="index.php?action=llistar-categories" class="logo"><img src="/img/logo.png" width="120px"></a>
    <?php
    $action = isset($_GET['action']) ? $_GET['action'] : '';
    
    error_log('Current action: ' . $action);
    
    if (!in_array($action, ['login', 'signin', 'ver-perfil', 'editar-perfil', 'ver-carrito', 'mis-pedidos'])): ?>
        <div class="search-container">
            <input type="text" id="searchInput" placeholder="Cerca productes...">
            <button onclick="searchProducts()">Cercar</button>
        </div>
    <?php endif; ?>
    
    <div class="menu">
    <?php
    $action = isset($_GET['action']) ? $_GET['action'] : '';

    if ($action !== 'login' && $action !== 'signin' && $action !== 'ver-perfil-' && $action !== 'editar-perfil'){ ?>
      <button class="imgCarrito" onclick="window.location.href='index.php?action=ver-carrito'"><img src="/img/carrito.png" width="20px"></button>
    <?php } ?>
        <div class="usuario">
          <?php 
          $defaultProfilePic = "/img/perfil.png";
          
          $profilePicture = isset($_SESSION['profile_picture']) && !empty($_SESSION['profile_picture']) 
              ? $_SESSION['profile_picture'] 
              : $defaultProfilePic;
          ?>
          <button class="btn-perfil">
            <img src="<?php echo htmlspecialchars($profilePicture); ?>" width="25px" 
              style="object-fit: cover; border-radius: 50%;">
          </button>

          <div class="opciones-usuario">
            <?php if (isset($_SESSION['user_id'])):?>
              <a href="index.php?action=logout">Tancar Sessió</a>
              <a href="index.php?action=ver-perfil">Veure Perfil</a>
              <a href="index.php?action=mis-pedidos">Les meves comandes</a>
            <?php endif; ?>
            <?php if (!isset($_SESSION['user_id'])): ?>
              <a href="index.php?action=login">Iniciar Sessió</a>
              <a href="index.php?action=signin">Registrar-se</a>
            <?php endif; ?>
            
          </div>
        </div>
      </div>
  </div>
  
  <?php if (!in_array($action, ['login', 'signin', 'ver-perfil', 'editar-perfil', 'ver-carrito', 'mis-pedidos'])): ?>
    <div class="categories-bar">
        <a href="javascript:void(0);" onclick="fetchllistaProductes(1)">Compacte</a>
        <a href="javascript:void(0);" onclick="fetchllistaProductes(3)">Premium</a>
        <a href="javascript:void(0);" onclick="fetchllistaProductes(4)">Monovolum</a>
        <a href="javascript:void(0);" onclick="fetchllistaProductes(5)">Minibus</a>
        <a href="javascript:void(0);" onclick="fetchllistaProductes(2)">SUV</a>
    </div>
  <?php endif; ?>
</header>