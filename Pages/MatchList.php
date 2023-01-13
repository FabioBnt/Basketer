<?php
include_once "../php/Classes/DataBase.php";
include_once "../php/Classes/Matchs.php";
$match = new Matchs();
$matchs = $match->selectMatches();
//delete match
if(isset($_GET['del'])){
    $match->deleteMatch($_GET['del']);
    header('Location:./MatchList.php');
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
<h1>Liste des matchs de l'équipe</h1>
<table>
    <tr class="heading">
        <th>Equipe adverse</th>
        <th>Date</th>
        <th>Heure</th>
        <th>Lieu</th>
        <th>Actions</th>
    </tr>
    <?php
    foreach($matchs as $match){
        echo '<tr>';
            echo '<td class="opposingTeam-name">';
                echo $match['NomEquipeAdv'];
            echo '</td>';
            echo '<td>'.$match['DateM'].'</td>';
            echo '<td>'.$match['Lieu'].'</td>';
            echo '<td>'.$match['ScoreEquipe'].'</td>';
            echo '<td>'.$match['ScoreEquipeAdv'].'</td>';
            echo '<td><a href="MatchModif.php?number='.$match['IDMatch'].'&NomEquipeAdv='.$match['NomEquipeAdv'].
                '&DateM='.$match['DateM'].'&LieuMatch='.$match['LieuMatch'].'&ScoreEquipe='.$match['ScoreEquipe'].'&ScoreEquipeAdv='.$match['ScoreEquipeAdv'].
                '">Modifier</a>
                  / <a href="MatchList.php?del='.$match['IDMatch'].'">Supprimer</a>
                </td>';
        echo '</tr>';
    }
    ?>
</table>
