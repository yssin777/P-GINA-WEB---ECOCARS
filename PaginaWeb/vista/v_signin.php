<div class="registre">
  <section>   

    <?php
    $registroExitoso = isset($_GET['success']) && $_GET['success'] === 'true';
    ?>

    <?php if ($registroExitoso): ?>
      <div class="Registre-exitos">
        <p>Usuari registrat exitosament! Ara pots iniciar sessió.</p>
        <a href="https://tdiw-e6.deic-docencia.uab.cat/index.php?action=login"><button>Iniciar Sessió</button></a>
      </div>
    <?php else: ?>
      <h1>Registre d'Usuari</h1>
        <form action="https://tdiw-e6.deic-docencia.uab.cat/index.php?action=signin" method="POST" enctype="multipart/form-data">
          <label for="mail">Correu Electrònic</label>
          <input type="email" id="mail" name="mail" placeholder="Introdueix el teu correu electrònic" required>

          <label for="telefon">Telèfon</label>
          <input type="text" id="telefon" name="telefon" placeholder="Introdueix el teu número telefònic" required>

          <label for="direccio">Direcció</label>
          <input type="text" id="direccio" name="direccio" placeholder="Introdueix la teva direcció" required>

          <label for="nom">Nom</label>
          <input type="text" id="nom" name="nom" placeholder="Introdueix el teu nom" required>

          <label for="password">Contrasenya</label>
          <input type="password" id="password" name="password" placeholder="Introdueix una contrasenya" required>

          <label for="profile_image">Escull foto de perfil</label>
          <input type="file" name="profile_image" accept=".jpg,.jpeg,.png"/>

          <button type="submit">Registrar</button>
        </form>
        <?php if (isset($errors) && !empty($errors)): ?>
          <ul class="error-messages">
            <?php foreach ($errors as $error): ?>
              <li><?php echo $error; ?></li>
            <?php endforeach; ?>
          </ul>
        <?php endif; ?>
    <?php endif; ?>
  </section>
</div>