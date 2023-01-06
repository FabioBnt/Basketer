<?php
    include_once "../php/Classes/DataBase.php";
    include_once "../php/Classes/Players.php";
    $player = new Players();
    $players = $player->selectPlayers();
    //print_r($players);
?>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../css/style.css">
    <title>Liste Joueurs</title>
</head>
<body class="list">
<h1>Liste des joueurs de l'équipe</h1>
<table>
    <tr class="heading">
        <th>Joueur</th>
        <th>Numero Licence</th>
        <th>Date de naissance</th>
        <th>Taille</th>
        <th>Poids</th>
        <th>Poste preferé</th>
        <th>Statut</th>
    </tr>
    <?php
    foreach($players as $player){
        echo '<tr>';
            echo '<td class="player-name">';
                //echo "<img src='".$player['Photo']."' alt='photo ".$player['Nom'].">";
                echo $player['Nom'].' '.$player['Prenom'];
            echo '</td>';
            echo '<td>'.$player['NumLicence'].'</td>';
            echo '<td>'.$player['DateNaiss'].'</td>';
            echo '<td>'.$player['Taille'].'</td>';
            echo '<td>'.$player['Poids'].'</td>';
            echo '<td>'.$player['PostePref'].'</td>';
            echo '<td>'.$player['Statut'].'</td>';
        echo '</tr>';
    }
    ?>
    <tr>
        <td class="player-name">
            <img src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/85188/car1.png" alt="">
            Compact
        </td>
        <td>140万円</td>
        <td>32km/L</td>
        <td>4人</td>
        <td>0.66L</td>
    </tr>
    <tr>
        <td class="player-name">
            <img src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/85188/car2.png" alt="">
            Nice player
        </td>
        <td>150万円</td>
        <td>20km/L</td>
        <td>5人</td>
        <td>1.3L</td>
    </tr>
    <tr>
        <td class="player-name">
            <img src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/85188/car3.png" alt="">
            Cool player
        </td>
        <td>290万円</td>
        <td>37km/L</td>
        <td>5人</td>
        <td>1.8L</td>
    </tr>
    <tr>
        <td class="player-name">
            <img src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/85188/car4.png" alt="">
            SUV
        </td>
        <td>430万円</td>
        <td>9km/L</td>
        <td>7人</td>
        <td>2.7L</td>
    </tr>
    <tr>
        <td class="player-name">
            <img src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/85188/car5.png" alt="">
            Minivan
        </td>
        <td>290万円</td>
        <td>15km/L</td>
        <td>8人</td>
        <td>1.8L</td>
    </tr>
</table>
</body>
</html>