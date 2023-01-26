<?php

class Matchs
{
    public function selectMatches($date = '', $opposingTeamName = '', $location = '', $score = '', $opposingScore = '')
    {
        $numCols = 0;
        $conds = 'where ';
        if ($date !== '') {
            $conds .= "DateM = '$date' AND ";
            $numCols++;
        }
        if ($opposingTeamName !== '') {
            $conds .= "NomEquipeAdv = '$opposingTeamName' AND ";
            $numCols++;
        }
        if ($location !== '') {
            $conds .= "Lieu = '$location' AND ";
            $numCols++;
        }
        if ($score !== '') {
            $conds .= "ScoreEquipe = '$score' AND ";
            $numCols++;
        }
        if ($opposingScore !== '') {
            $conds .= "ScoreEquipeAdv = '$opposingScore' AND ";
            $numCols++;
        }
        $conds = substr($conds, 0, -4);
        $mysql = DataBase::getInstance();
        $data = array();
        if ($numCols !== 0) {
            $data = $mysql->select('*', 'Matchs', $conds);
        } else {
            $data = $mysql->select('*', 'Matchs');
        }
        return $data;
    }

    public function insertMatch($date, $opposingTeamName, $location, $score, $opposingScore): void
    {
        if (count($this->selectMatches($date, $opposingTeamName, $location, $score, $opposingScore)) > 0) {
            throw new RuntimeException('Ce match existe déjà');
        }
        $mysql = DataBase::getInstance();
        $values = array($date, $opposingTeamName, $location, $score, $opposingScore);
        $mysql->insert('Matchs (DateM,NomEquipeAdv,Lieu,ScoreEquipe,ScoreEquipeAdv)', $values);
    }

    public function modifyMatches($id, $nameCol, $value): void
    {
        $mysql = DataBase::getInstance();
        try {
            $mysql->modifyCol('Matchs', 'IDMatch', $id, $nameCol, $value);
        } catch (Exception $e) {
            $e->getMessage();
        }
    }

    public function deleteMatch($id): void
    {
        $mysql = DataBase::getInstance();
        try {
            $mysql->deleteCol('Matchs', 'IdMatch', $id);
        } catch (Exception $e) {
            $e->getMessage();
        }
    }
}
