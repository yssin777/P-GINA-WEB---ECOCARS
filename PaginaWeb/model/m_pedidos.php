<?php
function getUserOrders($conn, $userId) {
    $query = "SELECT 
                c.*,
                array_agg(
                    json_build_object(
                        'nom', p.nom,
                        'pathfoto', p.pathfoto,
                        'quantity', lc.num_producte,
                        'price', lc.preu_total
                    )
                    ORDER BY p.nom
                ) as productos
              FROM comanda c
              INNER JOIN linia_comanda lc ON c.id = lc.id_comanda
              INNER JOIN producte p ON lc.id_producte = p.id
              WHERE c.id_usuari = $1
              GROUP BY c.id, c.data_creacio
              ORDER BY c.data_creacio DESC";
              
    $result = pg_query_params($conn, $query, [$userId]);
    return pg_fetch_all($result);
}

function getOrderProducts($conn, $orderId) {
    $query = "SELECT p.nom, lc.num_producte AS quantity, lc.preu_total AS price, p.pathfoto
              FROM linia_comanda lc
              JOIN producte p ON lc.id_producte = p.id
              WHERE lc.id_comanda = $1";

    $result = pg_query_params($conn, $query, [$orderId]);

    if ($result) {
        $products = pg_fetch_all($result);

        return $products;
    } else {
        return [];
    }
}


?>