<div class="login">
    <h1>Iniciar Sessió</h1>
    
    <?php
    if (isset($_GET['error']) && $_GET['error'] === 'invalid_credentials') {
        echo '<p class="error-message">Correu o contrasenya incorrectes. Intenta-ho de nou.</p>';
    }
    ?>

    <form action="/controlador/c_login.php" method="POST">
        <label for="mail">Correu Electrònic</label>
        <input type="email" id="mail" name="mail" placeholder="Introdueix el teu correu electrònic" required>

        <label for="password">Contrasenya</label>
        <input type="password" id="password" name="password" placeholder="Introdueix la contrasenya" required>

        <button type="submit">Iniciar Sessió</button>
    </form>
</div>


