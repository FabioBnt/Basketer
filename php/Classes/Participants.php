<?php
include './DataBase.php';

class Participants
{
    public function selectParticipants($idMatch = 0, $number = '', $role = '', $performance = '', $comments = '')
    {
        $numCols = 0;
        $conds = "where ";
        if ($number !== '') {
            $conds.="NumLicence = '$number' AND ";
            $numCols++;
        }
        if ($idMatch !== 0) {
            $conds.="IdMatch = $idMatch AND ";
            $numCols++;
        }
        if ($role !== '') {
            $conds.="Role = '$role' AND ";
            $numCols++;
        }
        if ($performance !== '') {
            $conds.="Performance = '$performance' AND ";
            $numCols++;
        }
        if ($comments !== '') {
            $conds.="Commentaire like '%$comments%' AND ";
            $numCols++;
        }
        $conds = substr($conds, 0, -4);
        $mysql = DataBase::getInstance();
        $data = array();
        if ($numCols > 0) {
            $data = $mysql->select('*', 'participer', $conds);
        } else {
            $data = $mysql->select('*', 'participer');
        }
        return $data;
    }

    public function insertParticipant($number, $idMatch, $performance, $role, $comments)
    {
        try{
            $mysql = DataBase::getInstance();
            $values = array($number, $idMatch, $performance, $role, $comments);
            $mysql->insert('`participer` (`NumLicence`, `IDMatch`, `Performance`, `Role`, `Commentaire`)', $values);
        }catch (Exception $e) {
            echo $e->getMessage();
        }
        
    }

    public function modifyParticipant($idPlayer, $idMatch, $nameCol, $value): void
    {
        $mysql = DataBase::getInstance();
        try {
            $mysql->modifyCol('Joueur', 'NumLicence', $idPlayer, $nameCol, $value, 'IdMatch', $idMatch);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function deleteParticipant($idPlayer, $idMatch): void
    {
        $mysql = DataBase::getInstance();
        $mysql->deleteCol('participer','NumLicence', $idPlayer, 'IdMatch', $idMatch);
    }
    public function deleteAllParticipant($idMatch): void
    {
        $mysql = DataBase::getInstance();
        $mysql->deleteCol('participer','IdMatch', $idMatch);
    }
    public function numberOfParticipants($idMatch){
        $mysql = DataBase::getInstance();
        return $mysql->countCols('participer', 'where IdMatch = '.$idMatch);
    }
}