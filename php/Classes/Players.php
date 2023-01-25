<?php
//include_once './DataBase.php';

class Players
{
    public function selectPlayers($number = '', $familyName = '', $name = '', $photo = '', $birthDate = '', $size = '', $weight = '', $prefPos = '', $status = '')
    {
        $numCols = 0;
        $conds = "where ";
        if ($number !== '') {
            $conds.="NumLicence = '$number' AND ";
            $numCols++;
        }
        if ($familyName !== '') {
            $conds.="Nom = '$familyName' AND ";
            $numCols++;
        }
        if ($name !== '') {
            $conds.="Prenom = '$name' AND ";
            $numCols++;
        }
        if ($photo !== '') {
            $conds.="Photo = '$photo' AND ";
            $numCols++;
        }
        if ($birthDate !== '') {
            $conds.="DateNaiss = '$birthDate' AND ";
            $numCols++;
        }
        if ($size !== '') {
            $conds.="Taille = '$size' AND ";
            $numCols++;
        }
        if ($weight !== '') {
            $conds.="Poids = '$weight' AND ";
            $numCols++;
        }
        if ($prefPos !== '') {
            $conds.="Taille = '$size' AND ";
            $numCols++;
        }
        if ($status !== '') {
            $conds.="Statut = '$status' AND ";
            $numCols++;
        }
        $conds = substr($conds, 0, -4);
        //echo '</br>'.$numCols.''.$conds.'</br>';
        $mysql = DataBase::getInstance();
        $data = array();
        if ($numCols > 0) {
            $data = $mysql->select('*', 'Joueur', $conds);
        } else {
            $data = $mysql->select('*', 'Joueur');
        }
        return $data;
    }

    public function insertPlayer($number, $familyName, $name, $photo, $birthDate, $size, $weight, $prefPos, $status)
    {
        if(count($this->selectPlayers('', $familyName, $name, '', $birthDate)) > 0){
            throw new Exception('duplicate detected : it seems that this player is already in our database');
        }
        if(count($this->selectPlayers($number)) > 0){
            throw new Exception('duplicate detected : player number already exist');
        }
        $mysql = DataBase::getInstance();
        $values = array($number, $familyName, $name, $photo, $birthDate, $size, $weight, $prefPos, $status);
        $mysql->insert('`Joueur` (`NumLicence`, `Nom`, `Prenom`, `Photo`, `DateNaiss`, `Taille`, `Poids`, `PostePref`, `Statut`)', $values);
    }

    public function modifyPlayer($id, $nameCol, $value): void
    {
        $mysql = DataBase::getInstance();
        try {
            $mysql->modifyCol('Joueur', 'NumLicence', $id, $nameCol, $value);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function deletePlayer($id): void
    {
        $mysql = DataBase::getInstance();
        try {
            $mysql->deleteCol('Joueur', 'NumLicence', $id);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
}
/*
$player = new Players();
$player->deletePlayer('111111111');
print_r($player->selectPlayers());
//echo 'ok';
$player->insertPlayer('111111111', 'Wembanyama', 'Victor', '', '2004-01-04', '2m19', '104kg', 'Ailier fort', 'Actif');
echo $player->modifyPlayer('111111111', 'Photo', '');
print_r($player->selectPlayers('111111111', 'Wembanyama', 'Victor', '', '2004-01-04', '2m19', '104kg', 'Ailier fort', 'Actif'));
*/
