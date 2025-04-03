<?php
require_once __DIR__.'/../model/m_conectaDB.php';
require_once __DIR__.'/../model/m_mostrarProducte.php';

$connexio = connectaDB();

$mostraProducte = getProducte($connexio, $producte);

require __DIR__.'/../vista/v_mostraProducte.php';
?>