<?php
require_once 'database.php'; 

class UserModel {
    private $db_connection;

    public function __construct() {
        $this->db_connection = new PDO("mysql:host=localhost;dbname=connexion_db;charset=utf8", 'root', '');
        $this->db_connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function createUser($login, $password, $firstName, $lastName) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $query = "INSERT INTO users (login, password, first_name, last_name) VALUES (?, ?, ?, ?)";
        $stmt = $this->db_connection->prepare($query);
        return $stmt->execute([$login, $hashedPassword, $firstName, $lastName]);
    }

    public function getUserByLogin($login) {
        $query = "SELECT * FROM users WHERE login = ?";
        $stmt = $this->db_connection->prepare($query);
        $stmt->execute([$login]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>
