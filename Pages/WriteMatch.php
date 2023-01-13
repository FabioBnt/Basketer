<?php
/* Créer une page permettant de faire une sélection parmi les joueurs actifs et de
 définir pour chaque joueur choisi s'il sera titulaire ou remplaçant.
 Si le nombre minimum de joueurs n'est pas atteint,
la sélection ne devra pas pouvoir être validée.
L'interface de sélection devra afficher les informations des joueurs :
  photo, taille, poids, poste préféré, commentaires et évaluations de l'entraineur.
**Adapter l'affichage des matchs pour permettre de visualiser et modifier la sélection.** which means? pas trop compris non plus...
*/
include_once "../php/Classes/DataBase.php";
include_once "../php/Classes/Players.php";
include_once "../php/Classes/Participants.php";

$player = new Players();
$players = $player->selectPlayers("","","",
    "","","", "", "",'Actif');
// needs the id of match as GET of name match to function
if(isset($_GET['match'])) {
    $participants = new Participants($_GET['match']);
    $participants->selectParticipants();

    if(isset($_POST['selected'])) {


        $selected = $_POST['selected'];
        if (count($selected) < 13) {
            echo "<script>alert('Il faut au moins 13 joueurs sélectionnés')</script>";
        } else {
            $participants->deleteAllParticipant($_GET['match']);
            foreach ($selected as $player) {
                $participants->insertParticipant($player, $_POST['evaluation' . $player],$_POST['role' . $player],$_POST['comments' . $player]);
            }
            header('Location:./MatchsList.php');
            exit;
        }
    }

?>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../css/style.css">
    <title>Liste Joueurs</title>
</head>
<body class="list">
<h1>Fiche de match</h1>
<form action="<?php echo $_SERVER['PHP_SELF'];?> " method="post">
<table>
    <tr class="heading">
        <th>Choix</th>
        <th>Joueur</th>
        <th>Numero Licence</th>
        <th>Date de naissance</th>
        <th>Taille</th>
        <th>Poids</th>
        <th>Poste preferé</th>
        <th>Statut</th>
        <th>Role</th>
        <th>Comments</th>
        <th>Evaluation</th>
    </tr>
    <?php
    foreach($players as $player){
        $selected = '';
        $role = '';
        $comments = '';
        $evaluation = '';
        print_r($participants);
        /*if(isset($participants[$player['NumLicence']])){
            $selected = 'checked';
            $role = $participants[$player['NumLicence']]['role'];
            $comments = $participants[$player['NumLicence']]['comments'];
            $evaluation = $participants[$player['NumLicence']]['evaluation'];
        }*/
        echo '<tr>';
        echo '<td><input type="checkbox" name="selected[]" value="' . $player['NumLicence'] . ' ' . $selected . '"></td>';
        echo '<td class="player-name">';
        echo "<img src=\"" . $player['Photo'] . "\" alt=\"photo " . $player['Nom'] . "\"/>";
        echo $player['Nom'] . ' ' . $player['Prenom'];
        echo '</td>';
        echo '<td>'.$player['NumLicence'].'</td>';
        echo '<td>'.$player['DateNaiss'].'</td>';
        echo '<td>'.$player['Taille'].'</td>';
        echo '<td>'.$player['Poids'].'</td>';
        echo '<td>'.$player['PostePref'].'</td>';
        echo '<td>'.$player['Statut'].'</td>';
        echo '<td><select name="role' . $player['NumLicence'] . '">
                <option value="Titulaire" ' . ($role === 'Titulaire' ? 'selected' : '') . '>Titulaire</option> 
                <option value="Remplaçant" ' . ($role == 'Remplaçant' || $role == 'Remplacant' ? 'selected' : '') . '>Remplaçant</option> 
                </select></td>';
        echo '<td><textarea name="comments' . $player['NumLicence'] . '" cols="30" rows="10"> ' . $comments . ' </textarea></td>';
        echo '<td><input type="number" name="evaluation' . $player['NumLicence'] . '" value="' . $evaluation . '" min="0"></td>';
        echo '</tr>';
    }
    //hidden input match
    echo '<input type="hidden" name="match" value="'.$_GET['match'].'">';
    ?>
</table>
    <input type="submit" name="submit" value="Valider">
</form>
</body>
</html>
<?php
}else{
    echo "<script>alert('Il faut choisir un match')</script>";
    header('Location:./MatchsList.php');
    exit;
}
?>