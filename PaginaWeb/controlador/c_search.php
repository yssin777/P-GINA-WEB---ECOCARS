<?php
require_once __DIR__ . '/../model/m_conectaDB.php';
require_once __DIR__ . '/../model/m_search.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['term'])) {
    $searchTerm = $_GET['term'];
    
    $conn = connectaDB();
    $results = searchProducts($conn, $searchTerm);
    
    header('Content-Type: application/json');
    echo json_encode($results);
    exit;
}

?>
