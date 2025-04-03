<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $_SESSION['carrito'] = [];
    $_SESSION['totalCantidad'] = 0;
    $_SESSION['totalPrecio'] = 0;

    echo json_encode([
        'totalCantidad' => $_SESSION['totalCantidad'],
        'totalPrecio' => $_SESSION['totalPrecio']
    ]);
}
?>