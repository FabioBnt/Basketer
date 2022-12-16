<?php
include './DataBase.php';

class Players
{
    public function selectPlayers($number = '', $familyName = '', $name = '', $photo = '', $birthDate = '', $size = 0, $weight = 0, $prefPos = '', $status = '')
    {
        $numCols = 0;
        $conds = 'where ';
        if ($number !== '') {
            $conds . +"NumLicence = '$number' AND ";
            $numCols++;
        }
        if ($familyName !== '') {
            $conds . +"Nom = '$familyName' AND ";
            $numCols++;
        }
        if ($name !== '') {
            $conds . +"Prenom = '$name' AND ";
            $numCols++;
        }
        if ($photo !== '') {
            $conds . +"Photo = '$photo' AND ";
            $numCols++;
        }
        if ($birthDate !== '') {
            $conds . +"DateNaiss = '$birthDate' AND ";
            $numCols++;
        }
        if ($size !== 0) {
            $conds . +"Taille = '$size' AND ";
            $numCols++;
        }
        if ($weight !== 0) {
            $conds . +"Poids = '$weight' AND ";
            $numCols++;
        }
        if ($prefPos !== '') {
            $conds . +"Taille = '$size' AND ";
            $numCols++;
        }
        if ($status !== '') {
            $conds . +"Status = '$status'    ";
            $numCols++;
        }
        $conds = substr($conds, 0, -4);

        $mysql = DataBase::getInstance();
        $data = array();
        if ($numCols !== 0) {
            $data = $mysql->select('*', 'Joueur', $conds);
        } else {
            $data = $mysql->select('*', 'Joueur');
        }
        return $data;
    }

    public function insertPlayer($number, $familyName, $name, $photo, $birthDate, $size, $weight, $prefPos, $status)
    {
        $mysql = DataBase::getInstance();
        $values = array($number, $familyName, $name, $photo, $birthDate, $size, $weight, $prefPos, $status);
        $mysql->insert('`Joueur` (`NumLicence`, `Nom`, `Prenom`, `Photo`, `DateNaiss`, `Taille`, `Poids`, `PostePref`, `Statut`)', $values);
    }

    public function modifyPlayer()
    {

    }


}

?>