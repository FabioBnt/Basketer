<?php

class Stats
{
    // returns total of matchs, matchs won, matchs tied, matchs loss, matchs not yet played
    public function totalWinTieLossNull(){
        $mysql = DataBase::getInstance();
        $total = $mysql->countCols('Matchs');
        $win = $mysql->countCols('Matchs', 'where ScoreEquipe > ScoreEquipeAdv');
        $loss = $mysql->countCols('Matchs', 'where ScoreEquipe < ScoreEquipeAdv');
        $none = $mysql->countCols('Matchs', 'where ScoreEquipe is Null OR ScoreEquipeAdv is NUll');
        $tie = $total - $win - $loss - $none;
        return array($total, $win, $tie, $loss, $none);   
    }
    // returns win rate, tie rate, loss rate
    public function percentagesWinTieLossNull(){
        $totals = $this->totalWinTieLossNull();
        // if totals[0] == 0 then return 0
        $win = $totals[0] == 0 ? 0 : 100 * $totals[1] / $totals[0];
        $tie = $totals[0] == 0 ? 0 : 100 * $totals[2] / $totals[0];
        $loss = $totals[0] == 0 ? 0 : 100 * $totals[3] / $totals[0];
        $none = $totals[0] == 0 ? 0 : 100 * $totals[4] / $totals[0];
        return array($win, $tie, $loss, $none);
    }
    // returns the number of times he played as main player, subtitude, avg performance, won while participating
    public function playerStats($number)
    {
        $mysql = DataBase::getInstance();
        $main = $mysql->countCols('Participer', 'where NumLicence = ' . "'$number'" . ' AND Role = "Titulaire"');
        $replace = $mysql->countCols('Participer', 'where NumLicence = ' . "'$number'" . ' AND Role = "Remplacant"');
        $average = $mysql->select('AVG(Performance) as total', 'Participer', 'Where NumLicence = ' . "'$number'" . ' AND Performance is not NULL');
        $average = $average[0]['total'];
        //si null alors 0
        $average = $average == null ? 0 : $average;
        $participateWon = $mysql->countCols('Participer p, Matchs m', 'where m.IDMatch = p.IDMatch 
        AND m.ScoreEquipe > m.ScoreEquipeAdv AND p.NumLicence = ' . "'$number'");
        // if main + replace == 0 then return 0 in parrticipatewon
        $participateWon = $main + $replace == 0 ? 0 : 100 * $participateWon / ($main + $replace);
        return array($main, $replace, $average, $participateWon);
    }
    #TODO (optional) : Si possible, ajouter également le nombre de sélections consécutives (facultatif).
    // returns the number of consecutive selections
    public function consecutiveSelections($number): int
    {
        $mysql = DataBase::getInstance();
        $data = $mysql->select('IdMatch', 'Participer', 'where NumLicence = ' . "'$number'" . ' AND Performance is not NULL');
        $consecutive = 0;
        $max = 0;
        for ($i = 0, $iMax = count($data); $i < $iMax; $i++) {
            if ($i === 0) {
                $consecutive++;
            } else if ($data[$i]['IdMatch'] === $data[$i - 1]['IdMatch'] + 1) {
                $consecutive++;
            } else {
                if ($consecutive > $max) {
                    $max = $consecutive;
                }
                $consecutive = 1;
            }
        }
        return $max;
    }
}
