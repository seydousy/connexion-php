<?php
session_start();
$isLoggedIn = isset($_SESSION['user']); // Verification si la clé 'user' est présente dans la session

if (!$isLoggedIn) {
    // Rediriger vers la page de connexion si l'utilisateur n'est pas connecté
    header("Location: login.php");
    exit();
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page de session</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <?php

                // Recuperation du nom d'utilisateur depuis la session
                $firstName = $_SESSION['user']['firstName'];
                $lastName =  $_SESSION['user']['lastName'];
                $username = $firstName . ' ' . $lastName;

                echo "<h2>Bienvenue, $username !</h2>";
                echo "<p class=\"mt-3\"><a href=\"../public/index.php?action=logout\">Se déconnecter</a></p>";
                ?>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
