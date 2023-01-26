<?php

include_once '../php/Classes/Images.php';
include_once '../php/Classes/Stats.php';
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
$stats = new Stats();
//get total matchs
$numbers = $stats->totalWinTieLossNull();
$total = $numbers[0];
$numbers = $stats->percentagesWinTieLossNull();
$win = $numbers[0];
$tie = $numbers[1];
$loss = $numbers[2];
$none = $numbers[3];
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
            <?php Images::logo(); ?>
        </div>
        <nav class="menu" role='navigation'>
            <ol>
                <li class="menu-item"><a href="Home.php">Accueil</a></li>
                <li class="menu-item"><a href="./PlayersList.php">Liste des joueurs</a></li>
                <li class="menu-item"><a href="./MatchList.php">Liste des matchs</a></li>
                <li class="menu-item"><a href="Statistics.php">Statistiques</a></li>
                <?php
                if ($_SESSION['logged']) {
                    echo '<li class="menu-item" id="disconnect"><a href="./Home.php?logout=true">Déconnexion</a></li>';
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
        <p>Bienvenue sur notre site !</p>
        <p>Il a pour but de faciliter la sélection des joueurs pour les matchs de
            Basketball à venir,</p>
        <p>Ainsi que de consulter la liste des joueurs et de sélectionner ceux qui participeront au match et vice
            versa.</p>
    </div>
    <div class="stats-home">
        <?php

        ?>
    </div>
</div>


</body>

</html>