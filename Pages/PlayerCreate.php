<?php
include_once "../php/Classes/DataBase.php";
include_once "../php/Classes/Players.php";
if(isset($_POST['number'])){
    $player = new Players();
    $number = $_POST['number'];
    $familyName = $_POST['familyName'];
    $name = $_POST['name'];
    $birthDate = $_POST['birthDate'];
    $size = $_POST['size'];
    $weight = $_POST['weight'];
    $prefPos = $_POST['prefPos'];
    $status = $_POST['status'];
    $image=$_FILES['photo'];
    $temp = explode('.', $image['name']);
    $newfilename = '../../Images/'.$number.'.'. end($temp);
    move_uploaded_file($image['tmp_name'],$newfilename);
    try{
        $player->insertPlayer($number, $familyName, $name, $newfilename, $birthDate, $size, $weight, $prefPos, $status);
        header('Location:./PlayersList.php');
        exit;
    }catch(Exception $e){
        echo $e->getMessage();
    }
}
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
        <h3>Creer joueur</h3>
        <fieldset>
            Numero Licence<input placeholder="Numero Licence" type="text" name="number" required autofocus>
        </fieldset>
        <fieldset>
            Nom &emsp;<input placeholder="Nom" type="text" name="familyName"  required>
        </fieldset>
        <fieldset>
            Prenom &emsp;<input placeholder="Prenom" type="text" name="name"  required>
        </fieldset>
        <fieldset>
            <label for="imageUpload" >Changer Image (vide sinon)</label>
            <input placeholder="Selectionner Image" type="file" id="imageUpload"
                   accept="image/png, image/jpeg, image/jpg" name="photo" required>
        </fieldset>
        <fieldset>
            Date de Naissance &emsp;&emsp;&emsp;<input placeholder="Date de Naissance" type="date" name="birthDate" required>
        </fieldset>
        <fieldset>
            Taille &emsp;<input placeholder="Taille" type="number" name="size" min="1" step="0.01" required>
        </fieldset>
        <fieldset>
            Poids &emsp;<input placeholder="Poids" type="number" name="weight" min="50"  required>
        </fieldset>
        <fieldset>
            Poste &emsp;<input placeholder="Poste" type="text" name="prefPos"  required>
            <fieldset>
                Statut &emsp;<select name="status" id="status">
                    <option value="Actif" >Actif</option>
                    <option value="Blessé">Blessé</option>
                    <option value="Suspendu" >Suspendu</option>
                    <option value="Absent" >Absent</option>
                </select>
            </fieldset>
            <button name="submit" type="submit" id="modif-submit" data-submit="...Sending">Creer</button>
        </fieldset>
    </form>

</div>
</body>
</html>