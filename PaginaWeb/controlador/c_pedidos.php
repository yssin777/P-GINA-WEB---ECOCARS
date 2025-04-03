<?php
require_once __DIR__ . '/../model/m_conectaDB.php';
require_once __DIR__ . '/../model/m_pedidos.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: index.php?action=login');
    exit;
}

$conn = connectaDB();
$orders = getUserOrders($conn, $_SESSION['user_id']);

foreach ($orders as &$order) {
    $order['productos'] = getOrderProducts($conn, $order['id']);
}

require __DIR__ . '/../vista/v_pedidos.php';

?>