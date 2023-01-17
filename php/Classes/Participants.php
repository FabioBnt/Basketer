<?php
//include './DataBase.php';

class Participants
{
    private int $idMatch;
    public function __construct($idMatch)
    {
        $this->idMatch = $idMatch;
    }

    public function selectParticipants($number = '', $role = '', $performance = 0, $comments = '') : array
    {
        $numCols = 0;
        $conds = "where ";
        if ($number !== '') {
            $conds.="NumLicence = '$number' AND ";
        }
        $conds.="IDMatch = $this->idMatch AND ";
        if ($role !== '') {
            $conds.="Role = '$role' AND ";
        }
        if ($performance !== 0) {
            $conds.="Performance = $performance AND ";
        }
        if ($comments !== '') {
            $conds.="Commentaire like '%$comments%' AND ";
        }
        $conds = substr($conds, 0, -4);
        $mysql = DataBase::getInstance();
        $data = array();
        $data = $mysql->select('*', 'participer', $conds);
        // make NumLicence the key of array of $data and return it
        $data = array_combine(array_column($data, 'NumLicence'), $data);
        //if false return array() else return value
        return $data === false ? array() : $data;
        /*$numLicenseData = array();
        foreach ($data as $ligne){
            $numLicenseData[$ligne['NumLicence']] = $ligne;
        }
        return $numLicenseData;*/
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