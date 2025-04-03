<?php
require_once __DIR__.'/../model/m_conectaDB.php';
require_once __DIR__.'/../model/m_llistaProductes.php';

if (!isset($categoria) || !is_numeric($categoria) || $categoria <= 0) {
    die("Error: Categoría no es vàlida.");
}

$connexio = connectaDB();

$productes = getProductes($connexio, $categoria);

require __DIR__.'/../vista/v_llistaProductes.php';
?>