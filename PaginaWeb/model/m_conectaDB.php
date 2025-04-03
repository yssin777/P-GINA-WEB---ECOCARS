<?php
function connectaDB(){
    $servidor = "127.0.0.1";
    $port = "5432";
    $DBnom = "tdiw-e6";
    $usuari = "tdiw-e6";
    $clau = "granollers";
    $connexio = pg_connect("host=$servidor port=$port dbname=$DBnom user=$usuari password=$clau");

   return($connexio);
}
?>
