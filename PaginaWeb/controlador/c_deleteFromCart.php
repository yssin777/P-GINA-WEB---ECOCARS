<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);
    $index = $input['index'] ?? null;

    if ($index === null || !isset($_SESSION['carrito'][$index])) {
        http_response_code(400);
        echo json_encode(['error' => 'Índice no válido']);
        exit;
    }

    unset($_SESSION['carrito'][$index]);
    $_SESSION['carrito'] = array_values($_SESSION['carrito']);

    $_SESSION['totalCantidad'] = array_sum(array_column($_SESSION['carrito'], 'quantity'));
    $_SESSION['totalPrecio'] = array_sum(array_map(function($producto) {
        return $producto['price'] * $producto['quantity'];
    }, $_SESSION['carrito']));

    echo json_encode([
        'totalCantidad' => $_SESSION['totalCantidad'],
        'totalPrecio' => $_SESSION['totalPrecio']
    ]);
}
?>