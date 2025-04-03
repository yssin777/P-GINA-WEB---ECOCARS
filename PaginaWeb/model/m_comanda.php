<?php
function getOrder($conn, $orderId) {
    $query = "SELECT * FROM comanda WHERE id = $1";
    $result = pg_query_params($conn, $query, [$orderId]);
    return pg_fetch_assoc($result);
}

function saveOrder($conn, $userId, $cart) {
    try {
        error_log('Starting order save with cart: ' . print_r($cart, true));
        
        pg_query($conn, "BEGIN");

        $totalQuantity = array_sum(array_column($cart, 'quantity'));
        $totalPrice = array_sum(array_map(function($item) {
            return $item['price'] * $item['quantity'];
        }, $cart));

        $query = "INSERT INTO comanda (data_creacio, num_elements, import_total, id_usuari) 
                 VALUES (CURRENT_TIMESTAMP, $1, $2, $3) RETURNING id";
        $result = pg_query_params($conn, $query, [$totalQuantity, $totalPrice, $userId]);
        
        if (!$result) {
            error_log('Failed to insert main order: ' . pg_last_error($conn));
            pg_query($conn, "ROLLBACK");
            return false;
        }

        $orderId = pg_fetch_result($result, 0, 0);

        foreach ($cart as $item) {
            if (!isset($item['id'])) {
                error_log('Missing product ID for item: ' . print_r($item, true));
                pg_query($conn, "ROLLBACK");
                return false;
            }

            $itemTotal = $item['price'] * $item['quantity'];
            
            error_log("Inserting order line - ProductID: {$item['id']}, Quantity: {$item['quantity']}, Total: $itemTotal");
            
            $result = pg_query_params($conn, 
                "INSERT INTO linia_comanda (num_producte, preu_total, id_producte, id_comanda) 
                 VALUES ($1, $2, $3, $4)",
                [$item['quantity'], $itemTotal, $item['id'], $orderId]
            );

            if (!$result) {
                error_log('Failed to insert order line: ' . pg_last_error($conn));
                pg_query($conn, "ROLLBACK");
                return false;
            }
        }

        pg_query($conn, "COMMIT");
        return $orderId;

    } catch (Exception $e) {
        error_log('Order processing error: ' . $e->getMessage());
        pg_query($conn, "ROLLBACK");
        return false;
    }
}
?>