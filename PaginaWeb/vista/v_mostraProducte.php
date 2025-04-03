<div class="mostraProducte">
    <img src="<?php echo $mostraProducte['pathfoto'] ?>" alt="Imagen del producto">
    <p><?php echo $mostraProducte['nom'] ?></p>
    <p><?php echo $mostraProducte['preu'] ?>€</p>
    <p><?php echo $mostraProducte['descripcio'] ?></p>

    <div class="add-to-cart-container">
        <div class="quantity-selector">
            <span>Quantitat:</span>
            <div class="quantity-controls">
                <button type="button" class="quantity-btn" onclick="decrementQuantity()">-</button>
                <input type="number" 
                    id="productQuantity" 
                    value="1" 
                    min="1" 
                    max="99"
                    class="quantity-input">
                <button type="button" class="quantity-btn" onclick="incrementQuantity()">+</button>
            </div>
        </div>
        <button id="addCartBtn" onclick="addCart(<?php echo $mostraProducte['id']?>)">Afegir al cabàs</button>
    </div>

    <div class="caracteristiques">
        <p><?php echo $mostraProducte['places'] ?> Places</p>
        <p><?php echo $mostraProducte['potencia'] ?> CV</p>
    </div>
</div>
