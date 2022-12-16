<?php

class DataBase
{
    private static $instance = null;
    ///Connexion au serveur Mysql
    private $server = 'sql926.main-hosting.eu';
    private $login = 'u563109936_fabisma';
    private $pass = 'bgLx7CqfjtNe93gG';
    private $db = 'u563109936_Basket_FI';
    private $linkpdo;

    // Start a session if not already started
    private function __construct()
    {
        try {
            $this->linkpdo = new PDO("mysql:host=$this->server;dbname=$this->db", $this->login, $this->pass);
        } catch (Exception $e) {
            die('Error : ' . $e->getMessage());
        }
    }

    public static function getInstance()
    {
        session_start();
        if (false == isset($_SESSION[self::$_class])) {
            $class = self::$db;
            $_SESSION[self::$db] = new $class;
        }
        return $_SESSION[self::$db];
    }

    public static function _destroy()
    {
    }

    public function getPDO()
    {
        return $this->linkpdo;
    }

    public function select(string $cols, string $tables, string $conditions = "")
    {
        $pdo = $this->getPDO();
        $stmt = $pdo->prepare("select " . $cols . " from " . $tables . " " . $conditions);
        $stmt->execute();
        $data = $stmt->fetchAll();
        return $data;
    }

    public function insert(string $table, int $num, array $values)
    {
        $pdo = $this->getPDO();
        $stmt = $pdo->prepare("INSERT INTO " . $table . " VALUES (" . str_repeat("?, ", $num - 1) . '?)');
        $res = $stmt->execute($values);
    }

    public function modifyCol(string $table, string $nameCol, $value)
    {
        $pdo = $this->getPDO();
        $stmt = $pdo->prepare('UPDATE ' . $table . ' SET ' . $nameCol . ' = ' . $value);
        $res = $stmt->execute($value);
    }

    private static $_class = __CLASS__;
}