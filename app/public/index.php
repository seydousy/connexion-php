<?php

session_start();
require_once '../controllers/UserController.php';
require_once '../models/UserModel.php';

$host = 'localhost'; 
$dbname = 'connexion_db'; 
$username = 'root'; 
$password = ''; 

try {
    // Création d'une instance de la classe PDO pour la connexion à la base de données
    $db_connection = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);

    // Configurer l'attribut PDO pour generer des exceptions en cas d'erreur
    $db_connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Instancier le contreleur et executer les actions
    $userController = new UserController();
    // Les routes
    if (isset($_GET['action'])) {
        $action = $_GET['action'];
        switch ($action) {
            case 'login':
                $userController->login();
                break;
            case 'logout':
                $userController->logout();
                break;
                case 'register': 
                    $userController->register();
                    break;
            default:
            $userController->showLoginPage();
                break;
        }
    } else {
        $userController->showLoginPage();
    }
} catch (PDOException $e) {
    die("Erreur de connexion à la base de données : " . $e->getMessage());
}
?>

