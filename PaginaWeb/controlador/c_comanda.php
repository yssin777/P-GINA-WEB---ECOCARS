<?php
require_once __DIR__ . '/../model/m_conectaDB.php';
require_once __DIR__ . '/../model/m_comanda.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_SESSION['user_id'])) {
        http_response_code(401);
        exit;
    }

    if (!isset($_SESSION['carrito']) || empty($_SESSION['carrito'])) {
        http_response_code(400);
        exit;
    }

    $conn = connectaDB();
    $orderId = saveOrder($conn, $_SESSION['user_id'], $_SESSION['carrito']);

    if ($orderId) {
        $_SESSION['order_id'] = $orderId;
        $_SESSION['carrito'] = [];
        $_SESSION['totalCantidad'] = 0;
        $_SESSION['totalPrecio'] = 0;
        http_response_code(200);
    } else {
        http_response_code(500);
    }
    exit;
}

if (!isset($_SESSION['user_id'])) {
    header('Location: index.php?action=login');
    exit;
}

if (!isset($_SESSION['carrito']) || empty($_SESSION['carrito'])) {
    header('Location: index.php?action=ver-carrito');
    exit;
}

$conn = connectaDB();
$orderId = saveOrder($conn, $_SESSION['user_id'], $_SESSION['carrito']);

if ($orderId) {
    $cartBackup = $_SESSION['carrito'];
    
    $_SESSION['carrito'] = [];
    $_SESSION['totalCantidad'] = 0;
    $_SESSION['totalPrecio'] = 0;

    $order = getOrder($conn, $orderId);
    
    require __DIR__ . '/../vista/v_confirmaComanda.php';
} else {
    error_log('Failed to save order');
    header('HTTP/1.1 500 Internal Server Error');
    echo json_encode(['error' => 'Error al procesar la comanda']);
    exit;
}
?>