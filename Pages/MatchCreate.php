<?php
include_once "../php/Classes/DataBase.php";
include_once "../php/Classes/Matchs.php";
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
<div class="containerM">
    <form id="modif" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">
        <h3>Creer match</h3>
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
            <button name="submit" type="submit" id="contact-submit" data-submit="...Sending">Creer</button>
        </fieldset>
    </form>
</body>
</html>
