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

    public static function getInstance(): ?DataBase
    {
        if (self::$instance === null) {
            self::$instance = new DataBase();
        }
        return self::$instance;
    }


    public static function _destroy()
    {
    }

    public function getPDO(): PDO
    {
        return $this->linkpdo;
    }

    public function select(string $cols, string $tables, string $conditions = ""): bool|array
    {
        $pdo = $this->getPDO();
        return $pdo->query("select " . $cols . " from " . $tables . " " . $conditions)->fetchAll();
    }

    public function insert(string $table, array $values): void
    {
        $pdo = $this->getPDO();
        $stmt = $pdo->prepare("INSERT INTO " . $table . " VALUES (" . str_repeat("?, ", count($values) - 1) . '?)');
        $res = $stmt->execute($values);
    }

    public function modifyCol(string $table, string $idName, $idValue, string $nameCol, $value): bool
    {
        $pdo = $this->getPDO();
        $stmt = null;
        if (is_string($idValue)) {
            $idValue = "'$idValue'";
        }
        if (is_string($value)) {
            $value = "'$value'";
        }
        $stmt = $pdo->prepare('UPDATE ' . $table . ' SET ' . $nameCol . ' = ' . $value . ' where' . $idName . ' = ' . $idValue);
        return $stmt->execute($value);
    }

    #TODO: Add delete function
    public function deleteCol(string $table, string $idValue, string $idName): void
    {
        $pdo = $this->getPDO();
        $pdo->query('DELETE FROM ' . $table . ' WHERE ' . $idName . '=' . $idValue);
    }
}
/*$mysql = DataBase::getInstance();
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
}*/