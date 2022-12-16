<?php

class DataBase
{
    private static $instance = null;
    ///Connexion au serveur Mysql
    private string $server = 'sql926.main-hosting.eu';
    private string $login = 'u563109936_fabisma';
    private string $pass = 'bgLx7CqfjtNe93gG';
    private static string $db = 'u563109936_Basket_FI';
    private PDO $linkpdo;

    // Start a session if not already started
    private function __construct()
    {
        $db = self::$db;
        try {
            $this->linkpdo = new PDO("mysql:host=$this->server;dbname=$db", $this->login, $this->pass);
        } catch (Exception $e) {
            die('Error : ' . $e->getMessage());
        }
    }

    public static function getInstance()
    {
        session_start();
        if (!isset($_SESSION[self::$_class])) {
            $class = self::$db;
            $_SESSION[self::$db] = new $class;
        }
        return $_SESSION[self::$db];
    }

    public static function _destroy()
    {
    }

    public function getPDO(): PDO
    {
        return $this->linkpdo;
    }

    public function select(string $cols, string $tables, string $conditions = "")
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

    public function modifyCol(string $table, string $nameCol, $value): void
    {
        $pdo = $this->getPDO();
        $stmt = $pdo->prepare('UPDATE ' . $table . ' SET ' . $nameCol . ' = ' . $value);
        $res = $stmt->execute($value);
    }

    private static $_class = __CLASS__;
}