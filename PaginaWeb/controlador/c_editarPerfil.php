<?php 
require __DIR__.'/../model/m_conectaDB.php';
require __DIR__.'/../model/m_editarPerfil.php';
require __DIR__.'/../model/m_perfil.php';

$conn = connectaDB();
$infoUser = getInfoUser();
$mod = false;
$message = '';

foreach($infoUser as $fila) {
    $nom = $fila['nom'];
    $email = $fila['mail'];
    $telefon = $fila['telefon'];
    $direccio = $fila['direccio'];
    $contrasenya = $fila['password'];
    $fotoperfil = $fila['fotoperfil'];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if(isset($_POST['name']) && !empty($_POST['name'])) {
        $nom = $_POST['name'];
        $mod = modificaNom($nom, $conn);
    }

    if(isset($_POST['email']) && !empty($_POST['email'])) {
        $email = $_POST['email'];
        $mod = modificaMail($email, $conn);
    }

    if(isset($_POST['telefon']) && !empty($_POST['telefon'])) {
        $telefon = $_POST['telefon'];
        $mod = modificaTelefon($telefon, $conn);
    }

    if(isset($_POST['direccio']) && !empty($_POST['direccio'])) {
        $direccio = $_POST['direccio'];
        $mod = modificaDireccio($direccio, $conn);
    }

    if(isset($_POST['password']) && !empty($_POST['password'])) {
        if (!preg_match('/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/', $_POST['password'])) {
            $message = "La contrasenya ha de tenir almenys 8 caràcters, incloent-hi lletres i nombres.";
        } else {
            $contrasenya = password_hash($_POST['password'], PASSWORD_DEFAULT);
            $mod = modificaContrasenya($contrasenya, $conn);
        }
    }

    if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] === UPLOAD_ERR_OK) {
        $allowedTypes = ['image/jpeg', 'image/png'];
        $maxSize = 5 * 1024 * 1024; // 5MB
    
        if (!in_array($_FILES['profile_image']['type'], $allowedTypes)) {
            $message = "Solo se permiten archivos JPG y PNG.";
        } elseif ($_FILES['profile_image']['size'] > $maxSize) {
            $message = "L'arxiu supera el límit de 5MB.";
        } else {
            if (!empty($fotoperfil)) {
                $currentPhotoPath = __DIR__ . $fotoperfil;
                if (file_exists($currentPhotoPath)) {
                    unlink($currentPhotoPath);
                }
            }
            
            $uploadDir = __DIR__ . '/../imgUsers/';
            $fileExtension = pathinfo($_FILES['profile_image']['name'], PATHINFO_EXTENSION);
            $uniqueFileName = uniqid('user_', true) . '.' . $fileExtension;
            $uploadPath = $uploadDir . $uniqueFileName;
            
            if (move_uploaded_file($_FILES['profile_image']['tmp_name'], $uploadPath)) {
                $relativePath = '/../imgUsers/' . $uniqueFileName;
                $mod = modificaFoto($relativePath, $conn); 
                if ($mod) {
                    $_SESSION['profile_picture'] = $relativePath; 
                } else {
                    $message = "Error en actualitzar la foto de perfil.";
                }
            } else {
                $message = "Error al pujar l'arxiu.";
            }
        }
    }
    

    if($mod) {
        header('Location: index.php?action=ver-perfil');
        exit;
    }
}

require __DIR__.'/../vista/v_editarPerfil.php';
?>