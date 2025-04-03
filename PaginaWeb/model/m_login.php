<?php

class UserModel {
    private $db;

    public function __construct() {
        $this->db = new PDO('pgsql:host=127.0.0.1;dbname=tdiw-e6', 'tdiw-e6', 'granollers');
    }

    public function getUserByEmail($mail) {
        try {
            $query = "SELECT * FROM usuari WHERE mail = :mail";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':mail', $mail);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC); 
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    public function registerUser($mail, $telefon, $direccio, $nom, $password) {
        try {
            $query = "INSERT INTO usuari (mail, telefon, direccio, nom, password) VALUES (:mail, :telefon, :direccio, :nom, :password)";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':mail', $mail);
            $stmt->bindParam(':telefon', $telefon);
            $stmt->bindParam(':direccio', $direccio);
            $stmt->bindParam(':nom', $nom);
            $stmt->bindParam(':password', $password);
            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }
}
?>
