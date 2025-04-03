<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="/./style.css">
    <script type="text/javascript" src="/js/fetch.js"></script>
</head>

<body class="container">

    <div id = "blocProducte">
        <?php 
        $producte = isset($_GET['producte']) ? (int)$_GET['producte'] : null; 

        if ($producte && $producte > 0) {
            require __DIR__ . '/../controlador/c_mostrarProducte.php'; 
        } else {
            echo "<h1>Error: Categoría no especificada o invàlida.</h1>";
        }
        ?>
    </div>
    <?php require __DIR__. '/../controlador/c_barraInferior.php'; ?>
</body>
</html>