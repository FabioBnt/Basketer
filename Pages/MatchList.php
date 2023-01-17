<?php
include_once "../php/Classes/DataBase.php";
include_once "../php/Classes/Matchs.php";
$match = new Matchs();
$matchs = $match->selectMatches();
//$_GET['alertMessage'] shows the message of the alert
if(isset($_GET['alertMessage'])){
    echo "<script>alert('".$_GET['alertMessage']."')</script>";
}
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
    foreach($matchs as $match){
        echo '<tr>';
            echo '<td class="opposingTeam-name">';
                echo $match['NomEquipeAdv'];
            echo '</td>';
            echo '<td>'.$match['DateM'].'</td>';
            echo '<td>'.$match['Lieu'].'</td>';
            echo '<td>'.$match['ScoreEquipe'].'</td>';
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
