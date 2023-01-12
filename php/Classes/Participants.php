<?php
//include './DataBase.php';

class Participants
{
    private $idMatch;
    public function __construct($idMatch)
    {
        $this->idMatch = $idMatch;
    }

    public function selectParticipants($number = '', $role = '', $performance = 0, $comments = '')
    {
        $numCols = 0;
        $conds = "where ";
        if ($number !== '') {
            $conds.="NumLicence = '$number' AND ";
            $numCols++;
        }
        if ($this->idMatch !== 0) {
            $conds.="IdMatch = $this->idMatch AND ";
            $numCols++;
        }
        if ($role !== '') {
            $conds.="Role = '$role' AND ";
            $numCols++;
        }
        if ($performance !== 0) {
            $conds.="Performance = $performance AND ";
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
        // make NumLicence the key of array of $data and return it
        return array_combine(array_column($data, 'NumLicence'), $data);
    }

    public function insertParticipant($number, $performance, $role, $comments)
    {
        try{
            $mysql = DataBase::getInstance();
            $values = array($number, $this->idMatch, $performance, $role, $comments);
            $mysql->insert('`participer` (`NumLicence`, `IDMatch`, `Performance`, `Role`, `Commentaire`)', $values);
        }catch (Exception $e) {
            echo $e->getMessage();
        }
        
    }

    public function modifyParticipant($idPlayer, $nameCol, $value): void
    {
        $mysql = DataBase::getInstance();
        try {
            $mysql->modifyCol('Joueur', 'NumLicence', $idPlayer, $nameCol, $value, 'IdMatch', $this->idMatch);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function deleteParticipant($idPlayer): void
    {
        $mysql = DataBase::getInstance();
        $mysql->deleteCol('participer','NumLicence', $idPlayer, 'IdMatch', $this->idMatch);
    }
    public function deleteAllParticipant(): void
    {
        $mysql = DataBase::getInstance();
        $mysql->deleteCol('participer','IdMatch', $this->idMatch);
    }
    public function numberOfParticipants(){
        $mysql = DataBase::getInstance();
        return $mysql->countCols('participer', 'where IdMatch = '.$this->idMatch);
    }
}