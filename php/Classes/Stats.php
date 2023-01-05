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
        return array($totals[1]/$totals[0], $totals[2]/$totals[0], $totals[3]/$totals[0], $totals[3]/$totals[0], $totals[4]/$totals[0]);
    }
    // returns the number of times he played as main player, subtitude, avg performance, won while participating
    public function playerStats($number){
        $mysql = DataBase::getInstance();
        $main = $mysql->countCols('participer', 'where NumLicence = '."'$number'".' AND Role = "Titulaire"');
        $replace = $mysql->countCols('participer', 'where NumLicence = '."'$number'".' AND Role = "Remplacant"');
        $average = $mysql->select('AVG(Performance) as total', 'participer', 'NumLicence = '."'$number'".' AND Performance is not NULL');
        $participateWon = $mysql->countCols('participer p, Matchs m', 'where where m.IdMatch= p.IdMatch 
        AND m.ScoreEquipe > m.ScoreEquipeAdv AND p.NumLicence = '."'$number'");
        return array($main, $replace, $average, $participateWon/($main + $replace));
    }
    #TODO (optional) : Si possible, ajouter également le nombre de sélections consécutives (facultatif).
}

?>