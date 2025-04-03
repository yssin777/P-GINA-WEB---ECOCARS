<?php 
    require __DIR__.'/../model/m_conectaDB.php';
    require __DIR__.'/../model/m_perfil.php';

    $connPerfil = connectaDB();
    $perfil = getPerfil($connPerfil);

    require __DIR__.'/../vista/v_verPerfil.php';
?>