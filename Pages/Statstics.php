<?php
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
    <title>Statistiques d'équipe</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }
        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .score {
            text-align: center;
        }
        .percentage {
            text-align: right;
        }
    </style>
</head>
<body>
<h1>Statistiques d'équipe</h1>
<div class="score">
    <p>Nombre total de matchs : <span id="total-matches"><?php echo $total;?> </span></p>
    <p>Pourcentage de matchs gagnés : <span id="win-percentage"><?php echo $win;?></span>%</p>
    <p>Pourcentage de matchs perdus : <span id="loss-percentage"><?php echo $loss;?></span>%</p>
    <p>Pourcentage de matchs nuls : <span id="draw-percentage"><?php echo $tie;?></span>%</p>
</div>
<h2>Joueurs</h2>
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
        <tr >
            <td><?php echo $player['Nom'] . " " . $player['Prenom'];?></td>
            <td><?php echo $player['Statut'];?></td>
            <td><?php echo $player['PostePref'];?></td>
            <td><?php echo $playerStats[0];?></td>
            <td><?php echo $playerStats[1];?></td>
            <td><?php echo $playerStats[2];?></td>
            <td><?php echo $playerStats[3];?>%</td>
            <td><?php echo $consecutive;?></td>
        </tr>
        <?php
    }

    ?>
</table>
</body>
</html>

