<?php
require_once __DIR__ . '/../models/UserModel.php';

class UserController {
    private $userModel;

    public function __construct() {
        $db_connection = new PDO("mysql:host=localhost;dbname=connexion_db;charset=utf8", 'root', '');
        $db_connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->userModel = new UserModel($db_connection);
    }

   /* public function handleRequest($action) {
        if (isset($_GET['action'])) {
            $action = $_GET['action'];
            switch ($action) {
                case 'login':
                    $this->login();
                    break;
                case 'logout':
                    $this->logout();
                    break;
                    case 'register': // Ajout de la gestion de l'inscription
                        $this->register();
                        break;
                // Autres actions...
                default:
                    $this->showLoginPage();
                    break;
            }
        } else {
            $this->showLoginPage();
        }
    }*/

    public function showLoginPage() {
        require '../views/login.php';
    }

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $login = $_POST['login'];
            $password = $_POST['password'];

            // Vérifier si les champs ne sont pas vides
            if (empty($login) || empty($password)) {
                $_SESSION['error'] = "Tous les champs doivent être remplis.";
                header("Location: login.php?error=1");
                exit();
            } else {
                // Vérifier les informations d'identification avec le modèle
                $user = $this->userModel->getUserByLogin($login);

                if ($user && password_verify($password, $user['password'])) {
                    // Authentification réussie, créer une session d'utilisateur
                    $_SESSION['user'] = [
                        'login' => $user['login'],
                        'firstName' => $user['first_name'],
                        'lastName' => $user['last_name']
                    ];
                    header("Location: ../views/session.php");
                    exit();
                } else {
                    $_SESSION['error'] = "Identifiants invalides.";
                    header("Location: login.php?error=1");
                    exit();
                }
            }
        } else {
            require_once '../views/login.php';
        }
    }

    public function logout() {
        session_start();
        $_SESSION = array();
        session_destroy();
        header("Location: login.php");
        exit();
    }
    public function register() {
        // Gestion de l'inscription
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $login = $_POST['login'];
            $password = $_POST['password'];
            $confirmPassword = $_POST['confirm_password'];
            $nom = $_POST['lastName']; 
            $prenom = $_POST['firstName']; 
            // veerification d'erreur
            $existingUser = $this->userModel->getUserByLogin($login);
            if ($existingUser) {
                $_SESSION['error'] = "mauvais login.";
                header("Location: inscription.php?error=3");
                exit();
            }
            if ($password !== $confirmPassword) {
                $_SESSION['error'] = "non correspondance mot de passe.";
                header("Location: inscription.php?error=2");
                exit();
            }
            // validation et creation du user
            $success = $this->userModel->createUser($login, $password, $prenom, $nom);
            if ($success) {
                $_SESSION['user'] = [
                    'login' => $login,
                    'firstName' => $prenom,
                    'lastName' => $nom
                ];               
                header("Location: session.php");
                exit();
            } else {
                // Gestion erreur d'inscription
                header("Location: inscription.php?error=registration_failed");
                exit();
            }
        } else {
            // Afficher le formulaire d'inscription
            require '../views/inscription.php';
        }
    }

}
?>
