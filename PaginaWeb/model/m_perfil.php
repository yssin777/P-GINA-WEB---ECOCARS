<?php
    function getPerfil($connPerfil){
        $sql_usuario = "SELECT * FROM usuari WHERE id = '".$_SESSION['user_id']."'";
        $consulta_usuario = pg_query($connPerfil, $sql_usuario) or die("Error sql usuario");
        $resultat_usuario = pg_fetch_all($consulta_usuario);

        return $resultat_usuario[0];
    }

    function getInfoUser(){
        $conn = connectaDB(); 
        $user_id = $_SESSION['user_id'];
        $result = pg_query($conn, "SELECT * FROM usuari WHERE id = " . $user_id);
        return pg_fetch_all($result);
    }
?>