<footer class="cart-footer-summary">
    <div class="cart-summary">
        <span>Productes: <span id="totalCantidad"><?php echo isset($_SESSION['totalCantidad']) ? $_SESSION['totalCantidad'] : '0'; ?></span></span>
        <span>Total: <span id="totalPrecio"><?php echo isset($_SESSION['totalPrecio']) ? $_SESSION['totalPrecio'] : '0'; ?> €</span></span>
    </div>
</footer>