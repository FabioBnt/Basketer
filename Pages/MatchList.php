<?php
include_once "../php/Classes/DataBase.php";
include_once "../php/Classes/Matchs.php";
include_once "../php/Classes/Participants.php";
include_once '../php/Classes/Images.php';
session_start();
if(!isset($_SESSION['logged'])){
    header('Location:../index.php');
    exit;
}
if(isset($_GET['logout']) && $_GET['logout']){
    session_unset();
    session_destroy();
    header('Location:../index.php');
    exit;
}
$match = new Matchs();
$matchs = $match->selectMatches();
//$_GET['alertMessage'] shows the message of the alert
if (isset($_GET['alertMessage'])) {
    echo "<script>alert('" . $_GET['alertMessage'] . "')</script>";
}
//delete match
if (isset($_GET['del'])) {
    //delete the participation of the players in the match
    $manager = new Participants($_GET['del']);
    $manager->deleteAllParticipant();
    $match->deleteMatch($_GET['del']);
    header('Location:./MatchList.php?alertMessage="Match supprimé"');
    exit;
}
?>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../css/style.css">
    <title>Liste Matchs</title>
</head>

<body class="list">
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
    <h1>Liste des matchs de l'équipe</h1>
    <button class="custom-btn btn-3" onclick="location.href='MatchCreate.php'"><span>Créer Match</span></button>
    <table>
        <tr class="heading">
            <th>Equipe Adverse</th>
            <th>Date</th>
            <th>Lieu</th>
            <th>Score Equipe</th>
            <th>Score Equipe Adverse</th>
            <th>Actions</th>
        </tr>
        <?php
        foreach ($matchs as $match) {
            echo '<tr>';
            echo '<td class="opposingTeam-name">';
            echo $match['NomEquipeAdv'];
            echo '</td>';
            echo '<td>' . $match['DateM'] . '</td>';
            echo '<td>' . $match['Lieu'] . '</td>';
            echo '<td>' . $match['ScoreEquipe'] . '</td>';
            echo '<td>' . $match['ScoreEquipeAdv'] . '</td>';
            echo '<td><a href="MatchModif.php?IDMatch=' . $match['IDMatch'] . '&NomEquipeAdv=' . $match['NomEquipeAdv'] .
                '&DateM=' . $match['DateM'] . '&LieuMatch=' . $match['Lieu'] . '&ScoreEquipe=' . $match['ScoreEquipe'] . '&ScoreEquipeAdv=' . $match['ScoreEquipeAdv'] .
                '">Modifier</a>
                  / <a href="MatchList.php?del=' . $match['IDMatch'] . '">Supprimer</a>
                  / <a href="WriteMatch.php?match=' . $match['IDMatch'] . '">Ecrire</a>
                </td>';
            echo '</tr>';
        }
        ?>

    </table>