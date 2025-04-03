<?php

function getProducte($connexio, $producte)
{
    if (!is_numeric($producte)) {
        die("Error: El parámetro de producto no es válido.");
    }

    $sql_producte = "SELECT * FROM producte WHERE id = $1";
    $consulta_producte = pg_query_params($connexio, $sql_producte, [$producte]);

    if (!$consulta_producte) {
        $error = pg_last_error($connexio);
        die("Error en la consulta SQL: " . htmlspecialchars($error));
    }

    $resultat_producte = pg_fetch_all($consulta_producte);

    if ($resultat_producte === false || count($resultat_producte) === 0) {
        return null;
    }

    return $resultat_producte[0]; 
}

?>