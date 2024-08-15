<?php
class Database {
    private static $instance = null;
    private $pdo;

    private function __construct() {
        $dsn = 'mysql:host=localhost;dbname=higal';
        $username = 'root';
        $password = '';
        $options = [
            PDO::ATTR_PERSISTENT => true,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ];
        
        try {
            $this->pdo = new PDO($dsn, $username, $password, $options);
        } catch (PDOException $e) {
            echo 'Connection failed: ' . $e->getMessage();
        }
    }

    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new Database();
        }
        return self::$instance->pdo;
    }
}
?>