<?php
include_once "../php/Classes/DataBase.php";
include_once "../php/Classes/Players.php";
if(isset($_POST['number'])){
    $player = new Players();
    $number = $_POST['number'];
    $player->modifyPlayer($number, 'NumLicence', $number);
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
    print_r($_POST);
    if(isset($_FILES['photo'])){
        $image=$_FILES['photo'];
        $temp = explode('.', $image['name']);
        $newfilename = '../../Images/.$number' . '.' . end($temp);
        move_uploaded_file($image['tmp_name'],$newfilename);
        $player->modifyPlayer($number,"Photo", $newfilename);
    }
    //$player->insertPlayer($number, $familyName, $name, $photo, $birthDate, $size, $weight, $prefPos, $status);
    header('Location:./PlayersList.php');
    exit;
}
if(!isset($_GET['number'])){
    header('Location:./PlayersList.php');
    exit;
}else{
$num = $_GET['number'];
$nom = $_GET['Nom'];
$prenom = $_GET['Prenom'];
$photo = $_GET['Photo'];
$date = $_GET['DateNaiss'];
$taille = $_GET['Taille'];
$poids = $_GET['Poids'];
$poste = $_GET['Poste'];
$status = $_GET['Statut'];
?>
<!DOCTYPE html>
<html lang="fr">
<!--todo make a form to modify player-->
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <title>Basketer</title>
</head>
<body>
<div class="containerM">
    <form id="modif" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">
        <h3>Modifier joueur <?php echo $nom;?></h3>
        <fieldset>
            Numero Licence<input placeholder="Numero Licence" type="text" name="number" value="<?php echo $num;?>" required autofocus>
        </fieldset>
        <fieldset>
            Nom &emsp;<input placeholder="Nom" type="text" name="familyName" value="<?php echo $nom;?>" required>
        </fieldset>
        <fieldset>
            Prenom &emsp;<input placeholder="Prenom" type="text" name="name" value="<?php echo $prenom;?>" required>
        </fieldset>
        <fieldset>
            <label for="imageUpload" >Changer Image (vide sinon)</label>
            <input placeholder="Selectionner Image" type="file" id="imageUpload" value=""
                         accept="image/png, image/jpeg, image/jpg" name="photo" >
        </fieldset>
        <fieldset>
            Date de Naissance &emsp;&emsp;&emsp;<input placeholder="Date de Naissance" type="date" name="birthDate" value="<?php echo $date;?>" required>
        </fieldset>
        <fieldset>
            Taille &emsp;<input placeholder="Taille" type="text" name="size" value="<?php echo $taille;?>" required>
        </fieldset>
        <fieldset>
            Poids &emsp;<input placeholder="Poids" type="text" name="weight" value="<?php echo $poids;?>" required>
        </fieldset>
        <fieldset>
            Poste &emsp;<input placeholder="Poste" type="text" name="prefPos" value="<?php echo $poste;?>" required>
        <fieldset>
            Statut &emsp;<input placeholder="Statut" type="text" name="status" value="<?php echo $status;?>" required>
        </fieldset>
            <button name="submit" type="submit" id="modif-submit" data-submit="...Sending">Modifier</button>
        </fieldset>
    </form>

</div>
</body>
</html>
<?php } ?>