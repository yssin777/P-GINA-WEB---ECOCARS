<?php
function searchProducts($conn, $term) {
    if (!$conn) {
        return ['error' => 'No connection to database'];
    }

    $term = '%' . $term . '%';
    $query = "SELECT * FROM producte WHERE nom ILIKE $1";
    $result = pg_query_params($conn, $query, [$term]);

    if (!$result) {
        return [];
    }

    return pg_fetch_all($result) ?: []; 
}


?>