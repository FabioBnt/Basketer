<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
if (!isset($_SESSION['logged'])) {
    header('Location:../index.php');
    exit;
}
if (isset($_GET['logout']) && $_GET['logout']) {
    session_unset();
    session_destroy();
    header('Location:../index.php');
    exit;
}
?>


<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../css/style.css">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil</title>
</head>

<body id="home">
<div class="container">
    <header class="menu">
        <div class="logo">
        </div>
        <nav class="menu" role='navigation'>
            <ol>
                <li class="menu-item"><a href="Home.php">Accueil</a></li>
                <li class="menu-item"><a href="./PlayersList.php">Liste des joueurs</a></li>
                <li class="menu-item"><a href="./MatchList.php">Liste des matchs</a></li>
                <li class="menu-item"><a href="./Statstics.php">Statistiques</a></li>
                <?php
                if ($_SESSION['logged']) {
                    echo '<li class="menu-item"><a href="./Home.php?logout=true">Déconnexion</a></li>';
                }
                ?>
            </ol>
        </nav>
    </header>
</div>
<div class="home-body">
    <h1 class="home-title">Basketer</h1>
    <!-- Speech court présentant le site facilitant la sélection des joueurs pour les matchs de Basketball à venir -->
    <div class="speech">
        <p>Ce site a pour but de faciliter la sélection des joueurs pour les matchs de
            Basketball à venir.</p>
        <p>Il permet de consulter la liste des joueurs et de sélectionner ceux qui participeront au match et vice
            versa.</p>
    </div>
</div>


</body>

</html>