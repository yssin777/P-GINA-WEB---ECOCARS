async function fetchllistaProductes(categoria)
{
    try {
        var resposta = await fetch("index.php?action=llistar-productes&categoria=" + categoria);
        if (!resposta.ok) {
            throw new Error("Error en la solicitud: " + resposta.status);
        }
        var respostatext = await resposta.text();
        document.getElementById("blocllista").innerHTML = respostatext;
    } catch (error) {
        console.error("Error al obtener los datos:", error);
    }
}


async function fetchMostraProducte(productId) {
    try {
        const resposta = await fetch("index.php?action=mostrar-producte&producte=" + productId);
        if (!resposta.ok) {
            throw new Error("Error en la solicitud: " + resposta.status);
        }
        const respostatext = await resposta.text();

        const blocProducte = document.getElementById("blocProducte");
        const blocllista = document.getElementById("blocllista");

        if (blocProducte) {
            blocProducte.innerHTML = respostatext;
        } else if (blocllista) {
            blocllista.innerHTML = respostatext;
        } else {
            console.warn("No se encontró ningún contenedor para mostrar el contenido.");
        }
    } catch (error) {
        console.error("Error al obtener los datos:", error);
    }
}

$(document).ready(function() {
    $(".usuario").hover(
        function() {
            $(this).find(".opciones-usuario").stop(true, true).slideDown(200);
        },
        function() {
            $(this).find(".opciones-usuario").stop(true, true).slideUp(200);
        }
    );
});

document.addEventListener("DOMContentLoaded", () => {
    const form = document.querySelector("form");

    form.addEventListener("submit", (event) => {
        if (!validateForm()) {
            event.preventDefault();
        }
    });

    function validateForm() {
        let isValid = true;

        const email = document.getElementById("mail");
        const telefon = document.getElementById("telefon");
        const direccio = document.getElementById("direccio");
        const nom = document.getElementById("nom");
        const password = document.getElementById("password");

        clearErrors();

        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(email.value.trim())) {
            showError(email, "L'email no és vàlid.");
            isValid = false;
        }

        const telefonRegex = /^\d{9,}$/;
        if (!telefonRegex.test(telefon.value.trim())) {
            showError(telefon, "El telèfon ha de tenir un mínim de 9 dígits.");
            isValid = false;
        }

        if (direccio.value.trim() === "") {
            showError(direccio, "La direcció no pot estar buida.");
            isValid = false;
        }

        if (nom.value.trim().length < 3) {
            showError(nom, "El nom ha de tenir almenys 3 caràcters.");
            isValid = false;
        }

        const passwordRegex = /^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/;
        if (!passwordRegex.test(password.value)) {
            showError(password, "La contrasenya ha de tenir almenys 8 caràcters, incloent-hi lletres i nombres.");
            isValid = false;
        }

        return isValid;
    }

    function showError(input, message) {
        const errorElement = document.createElement("div");
        errorElement.className = "error-message";
        errorElement.textContent = message;
        input.classList.add("error");
        input.parentElement.appendChild(errorElement);
    }

    function clearErrors() {
        document.querySelectorAll(".error-message").forEach((el) => el.remove());
        document.querySelectorAll(".error").forEach((input) => input.classList.remove("error"));
    }
});


async function updateQuantity(index, quantity) {
    quantity = Math.max(1, Math.min(99, parseInt(quantity)));
    
    try {
        const response = await fetch('index.php?action=updateQuantity', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ index: index, quantity: quantity })
        });

        if (!response.ok) throw new Error('Network response was not ok');
        const data = await response.json();
        
        updateCartTotals(data.totalPrecio, data.totalCantidad);

        const quantityInput = document.querySelector(`tr[data-index="${index}"] .quantity-input`);
        if (quantityInput) quantityInput.value = quantity;
    } catch (error) {
        console.error('Error:', error);
    }
}

function incrementQuantity() {
    const input = document.getElementById('productQuantity');
    const currentValue = parseInt(input.value) || 1;
    if (currentValue < 99) input.value = currentValue + 1;
}

function decrementQuantity() {
    const input = document.getElementById('productQuantity');
    const currentValue = parseInt(input.value) || 1;
    if (currentValue > 1) input.value = currentValue - 1;
}

async function addCart(idProd) {
    const button = document.getElementById('addCartBtn');
    const originalText = button.textContent;
    const quantity = parseInt(document.getElementById('productQuantity').value) || 1;
    
    try {
        button.textContent = 'Afegint...';
        button.style.backgroundColor = '#cccccc';
        button.disabled = true;

        const response = await fetch('index.php?action=afegirCarro', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ 
                idProducte: idProd,
                quantity: quantity 
            })
        });

        if (response.status === 401) {
            window.location.href = 'index.php?action=login';
            return;
        }

        const data = await response.json();
        updateCartTotals(data.totalPrecio, data.totalCantidad);

        button.textContent = 'Afegit!';
        button.style.backgroundColor = '#4CAF50';

        setTimeout(() => {
            button.textContent = originalText;
            button.style.backgroundColor = '#2E8B57';
            button.disabled = false;
        }, 2000);

    } catch (error) {
        console.error('Error:', error);
        button.textContent = 'Error';
        button.style.backgroundColor = '#ff0000';
    }
}

async function processOrder() {
    try {
        const response = await fetch('index.php?action=comanda', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            }
        });

        if (!response.ok) throw new Error('Network response was not ok');
        
        window.location.href = 'index.php?action=confirma-comanda';
    } catch (error) {
        console.error('Error:', error);
        alert('Error en processar la comanda');
    }
}
function updateCartTotals(precio, cantidad) {
    const totalElement = document.getElementById('totalPrecio');
    const cantidadElement = document.getElementById('totalCantidad');
    if (totalElement) totalElement.textContent = `${precio} €`;
    if (cantidadElement) cantidadElement.textContent = cantidad;

    const cartTotalElement = document.querySelector('.cart-total');
    if (cartTotalElement) cartTotalElement.textContent = `${precio} €`;
}

async function deleteFromCart(index) {
    try {
        const response = await fetch('index.php?action=deleteFromCart', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ index: index })
        });

        if (!response.ok) throw new Error('Network response was not ok');
        const data = await response.json();
        
        const row = document.querySelector(`tr[data-index="${index}"]`);
        if (row) row.remove();
        
        updateCartTotals(data.totalPrecio, data.totalCantidad);
        
        if (data.totalCantidad === 0) {
            const cartContainer = document.querySelector('.cart');
            if (cartContainer) {
                cartContainer.innerHTML = '<p>El cabàs està buit</p>';
            }
        }
    } catch (error) {
        console.error('Error:', error);
    }
}

async function emptyCart() {
    try {
        const response = await fetch('index.php?action=emptyCart', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            }
        });

        if (!response.ok) throw new Error('Network response was not ok');
        const data = await response.json();
        
        const cartContainer = document.querySelector('.cart');
        if (cartContainer) {
            cartContainer.innerHTML = '<p>El cabàs està buit</p>';
        }
        
        updateCartTotals(0, 0);
    } catch (error) {
        console.error('Error:', error);
    }
}


function modificaFoto($nouPath, $connexio) {
    $idUsuari = $_SESSION['user_id'];
    
    $sql = "UPDATE usuari SET fotoperfil = '$nouPath' WHERE id = $idUsuari";
    
    $consulta = pg_query($connexio, $sql);
    
    return $consulta ? TRUE : FALSE;
}

async function searchProducts() {
    const searchTerm = document.getElementById('searchInput').value;
    if (!searchTerm.trim()) return;
    
    try {
        const response = await fetch(`index.php?action=search&term=${encodeURIComponent(searchTerm)}`);
        if (!response.ok) throw new Error('Network response was not ok');
        
        const data = await response.json();
        
        let productsContainer = document.querySelector('#blocllista');
        if (!productsContainer) {
            productsContainer = document.createElement('div');
            productsContainer.id = 'blocllista';
            document.querySelector('.container').appendChild(productsContainer);
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