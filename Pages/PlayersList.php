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
include_once "../php/Classes/Players.php";
$player = new Players();
$players = $player->selectPlayers();

// if we receive an alert message
if (isset($_GET['alert'])) {
    echo "<script>alert('".$_GET['alert']."')</script>";
}

    function image($img): string
    {
        // img = ../../Images/11111111.png
        // remove the ../../
        $img = substr($img, 5);
        $location = dirname($_SERVER['DOCUMENT_ROOT']);
        $image = $location . $img;

        return base64_encode(file_get_contents($image));
    }

//delete player
if (isset($_GET['del'])) {
    //checks if a player is concurring in a match or not
    $mysql = DataBase::getInstance();
    if (count($mysql->select('*', 'Participer', 'where NumLicence = ' . $_GET['del'])) > 0) {
        header('Location:./PlayersList.php?alert="Impossible de supprimer ce joueur car il est inscrit dans un match"');
        exit;
    }
    // $newfilename = '../../Images/' . $number . '.' . end($temp);
    // move_uploaded_file($image['tmp_name'], $newfilename);
    // delete the image in the folder Images if it exists
    $imgPath = $player->selectPlayers($_GET['del'])[0]['Photo'];
    if (file_exists($imgPath)) {
        unlink($imgPath);
    }



    $player->deletePlayer($_GET['del']);
    header('Location:./PlayersList.php?alert="Joueur supprimé"');
    exit;
}
?>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../css/style.css">
    <title>Liste Joueurs</title>
</head>
<body class="list">
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
    <h1 class="title-Players">Liste des joueurs de l'équipe</h1>
    <table>
        <tr class="heading">
            <th>Joueur</th>
            <th>Numero Licence</th>
            <th>Date de naissance</th>
            <th>Taille</th>
            <th>Poids</th>
            <th>Poste preferé</th>
            <th>Statut</th>
            <th>Actions</th>
        </tr>
        <?php
        foreach ($players as $player) {
            echo '<tr>';
            echo '<td class="player-name">';
                echo '<img src="data:image/png;base64,'.image($player['Photo']).'" alt="photo de profil"/>';
                echo $player['Nom'].' '.$player['Prenom'];
            echo '</td>';
            echo '<td>'.$player['NumLicence'].'</td>';
            echo '<td>'.$player['DateNaiss'].'</td>';
            echo '<td>'.$player['Taille'].'m</td>';
            echo '<td>'.$player['Poids'].'kg</td>';
            echo '<td>'.$player['PostePref'].'</td>';
            echo '<td>'.$player['Statut'].'</td>';
            echo '<td><a href="PlayerModif.php?number='.$player['NumLicence'].'&Nom='.$player['Nom'].'&Prenom='.$player['Prenom'].
                '&DateNaiss='.$player['DateNaiss'].'&Taille='.$player['Taille'].'&Poids='.$player['Poids'].'&Poste='.$player['PostePref'].
                '&Status='.$player['Statut'].'&Photo='.$player['Photo'].'">Modifier</a>
                  / <a href="PlayersList.php?del='.$player['NumLicence'].'">Supprimer</a>
                </td>';
        echo '</tr>';
    }
    ?>
    <button class="custom-btn btn-3" onclick="location.href='PlayerCreate.php'"><span>Créer Joueur</span></button>
</table>

</body>
</html>