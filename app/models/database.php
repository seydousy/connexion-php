<?php
$host = 'localhost'; // Hôte de la base de données
$dbname = 'connexion_db'; // Nom de la base de données
$username = 'root'; // Nom d'utilisateur de la base de données
$password = ''; // Mot de passe de la base de données

try {
    
    $db_connection = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $db_connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion à la base de données : " . $e->getMessage());
}
?>
