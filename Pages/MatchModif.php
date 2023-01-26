<?php
include_once "../php/Classes/DataBase.php";
include_once "../php/Classes/Matchs.php";
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
if (isset($_POST['submit'])) {
    $match = new Matchs();
    $iDMatch = $_POST['IDMatch'];
    $date = $_POST['date'];
    $match->modifyMatches($iDMatch, 'DateM', $date);
    $opposingTeamName = $_POST['opposingTeamName'];
    $match->modifyMatches($iDMatch, 'NomEquipeAdv', $opposingTeamName);
    $location = $_POST['location'];
    $match->modifyMatches($iDMatch, 'Lieu', $location);
    $score = $_POST['score'];
    $match->modifyMatches($iDMatch, 'ScoreEquipe', $score);
    $opposingScore = $_POST['opposingScore'];
    $match->modifyMatches($iDMatch, 'ScoreEquipeAdv', $opposingScore);
    echo "<script>alert('Match modifié avec succès')</script>";
    //wait 3 seconds before redirecting
    header('Refresh: 3; URL=../Pages/MatchList.php');
    exit;
}
if (!isset($_GET['IDMatch'])) {
    echo "<script>alert('Aucun match sélectionné')</script>";
    header('Refresh: 3; URL=../Pages/MatchList.php');
    exit;
}
$iDMatch = $_GET['IDMatch'];
$date = $_GET['DateM'];
$opposingTeamName = $_GET['NomEquipeAdv'];
$location = $_GET['LieuMatch'];
$score = $_GET['ScoreEquipe'];
$opposingScore = $_GET['ScoreEquipeAdv'];
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <title>Modifier un match</title>
</head>

<body>
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
    <div class="containerM">
        <form id="modif" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">
            <h3>Modifier match du <?php echo $_GET['DateM']; ?></h3>
            <input type="hidden" name="IDMatch" value="<?php echo $iDMatch; ?>">
            <label for="date">Date du match</label>
            <input type="date" name="date" id="date" value="<?php echo $date; ?>">
            <label for="opposingTeamName">Nom de l'équipe adverse</label>
            <input type="text" name="opposingTeamName" id="opposingTeamName" value="<?php echo $opposingTeamName; ?>">
            <label for="location">Lieu du match</label>
            <input type="text" name="location" id="location" value="<?php echo $location; ?>">
            <label for="score">Score de l'équipe</label>
            <input type="number" min="0" name="score" id="score" value="<?php echo $score; ?>"><br>
            <label for="opposingScore">Score de l'équipe adverse</label>
            <input type="number" min="0" name="opposingScore" id="opposingScore" value="<?php echo $opposingScore; ?>">
            <input type="submit" name="submit" value="Modifier">
        </form>
    </div>
</body>

</html>