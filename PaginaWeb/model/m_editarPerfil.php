<?php

    function modificaNom($nouNom, $connexioNom){
        $idUsuari = $_SESSION['user_id'];

        $sql = "UPDATE usuari SET nom = '$nouNom' WHERE id = $idUsuari";

        $consulta = pg_query($connexioNom, $sql);

        if($consulta)
        {
            return TRUE;
        }
    }

    function modificaMail($nouMail, $connexioMail){
        $idUsuari = $_SESSION['user_id'];

        $sql = "UPDATE usuari SET mail = '$nouMail' WHERE id = $idUsuari";

        $consulta = pg_query($connexioMail, $sql);

        if($consulta)
        {
            return TRUE;
        }

    }

    function modificaTelefon($nouTelefon, $connexioTelefon){
        $idUsuari = $_SESSION['user_id'];

        $sql = "UPDATE usuari SET telefon = '$nouTelefon' WHERE id = $idUsuari";

        $consulta = pg_query($connexioTelefon, $sql);

        if($consulta)
        {
            return TRUE;
        }
    }

    function modificaDireccio($nouDireccio, $connexioDireccio){
        $idUsuari = $_SESSION['user_id'];

        $sql = "UPDATE usuari SET direccio = '$nouDireccio' WHERE id = $idUsuari";

        $consulta = pg_query($connexioDireccio, $sql);

        if($consulta)
        {
            return TRUE;
        }
    }

    function modificaContrasenya($nouContrasenya, $connexioContrasenya){
        $idUsuari = $_SESSION['user_id'];

        $sql = "UPDATE usuari SET password = '$nouContrasenya' WHERE id = $idUsuari";

        $consulta = pg_query($connexioContrasenya, $sql);

        if($consulta)
        {
            return TRUE;
        }
    }

    function modificaFoto($nouPath, $connexioNom) {
        $idUsuari = $_SESSION['user_id'];
        
        $sql = "UPDATE usuari SET fotoperfil = '$nouPath' WHERE id = $idUsuari";
        
        $consulta = pg_query($connexioNom, $sql);
        
        return $consulta ? TRUE : FALSE;
    }

?>