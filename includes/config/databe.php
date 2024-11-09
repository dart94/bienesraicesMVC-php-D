<?php
function conectarDB() : mysqli {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    
    try {
        $db = new mysqli(
            $_ENV['MYSQLHOST'],
            $_ENV['MYSQLUSER'],
            $_ENV['MYSQLPASSWORD'],
            $_ENV['MYSQLDATABASE'],
            $_ENV['MYSQLPORT'] ?? 3306
        );

        if($db->connect_error) {
            throw new Exception("Error de conexión: " . $db->connect_error);
        }

        $db->set_charset('utf8');
        return $db;
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage() . "<br>";
        echo "Host: " . $_ENV['MYSQLHOST'] . "<br>";
        echo "User: " . $_ENV['MYSQLUSER'] . "<br>";
        echo "Database: " . $_ENV['MYSQLDATABASE'] . "<br>";
        echo "Port: " . ($_ENV['MYSQLPORT'] ?? '3306') . "<br>";
        die();
    }
}