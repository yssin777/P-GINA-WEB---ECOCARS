<?php if (empty($_SESSION['carrito'])): ?>
    <div class="cart">
        <div class="empty-cart-message">
            <p>El cabàs està buit</p>
        </div>
    </div>
<?php else: ?>
    <div class="cart">
        <h2>Carro</h2>
        <main>
            <table class="cart-table">
                <tr>
                    <th>Nom</th>
                    <th>Preu</th>
                    <th>Imatge</th>
                    <th>Quantitat</th>
                    <th>Eliminar</th>
                </tr>

                <?php foreach ($_SESSION['carrito'] as $index => $producto): ?>
                    <tr data-index="<?php echo $index; ?>">
                        <td><?php echo htmlspecialchars($producto['name']); ?></td>
                        <td><?php echo htmlspecialchars($producto['price']) . '€'; ?></td>
                        <td><img src="<?php echo htmlspecialchars($producto['image']); ?>" alt="Product Image" class="cart-image"></td>
                        <td>
                            <div class="quantity-controls">
                                <button type="button" class="quantity-btn" onclick="updateQuantity(<?php echo $index; ?>, parseInt(document.querySelector('tr[data-index=\'<?php echo $index; ?>\'] .quantity-input').value) - 1)">-</button>
                                <input type="number" 
                                    value="<?php echo htmlspecialchars($producto['quantity'] ?? 1); ?>" 
                                    min="1" 
                                    max="99"
                                    class="quantity-input"
                                    onchange="updateQuantity(<?php echo $index; ?>, this.value)">
                                <button type="button" class="quantity-btn" onclick="updateQuantity(<?php echo $index; ?>, parseInt(document.querySelector('tr[data-index=\'<?php echo $index; ?>\'] .quantity-input').value) + 1)">+</button>
                            </div>
                        </td>
                        <td>
                            <button class="delete-btn" onclick="deleteFromCart(<?php echo $index; ?>)">Eliminar</button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>

            <div class="cart-footer">
                <p>Total: <span class="cart-total"><?php echo $_SESSION['totalPrecio']; ?> €</span></p>
                <div class="cart-buttons">
                    <button onclick="emptyCart()" class="button">Buidar cabàs</button>
                    <button onclick="processOrder()" class="button">Confirmar comanda</button>
                </div>
            </div>
        </main>
    </div>
<?php endif; ?>

<script>
async function searchProducts() {
    const searchTerm = document.getElementById('searchInput').value;
    if (!searchTerm.trim()) return;
    
    try {
        const response = await fetch(`index.php?action=search&term=${encodeURIComponent(searchTerm)}`);
        if (!response.ok) throw new Error('Network response was not ok');
        
        const data = await response.json();
        console.log('Search results:', data);
        
        let productsContainer = document.querySelector('#blocllista');
        if (!productsContainer) {
            productsContainer = document.createElement('div');
            productsContainer.id = 'blocllista';
            document.body.appendChild(productsContainer);
        }
        
        if (data.length === 0) {
            productsContainer.innerHTML = '<p>No s\'han trobat productes</p>';
            return;
        }
        
        const productsHTML = `
            <div id="productes">
                ${data.map(product => `
                    <div id="producte">
                        <a href="javascript:void(0);" onclick="fetchMostraProducte(${product.id})">
                            <img src="${product.pathfoto}" alt="${product.nom}">
                            <p>${product.nom}</p>
                            <p>${product.preu}€</p>
                        </a>
                    </div>
                `).join('')}
            </div>
        `;
        
        productsContainer.innerHTML = productsHTML;
    } catch (error) {
        console.error('Search error:', error);
    }
}
</script>