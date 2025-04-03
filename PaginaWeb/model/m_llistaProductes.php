<?php

function getProductes($connexio, $categoria)
{
    if (!is_numeric($categoria)) {
        die("Error: Categoria no vàlida.");
    }

    $sql_productes = "SELECT * FROM producte WHERE id_categories = $1";

    $consulta_productes = pg_query_params($connexio, $sql_productes, [$categoria]);

    if (!$consulta_productes) {
        $error = pg_last_error($connexio);
        die("Error en la consulta SQL: " . htmlspecialchars($error));
    }

    $resultat_productes = pg_fetch_all($consulta_productes);

    if ($resultat_productes === false) {
        return []; 
    }

    return $resultat_productes;
}
?>
