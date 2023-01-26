<?php
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
include_once "../php/Classes/DataBase.php";
include_once "../php/Classes/Stats.php";
include_once "../php/Classes/Players.php";
//Le nombre total et le pourcentage de matchs gagnés, perdus, ou nuls.
// Un tableau avec pour chaque joueur : son statut actuel, son poste préféré,
// le nombre total de sélections en tant que titulaire, le nombre total de sélections
// en tant que remplaçant, la moyenne des évaluations de l'entraîneur,
// et le pourcentage de matchs gagnés lorsqu'il a participé.
// Si possible, ajouter également le nombre de sélections consécutives (facultatif).

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
<html>

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../css/style.css">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Statistiques d'équipe</title>
</head>

<body class="body-stats">
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
    <h1>Statistiques d'équipe</h1>
    <div class="score">
        <p>Nombre total de matchs : <span id="total-matches"><?php echo $total; ?> </span></p>
        <p>Pourcentage de matchs gagnés : <span id="win-percentage"><?php echo $win; ?></span>%</p>
        <p>Pourcentage de matchs perdus : <span id="loss-percentage"><?php echo $loss; ?></span>%</p>
        <p>Pourcentage de matchs nuls : <span id="draw-percentage"><?php echo $tie; ?></span>%</p>
    </div>
    <h2>Liste des joueurs</h2>
    <table class="list">
        <tr class="heading">
            <th>Nom</th>
            <th>Statut</th>
            <th>Poste préféré</th>
            <th>Sélections (Titulaire)</th>
            <th>Sélections (Remplaçant)</th>
            <th>Moyenne d'évaluation</th>
            <th>Pourcentage de matchs gagnés</th>
            <th>Sélections consécutives</th>
        </tr>
        <?php
        $players = new Players();
        $players = $players->selectPlayers();
        foreach ($players as $player) {
            $playerStats = $stats->playerStats($player['NumLicence']);
            // le nombre de sélections consécutives
            $consecutive = $stats->consecutiveSelections($player['NumLicence']);
        ?>
            <tr>
                <td><?php echo $player['Nom'] . " " . $player['Prenom']; ?></td>
                <td><?php echo $player['Statut']; ?></td>
                <td><?php echo $player['PostePref']; ?></td>
                <td><?php echo $playerStats[0]; ?></td>
                <td><?php echo $playerStats[1]; ?></td>
                <td><?php echo $playerStats[2]; ?></td>
                <td><?php echo $playerStats[3]; ?>%</td>
                <td><?php echo $consecutive; ?></td>
            </tr>
        <?php
        }

        ?>
    </table>
</body>

</html>