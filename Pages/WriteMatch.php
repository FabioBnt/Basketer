<?php
/* Créer une page permettant de faire une sélection parmi les joueurs actifs et de
 définir pour chaque joueur choisi s'il sera titulaire ou remplaçant.
 Si le nombre minimum de joueurs n'est pas atteint,
la sélection ne devra pas pouvoir être validée.
L'interface de sélection devra afficher les informations des joueurs :
  photo, taille, poids, poste préféré, commentaires et évaluations de l'entraineur.
**Adapter l'affichage des matchs pour permettre de visualiser et modifier la sélection.** which means? pas trop compris non plus...
*/
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
include_once "../php/Classes/Participants.php";
include_once '../php/Classes/Images.php';

$player = new Players();
$players = $player->selectPlayers(
    "",
    "",
    "",
    "",
    "",
    "",
    "",
    "",
    'Actif'
);
// needs the id of match as GET of name match to function
/**
 * @param $player
 * @param string $selected
 * @param $role
 * @param $comments
 * @param $evaluation
 * @return void
 */
function displayPlayers($player, string $selected, $role, $comments, $evaluation): void
{
    echo '<tr>';
    echo '<td><input type="checkbox" name="selected[]" value="' . $player['NumLicence'] . '" ' . $selected . '></td>';
    echo '<td class="player-name">';
    echo "<img src=\"" . $player['Photo'] . "\" alt=\"photo " . $player['Nom'] . "\"/>";
    echo $player['Nom'] . ' ' . $player['Prenom'];
    echo '</td>';
    echo '<td>' . $player['NumLicence'] . '</td>';
    echo '<td>' . $player['DateNaiss'] . '</td>';
    echo '<td>' . $player['Taille'] . '</td>';
    echo '<td>' . $player['Poids'] . '</td>';
    echo '<td>' . $player['PostePref'] . '</td>';
    echo '<td>' . $player['Statut'] . '</td>';
    echo '<td><select name="role' . $player['NumLicence'] . '">
                <option value="Titulaire" ' . ($role === 'Titulaire' ? 'selected' : '') . '>Titulaire</option> 
                <option value="Remplaçant" ' . ($role === 'Remplaçant' || $role === 'Remplacant' ? 'selected' : '') . '>Remplaçant</option> 
                </select></td>';
    echo '<td><textarea name="comments' . $player['NumLicence'] . '" cols="30" rows="10"> ' . $comments . ' </textarea></td>';
    echo '<td><input type="number" name="evaluation' . $player['NumLicence'] . '" value="' . $evaluation . '" min="0"></td>';
    echo '</tr>';
}

if (isset($_GET['match']) || isset($_POST['match'])) {
    $match = $_GET['match'] ?? $_POST['match'];
    $participants = new Participants($match);
    $participant = $participants->selectParticipants();
    if (isset($_POST['selected'])) {
        $selected = $_POST['selected'];

        if (count($selected) > 13 || count($selected) < 8) {
            echo '<script>alert("Il faut au moins 8 joueurs et au maximum 13")</script>';
        } // check if the number of tatitulaires equals to 5
        $titulaires = 0;
        if (count($selected) > 5) {
            foreach ($selected as $player) {
                if ($_POST['role' . $player] === 'Titulaire') {
                    $titulaires++;
                }
            }
            if ($titulaires !== 5) {
                echo '<script>alert("Il faut 5 titulaires")</script>';
            }
        }
        if ($titulaires === 5 && count($selected) > 7 && count($selected) < 14) {
            $participants->deleteAllParticipant($match);
            foreach ($selected as $player) {
                $participants->insertParticipant($player, $_POST['evaluation' . $player], $_POST['role' . $player], $_POST['comments' . $player]);
            }
            //send that the modifcation was a success
            header('Location:./MatchList.php?alertMessage=Les modifications ont été enregistrées');
            exit();
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
        <div class="container">
            <header class="menu">
                <div class="logo">
                    <?php Images::logo(); ?>
                </div>
                <nav class="menu" role='navigation'>
                    <ol>
                        <li class="menu-item"><a href="Home.php">Accueil</a></li>
                        <li class="menu-item"><a href="./PlayersList.php">Liste des joueurs</a></li>
                        <li class="menu-item"><a href="./MatchList.php">Liste des matchs</a></li>
                        <li class="menu-item"><a href="Statistics.php">Statistiques</a></li>
                        <?php
                        if ($_SESSION['logged']) {
                            echo '<li class="menu-item" id="disconnect"><a href="./Home.php?logout=true">Déconnexion</a></li>';
                        }
                        ?>
                    </ol>
                </nav>
            </header>
        </div>
        <h1>Fiche de match</h1>
        <form action="<?php echo $_SERVER['PHP_SELF']; ?> " method="POST">
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
                foreach ($players as $player) {
                    $selected = '';
                    $role = '';
                    $comments = '';
                    $evaluation = '';
                    // one of the two must be true
                    if (isset($_GET['match']) && isset($participant[$player['NumLicence']])) {
                        $selected = 'checked';
                        $role = $participant[$player['NumLicence']]['Role'];
                        $comments = $participant[$player['NumLicence']]['Commentaire'];
                        $evaluation = $participant[$player['NumLicence']]['Performance'];
                    }
                    // meme pour if(isset($_POST['selected'])) {
                    //        $selected = $_POST['selected'];
                    if (isset($_POST['selected']) && in_array(($player['NumLicence'] - '0'), $_POST['selected'])) {
                        $selected = 'checked';
                        $role = $_POST['role' . $player['NumLicence']];
                        $comments = $_POST['comments' . $player['NumLicence']];
                        $evaluation = $_POST['evaluation' . $player['NumLicence']];
                    }
                    displayPlayers($player, $selected, $role, $comments, $evaluation);
                }
                //hidden input match
                echo '<input type="hidden" name="match" value="' . $match . '">';
                ?>
            </table>
            <input type="reset" name="reset" value="Defaut">
            <input type="submit" name="submit" value="Valider">
        </form>

    </body>

    </html>
<?php
} else {
    //send that a selection of a match is required
    header('Location:./MatchList.php?alertMessage=Veuillez selectionner un match avant de saisir la fiche de match');
    exit;
}
?>