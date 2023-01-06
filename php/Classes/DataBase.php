<?php
class DataBase
{
    private static $instance = null;
    ///Connexion au serveur Mysql
    private string $server = 'sql926.main-hosting.eu';
    private string $login = 'u563109936_fabisma';
    private string $pass = 'bgLx7CqfjtNe93gG';
    private string $db = 'u563109936_Basket_FI';
    private PDO $linkpdo;

    // Start a session if not already started
    private function __construct()
    {
        try {
            $this->linkpdo = new PDO("mysql:host=$this->server;dbname=$this->db", $this->login, $this->pass);
        } catch (Exception $e) {
            die('Error : ' . $e->getMessage());
        }
    }

    public static function getInstance(): DataBase
    {
        if (self::$instance === null) {
            self::$instance = new DataBase();
        }
        return self::$instance;
    }

    public function getPDO(): PDO
    {
        return $this->linkpdo;
    }
    // selects the $cols of the $tables at the $conditions ... $conditions are "" by default
    // the condition should be a string under the form "WHERE table.col1 = 12 AND table.col2 = 'string'"
    // example $mysql->select('*','Joueur', 'where NumLicence = "123456789"');
    public function select(string $cols, string $tables, string $conditions = "")
    {
        $pdo = $this->getPDO();
        //echo "select " . $cols . " from " . $tables . " " . $conditions. '</br>';
        return $pdo->query("select " . $cols . " from " . $tables . " " . $conditions)->fetchAll();
    }
    // insert array $values in a $table
    // ex : $mysql->insert('`Joueur` (`NumLicence`, `Nom`, `Prenom`, `Photo`, `DateNaiss`, `Taille`, `Poids`, `PostePref`, `Statut`)', 
    //array('111111111', 'Wembanyama', 'Victor', '', '2004-01-04', '2m19', '104kg', 'Ailier fort', 'Actif'));
    public function insert(string $table, array $values)
    {
        $pdo = $this->getPDO();
        $stmt = $pdo->prepare("INSERT INTO " . $table . " VALUES (" . str_repeat("?, ", count($values) - 1) . '?)');
        return $stmt->execute($values);
    }

    // modifies a $col with the new $value in which the $idName (the name of id of the table) 
    // and the value of the id in the wanted line is $idValue
    public function modifyCol(string $table, string $idName, $idValue, string $col, $value, string $idName2 ='', $idValue2=''): bool
    {
        $pdo = $this->getPDO();
        $stmt = null;
        if (is_string($idValue)) {
            $idValue = "'$idValue'";
        }
        if (is_string($value)) {
            $value = "'$value'";
        }
        if($idName2 === ''  || $idValue2 === ''){
            $stmt = $pdo->prepare('UPDATE ' . $table . ' SET ' . $col . ' = ' . $value . ' WHERE ' . $idName . ' = ' . $idValue);
        }else{
            if (is_string($idValue2)) {
                $idValue2 = "'$idValue2'";
            }
            $stmt = $pdo->prepare('UPDATE ' . $table . ' SET ' . $col . ' = ' . $value . ' WHERE ' . $idName . ' = ' . $idValue. ' AND '. $idName2 . ' = ' . $idValue2);
        }
        return $stmt->execute();
    }

    // delete a col of a $table with col $idName that has the $value
    // example $mysql->deleteCol('Joueur','NumLicence', '111111111');
    public function deleteCol(string $table, string $idName, $idValue, string $idName2 = '', $idValue2 = ''): void
    {
        $pdo = $this->getPDO();
        if (is_string($idValue)) {
            $idValue = "'$idValue'";
        }
        if ($idName2 === '' || $idValue2 === '') {
            if (is_string($idValue2)) {
                $idValue2 = "'$idValue2'";
            }
            $pdo->query('DELETE FROM ' . $table . ' WHERE ' . $idName . '=' . $idValue);
        }else{
            $pdo->query('DELETE FROM ' . $table . ' WHERE ' . $idName . '=' . $idValue. ' AND '. $idName2 . ' = ' . $idValue2);
        }
    }
    
    // count the number of col of a table or a part of a table in using $conditions
    // ex : echo $mysql->countCols('Joueur');
    public function countCols(string $table, string $conditions=''){
        $pdo = $this->getPDO();
        return $pdo->query("select count(*) as total from " . $table . " " . $conditions)->fetchAll()[0]['total'];
    }
}
/*
$mysql = DataBase::getInstance();
$mysql->insert('`Joueur` (`NumLicence`, `Nom`, `Prenom`, `Photo`, `DateNaiss`, `Taille`, `Poids`, `PostePref`, `Statut`)', array('111111111', 'Wembanyama', 'Victor', '', '2004-01-04', '2m19', '104kg', 'Ailier fort', 'Actif'));
$result = $mysql->select('*','Joueur');
foreach ($result as $row){
    echo $row['NumLicence'];
    echo $row['Nom'];
    echo $row['Prenom'];
    echo $row['Photo'];
    echo $row['DateNaiss'];
    echo $row['Taille'];
    echo $row['Poids'];
    echo $row['PostePref'];
    echo $row['Statut'];
    echo "</br>";
}
*/
?>