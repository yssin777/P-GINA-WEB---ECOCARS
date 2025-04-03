<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="/./style.css">
    <script src="/../js/fetch.js"></script>
</head>

<body class="container">
    
    <div id = "blocProducte">
        <?php
        $categoria = isset($_GET['categoria']) ? (int)$_GET['categoria'] : null; 

        if ($categoria && $categoria > 0) {
            require __DIR__ . '/../controlador/c_llistaProductes.php'; 
        } else {
            echo "<h1>Error: Categoría no especificada o invàlida.</h1>";
        }
        ?>
    </div>
    <?php require __DIR__. '/../controlador/c_barraInferior.php'; ?>
</body>
</html>