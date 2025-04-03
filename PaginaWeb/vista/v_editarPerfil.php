<div class="editar">
    <h1>Modifica Dades del teu Perfil</h1>

    <form action="index.php?action=editar-perfil" method="POST" enctype="multipart/form-data">
        <p>Nom</p>
        <input type="text" name="name" placeholder="<?php echo htmlspecialchars($nom); ?>" value="<?php echo htmlspecialchars($nom); ?>">
        
        <p>Direcció</p>
        <input type="text" name="direccio" placeholder="<?php echo htmlspecialchars($direccio); ?>" value="<?php echo htmlspecialchars($direccio); ?>">
        
        <p>Telefon</p>
        <input type="tel" name="telefon" placeholder="<?php echo htmlspecialchars($telefon); ?>" value="<?php echo htmlspecialchars($telefon); ?>">
        
        <p>Email</p>
        <input type="email" name="email" placeholder="<?php echo htmlspecialchars($email); ?>" value="<?php echo htmlspecialchars($email); ?>">
        
        <p>Contraseña</p>
        <input type="password" name="password" placeholder="Nova Contrasenya">
        
        <p>Foto de Perfil</p>
        <input type="file" name="profile_image" accept=".jpg,.jpeg,.png"/>
        
        <p><button type="submit">Modificar</button></p>
    </form>
</div>

<script>
document.querySelector('form').addEventListener('submit', function(e) {
    const password = document.getElementById('password');
    if(password.value) {
        const passwordRegex = /^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/;
        if (!passwordRegex.test(password.value)) {
            e.preventDefault();
            alert('La contrasenya ha de tenir almenys 8 caràcters, incloent-hi lletres i nombres.');
        }
    }
});
</script>