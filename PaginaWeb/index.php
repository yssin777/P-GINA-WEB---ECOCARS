<?php 
    session_start();
    $action = isset($_GET['action']) ? $_GET['action'] : 'llistar-categories';
    
    switch ($action) {
        case 'llistar-categories':
            require __DIR__ . '/resources/resource_llistaCategories.php';
            break;

        case 'llistar-productes':
            require __DIR__ . '/resources/resource_llistaProductes.php';
            break;

        case 'signin':
            require __DIR__ . '/resources/resource_signin.php';
            break;

        case 'mostrar-producte':
            require __DIR__ . '/resources/resource_mostrarProducte.php';
            break;

        case 'login':
            require __DIR__ . '/resources/resource_login.php';
            break;

        case 'logout':
            session_unset();
            session_destroy();
            header("Location: /index.php?action=llistar-categories");
            exit();
            break;

        case 'ver-perfil':
            require __DIR__ . '/resources/resource_verPerfil.php';
            break;

        case 'editar-perfil':
            require __DIR__ . '/resources/resource_editarPerfil.php';
            break;

        case 'ver-carrito':
            require __DIR__ . '/resources/resource_verCarrito.php';
            break;

        case 'afegirCarro':
            require __DIR__ . '/controlador/c_afegirCarrito.php';
            break;

        case 'deleteFromCart':
            require __DIR__ . '/controlador/c_deleteFromCart.php';
            break;

        case 'updateQuantity':
            require __DIR__ . '/controlador/c_updateQuantity.php';
            break;
        case 'emptyCart':
            require __DIR__ . '/controlador/c_emptyCart.php';
            break;
        case 'comanda':
            if (!isset($_SESSION['user_id'])) {
                header('Location: index.php?action=login');
                exit;
            }
            require __DIR__ . '/controlador/c_comanda.php';
            break;
        case 'search':
            require __DIR__ . '/controlador/c_search.php';
            break;
        case 'confirma-comanda':
            require __DIR__ . '/resources/resource_confirmarComanda.php';
            break;
        case 'mis-pedidos':
            require __DIR__ . '/resources/resource_pedidos.php';
            break;

        default:
            echo "Acció no vàlida.";
            break;
    }

?>