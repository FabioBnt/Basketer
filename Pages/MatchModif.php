<?php
include_once "../php/Classes/DataBase.php";
include_once "../php/Classes/Matchs.php";
if (isset($_POST['submit'])) {
    $match = new Matchs();
    $date = $_POST['date'];
    $match->modifyMatches($date, 'DateM', $date);
    $opposingTeamName = $_POST['opposingTeamName'];
    $match->modifyMatches($date, 'NomEquipeAdv', $opposingTeamName);
    $location = $_POST['location'];
    $match->modifyMatches($date, 'Lieu', $location);
    $score = $_POST['score'];
    $match->modifyMatches($date, 'ScoreEquipe', $score);
    $opposingScore = $_POST['opposingScore'];
    $match->modifyMatches($date, 'ScoreEquipeAdv', $opposingScore);
    header('Location: ../Pages/MatchModif.php');
    exit;
}
if (!isset($_GET['IDMatch'])) {
    echo "<script>alert('Aucun match sélectionné')</script>";
    header('Location: ../Pages/MatchList.php');
    exit;
}
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
<div class="containerM">
    <form id="modif" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">
        <h3>Modifier match du <?php echo $_GET['DateM']; ?></h3>
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