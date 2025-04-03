<?php
include_once __DIR__ . '/../model/m_signin.php';
include_once __DIR__ . '/../model/m_conectaDB.php';

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $mail = $_POST['mail'];
    $telefon = $_POST['telefon'];
    $direccio = $_POST['direccio'];
    $nom = $_POST['nom'];
    $password = $_POST['password'];
    $profileImage = $_FILES['profile_image'];

    if (!filter_var($mail, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "El correu electrònic no és vàlid.";
    }
    $conn = connectaDB();
    if (emailExists($mail, $conn)) {
        $errors[] = "Aquest correu electrònic ja està en ús. Prova amb un altre.";
    }

    if (!preg_match('/^\d{9,}$/', $telefon)) {
        $errors[] = "El telèfon ha de contenir almenys 9 dígits.";
    }

    if (empty(trim($direccio))) {
        $errors[] = "La direcció no pot estar buida.";
    }

    if (strlen(trim($nom)) < 3) {
        $errors[] = "El nom ha de tenir almenys 3 caràcters.";
    }

    if (!preg_match('/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/', $password)) {
        $errors[] = "La contrasenya ha de tenir almenys 8 caràcters, incloent-hi lletres i nombres.";
    }

    if ($profileImage['error'] !== UPLOAD_ERR_NO_FILE) {
        if ($profileImage['error'] !== UPLOAD_ERR_OK) {
            $errors[] = "Error en pujar la imatge: " . $profileImage['error'];
        } else {
            $allowedExtensions = ['jpg', 'jpeg', 'png'];
            $fileExtension = strtolower(pathinfo($profileImage['name'], PATHINFO_EXTENSION));
            if (!in_array($fileExtension, $allowedExtensions)) {
                $errors[] = "La imatge ha de tenir format .jpg, .jpeg o .png.";
            }
        }
    }

    if (!empty($errors)) {
        include_once __DIR__ . '/../vista/v_signin.php';
        exit();
    }

    $uniqueFileName = null;
    if ($profileImage['error'] === UPLOAD_ERR_OK) {
        $uploadDir = __DIR__ . '/../imgUsers/';
        $uniqueFileName = uniqid('user_', true) . '.' . $fileExtension;
        $uploadPath = $uploadDir . $uniqueFileName;
        $uniqueFileName = '/../imgUsers/' . $uniqueFileName;

        if (!move_uploaded_file($profileImage['tmp_name'], $uploadPath)) {
            echo "Hi ha hagut un error en guardar la imatge de perfil a la carpeta.";
            if (!is_writable($uploadDir)) {
                echo "La carpeta no té permisos d'escriptura.";
            } else {
                echo "La carpeta té permisos d'escriptura.";
            }
            exit();
        }
    }

    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

    $userModel = new UserModel();
    $result = $userModel->registerUser($mail, $telefon, $direccio, $nom, $hashedPassword, $uniqueFileName);

    if ($result) {
        header('Location: /index.php?action=login&success=true'); 
    } else {
        $errors[] = "Hubo un error al registrar al usuario.";
        include_once __DIR__ . '/../vista/v_signin.php';
        exit();
    }
} else {
    include_once __DIR__ . '/../vista/v_signin.php';
}
?>