<div class="container">
    <div class="orders-container">
        <h2>Les meves comandes</h2>

        <?php if (empty($orders)): ?>
            <p>Encara no has fet cap comanda</p>
        <?php else: ?>
            <?php foreach ($orders as $order): ?>
                <div class="order-card">
                    <div class= "order-header">
                        <p>Data: <?php echo date('d/m/Y H:i', strtotime($order['data_creacio'])); ?></p>
                        <p>Total: <?php echo $order['import_total']; ?>€</p>
                    </div>
                    
                    <div class="order-products">
                        <?php if (!empty($order['productos'])): ?>
                            <?php foreach ($order['productos'] as $product): ?>
                                <div class="order-product">
                                    <img src="<?php echo $product['pathfoto']; ?>" alt="<?php echo htmlspecialchars($product['nom']); ?>" class="order-product-image">
                                    <span><?php echo htmlspecialchars($product['nom']); ?></span>
                                    <span>x<?php echo (int)$product['quantity']; ?></span>
                                    <span><?php echo (float)$product['price']; ?>€</span>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <p>No hi ha productes en aquesta comanda.</p>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>

