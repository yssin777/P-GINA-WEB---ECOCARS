<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);
    $index = $input['index'] ?? null;
    $quantity = $input['quantity'] ?? null;

    if ($index === null || 
        $quantity === null || 
        !isset($_SESSION['carrito'][$index])) {
        http_response_code(400);
        echo json_encode(['error' => 'Invalid input data']);
        exit;
    }

    $quantity = max(1, min(99, intval($quantity)));

    $_SESSION['carrito'][$index]['quantity'] = $quantity;

    $_SESSION['totalCantidad'] = array_sum(array_column($_SESSION['carrito'], 'quantity'));
    $_SESSION['totalPrecio'] = array_sum(array_map(function($producto) {
        return $producto['price'] * ($producto['quantity'] ?? 1);
    }, $_SESSION['carrito']));

    echo json_encode([
        'totalCantidad' => $_SESSION['totalCantidad'],
        'totalPrecio' => $_SESSION['totalPrecio']
    ]);
}
?>