<?php
require_once __DIR__.'/../model/m_conectaDB.php';
require_once __DIR__.'/../model/m_llistaCategories.php';

$connexio = connectaDB();

$categories = getCategories($connexio);

foreach ($categories as $key => $categoria) {
    $categories[$key]['nom'] = htmlentities($categoria['nom'], ENT_QUOTES | ENT_HTML5, 'UTF-8');
    $categories[$key]['descripcioc'] = htmlentities($categoria['descripcioc'], ENT_QUOTES | ENT_HTML5, 'UTF-8');
}

require __DIR__.'/../vista/v_llistaCategories.php';

?>
