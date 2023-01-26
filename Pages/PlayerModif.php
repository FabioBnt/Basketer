<?php
include_once "../php/Classes/DataBase.php";
include_once "../php/Classes/Players.php";
include_once '../php/Classes/Images.php';
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
if (isset($_POST['number'])) {
    $player = new Players();
    $number = $_POST['number'];
    $oldNumber = $_POST['oldnumber'];
    $player->modifyPlayer($oldNumber, 'NumLicence', $number);
    $familyName = $_POST['familyName'];
    $player->modifyPlayer($number, 'Nom', $familyName);
    $name = $_POST['name'];
    $player->modifyPlayer($number, 'Prenom', $name);
    $birthDate = $_POST['birthDate'];
    $player->modifyPlayer($number, 'DateNaiss', $birthDate);
    $size = $_POST['size'];
    $player->modifyPlayer($number, 'Taille', $size);
    $weight = $_POST['weight'];
    $player->modifyPlayer($number, 'Poids', $weight);
    $prefPos = $_POST['prefPos'];
    $player->modifyPlayer($number, 'PostePref', $prefPos);
    $status = $_POST['status'];
    $player->modifyPlayer($number, 'Statut', $status);
    //print_r($_POST);
    if($oldNumber != $number){
        $imgPath = $player->selectPlayers($oldNumber)[0]['Photo'];
        if (file_exists($imgPath)) {
            unlink($imgPath);
        }
    }
    if (isset($_FILES['photo'])) {
        $image = $_FILES['photo'];
        $temp = explode('.', $image['name']);
        $extension = end($temp);
        if ($extension == 'jpg' || $extension == 'png' || $extension == 'jpeg') {
            $newfilename = '../../Images/' . $number . '.' . $extension;
            move_uploaded_file($image['tmp_name'], $newfilename);
            $player->modifyPlayer($number, "Photo", $newfilename);
        }
    }
    //$player->insertPlayer($number, $familyName, $name, $photo, $birthDate, $size, $weight, $prefPos, $status);
    header('Location:./PlayersList.php');
    exit;
}
if (!isset($_GET['number'])) {
    header('Location:./PlayersList.php');
    exit;
} else {
    $num = $_GET['number'];
    $nom = $_GET['Nom'];
    $prenom = $_GET['Prenom'];
    $photo = $_GET['Photo'];
    $date = $_GET['DateNaiss'];
    $taille = $_GET['Taille'];
    $poids = $_GET['Poids'];
    $poste = $_GET['Poste'];
    $status = $_GET['Status'];
?>
    <!DOCTYPE html>
    <html lang="fr">
    <!--todo make a form to modify player-->

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../css/style.css">
        <title>Modifier un joueur</title>
    </head>

    <body>
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
        <div class="containerM">
            <form id="modif" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">
                <!--hidden number before the form-->
                <input type="hidden" name="oldnumber" value="<?php echo $num; ?>">
                <h3>Modifier joueur <?php echo $nom; ?></h3>
                <fieldset>
                    Numero Licence<input placeholder="Numero Licence" type="text" name="number" value="<?php echo $num; ?>" required autofocus>
                </fieldset>
                <fieldset>
                    Nom &emsp;<input placeholder="Nom" type="text" name="familyName" value="<?php echo $nom; ?>" required>
                </fieldset>
                <fieldset>
                    Prenom &emsp;<input placeholder="Prenom" type="text" name="name" value="<?php echo $prenom; ?>" required>
                </fieldset>
                <fieldset>
                    <label for="imageUpload">Changer Image (vide sinon)</label>
                    <input placeholder="Selectionner Image" type="file" id="imageUpload" value="" accept="image/png, image/jpeg, image/jpg" name="photo">
                </fieldset>
                <fieldset>
                    Date de Naissance &emsp;&emsp;&emsp;<input placeholder="Date de Naissance" type="date" name="birthDate" value="<?php echo $date; ?>" required>
                </fieldset>
                <fieldset>
                    Taille &emsp;<input placeholder="Taille" type="number" name="size" min="1.0" value="<?php echo $taille; ?>" step=".01" required>
                </fieldset>
                <fieldset>
                    Poids &emsp;<input placeholder="Poids" type="number" name="weight" min="50" value="<?php echo $poids; ?>" required>
                </fieldset>
                <fieldset>
                    Poste &emsp;<input placeholder="Poste" type="text" name="prefPos" value="<?php echo $poste; ?>" required>
                    <fieldset>
                        Statut &emsp;<select name="status" id="status">
                            <option value="Actif" <?php if ($status == "Actif") {
                                                        echo "selected";
                                                    } ?>>Actif</option>
                            <option value="Blessé" <?php if ($status == "Blessé") {
                                                        echo "selected";
                                                    } ?>>Blessé</option>
                            <option value="Suspendu" <?php if ($status == "Suspendu") {
                                                            echo "selected";
                                                        } ?>>Suspendu</option>
                            <option value="Absent" <?php if ($status == "Absent") {
                                                        echo "selected";
                                                    } ?>>Absent</option>
                        </select>
                    </fieldset>
                    <button name="submit" type="submit" id="modif-submit" data-submit="...Sending">Modifier</button>
                </fieldset>
            </form>

        </div>
    </body>

    </html>
<?php } ?>