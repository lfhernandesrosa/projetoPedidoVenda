<?php
require_once 'config.php';

class dataBase {

    protected static $db;

    private function __construct() {

        try {

            self::$db = new PDO(config::DB_DRIVER . ":host=" . config::DB_HOST . "; dbname=" . config::DB_NAME . "", config::DB_USER, config::DB_PASSWORD);
            self::$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            self::$db->exec('SET NAMES utf8');
        } catch (PDOException $e) {
            die("Connection Error: " . $e->getMessage());
        }
    }

    public static function conexao() {

        if (!self::$db) {
            new Database();
        }
        return self::$db;
    }

}

?>