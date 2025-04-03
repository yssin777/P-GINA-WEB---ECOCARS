<body id="layoutproductes">

    <div id="productes">
        <?php foreach($productes as $producte) { ?>
            <div id="producte">
                <a href="javascript:void(0);" onclick="fetchMostraProducte(<?php echo $producte['id']; ?>)">

                    <img src="<?php echo $producte['pathfoto'] ?>" alt="Imagen del producto">
                    <p><?php echo $producte['nom'] ?></p>
                    <p><?php echo $producte['preu'] ?>€</p>
                </a>
            </div>
        <?php } ?>
    </div>
</body>


