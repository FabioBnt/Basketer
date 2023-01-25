<?php
include_once "../php/Classes/DataBase.php";
include_once "../php/Classes/Matchs.php";
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
    $date = $_POST['date'];
    $place = $_POST['place'];
    $awayTeam = $_POST['awayTeam'];
    $homeScore = $_POST['homeScore'];
    $awayScore = $_POST['awayScore'];
    try {
        $match->insertMatch($date, $awayTeam, $place, $homeScore, $awayScore);
        header('Location:./MatchList.php');
        exit;
    } catch (Exception $e) {
        echo $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <title>Créer un match</title>
</head>

<body>
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
    <div class="containerM">
        <form id="modif" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">
            <h3>Créer un match</h3>
            <fieldset>
                <label>
                    Date &emsp;
                    <input placeholder="Date" type="date" name="date" required autofocus>
                </label>
            </fieldset>
            <fieldset>
                <label>
                    Lieu &emsp;
                    <input placeholder="Lieu" type="text" name="place" required>
                </label>
            </fieldset>
            <fieldset>
                <label>
                    Equipe Visiteur &emsp;
                    <input placeholder="Equipe Visiteur" type="text" name="awayTeam" required>
                </label>
            </fieldset>
            <fieldset>
                <label>
                    Score Domicile &emsp;
                    <input placeholder="Score Domicile" type="number" min="0" name="homeScore" required>
                </label>
            </fieldset>
            <fieldset>
                <label>
                    Score Visiteur &emsp;
                    <input placeholder="Score Visiteur" type="number" min="0" name="awayScore" required>
                </label>
            </fieldset>
            <fieldset>
                <button name="submit" type="submit" id="contact-submit" data-submit="...Sending">Créer</button>
            </fieldset>
        </form>
</body>

</html>