<?php
require_once __DIR__ . '/../model/m_conectaDB.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_SESSION['user_id'])) {
        http_response_code(401);
        echo json_encode(['error' => 'Usuario no autenticado']);
        exit;
    }
    $input = json_decode(file_get_contents('php://input'), true);
    $idProd = $input['idProducte'] ?? null;
    $quantity = min(99, max(1, intval($input['quantity'] ?? 1)));

    if (!$idProd) {
        http_response_code(400);
        echo json_encode(['error' => 'ID de producto no válido']);
        exit;
    }

    $conn = connectaDB();

    $result = pg_query_params($conn, "SELECT nom, pathfoto, preu FROM producte WHERE id = $1", [$idProd]);
    if (!$result || pg_num_rows($result) === 0) {
        http_response_code(404);
        echo json_encode(['error' => 'Producto no encontrado']);
        exit;
    }

    $prod = pg_fetch_assoc($result);
    $name = $prod['nom'];
    $img = $prod['pathfoto'];
    $price = $prod['preu'];

    if (!isset($_SESSION['carrito'])) {
        $_SESSION['carrito'] = [];
    }

    $existe = false;
    foreach ($_SESSION['carrito'] as &$producto) {
        if ((string)$producto['id'] === (string)$idProd) {
            $producto['quantity'] += $quantity; 
            $existe = true;
            break;
        }
    }

    if (!$existe) {
        $_SESSION['carrito'][] = [
            'id' => $idProd,
            'name' => $name, 
            'image' => $img, 
            'price' => (float)$price, 
            'quantity' => $quantity
        ];
    }
    
    $_SESSION['totalCantidad'] = array_sum(array_column($_SESSION['carrito'], 'quantity'));
    $_SESSION['totalPrecio'] = array_sum(array_map(function($producto) {
        return $producto['price'] * $producto['quantity'];
    }, $_SESSION['carrito']));

    error_log('Cart data with IDs: ' . print_r($_SESSION['carrito'], true));

    header('Content-Type: application/json');
    echo json_encode([
        'success' => true,
        'totalCantidad' => $_SESSION['totalCantidad'],
        'totalPrecio' => $_SESSION['totalPrecio']
    ]);
}
?>