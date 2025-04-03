<div class="mostraPerfil">
    <div class = "fotoPerfil">
        <?php 
        $pathfotoperfil = $perfil['fotoperfil'];
        $fotoMostrar = $pathfotoperfil ? $pathfotoperfil : '/../img/perfil.png'; 
        ?>
        <img src="<?php echo $fotoMostrar; ?>" alt="Foto de perfil" />
    </div>
    <p><?php echo $perfil['nom'] ?></p>
    <p><?php echo $perfil['mail'] ?></p>
    <p><?php echo $perfil['telefon'] ?></p>
    <p><?php echo $perfil['direccio'] ?></p>

    <a href="index.php?action=editar-perfil">Editar Perfil</a>
</div>