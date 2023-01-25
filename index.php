<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include_once './php/Classes/DataBase.php';

session_start();

$incorrect = false;
if (isset($_POST['submit'])) {
    $username = $_POST['user'];
    $password = $_POST['pwd'];
    if ($username !== 'admin' || $password !== 'iutinfo') {
        $incorrect = true;
    } else {
        $_SESSION['logged'] = true;
        header('Location:./Pages/Home.php');
        exit;
        }
    }
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/style.css">
    <title>Basketer</title>
</head>

<body id="index">
<div class="login-page">
    <div class="welcome">
        <h2>Rebonjour !</h2>
    </div>
    <div class="form">
        <form class="login-form" action="./index.php" method="POST">
            <input type="text" placeholder="Nom d'utilisateur" required name="user"/>
            <input type="password" placeholder="Mot de passe" required name="pwd"/>
            <button type="submit" name="submit">Se connecter</button>
            <button id="reset" type="reset">Effacer</button>
            <?php
                if ($incorrect) {
                    echo '<h3 class="incorrectIDs">Nom d\'utilisateur ou mot de passe incorrect !</h3>';
                }
            ?>
        </form>
    </div>
</div>
</body>

</html>