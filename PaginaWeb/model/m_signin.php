<?php

class UserModel {
    private $db;

    public function __construct() {
        $this->db = new PDO('pgsql:host=127.0.0.1;dbname=tdiw-e6', 'tdiw-e6', 'granollers');
    }

    public function registerUser($mail, $telefon, $direccio, $nom, $password, $fotoperfil) {
        try {
            $query = "INSERT INTO usuari (mail, telefon, direccio, nom, password, fotoperfil) 
                      VALUES (:mail, :telefon, :direccio, :nom, :password, :fotoperfil)";
            $stmt = $this->db->prepare($query);

            $stmt->bindParam(':mail', $mail);
            $stmt->bindParam(':telefon', $telefon);
            $stmt->bindParam(':direccio', $direccio);
            $stmt->bindParam(':nom', $nom);
            $stmt->bindParam(':password', $password);
            $stmt->bindParam(':fotoperfil', $fotoperfil); 

            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }
}

function emailExists($email, $conn) {
    $query = "SELECT COUNT(*) FROM usuari WHERE mail = $1";
    
    $result = pg_query_params($conn, $query, [$email]);
    
    if ($result) {
        $row = pg_fetch_row($result);
        
        return $row[0] > 0;
    } else {
        return false;
    }
}
?>
