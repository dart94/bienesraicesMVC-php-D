<?php
function conectarDB() : mysqli {
    // Valores por defecto de Railway
    $host = $_ENV['MYSQLHOST'] ?? $_ENV['DB_HOST'] ?? '';
    $user = $_ENV['MYSQLUSER'] ?? $_ENV['DB_USER'] ?? '';
    $password = $_ENV['MYSQLPASSWORD'] ?? $_ENV['DB_PASS'] ?? '';
    $database = $_ENV['MYSQLDATABASE'] ?? $_ENV['DB_NAME'] ?? '';
    $port = $_ENV['MYSQLPORT'] ?? '3306';

    try {
        $db = new mysqli(
            $host,
            $user,
            $password,
            $database,
            $port
        );

        if($db->connect_error) {
            throw new Exception("Error de conexión: " . $db->connect_error);
        }

        $db->set_charset('utf8');
        return $db;
    } catch (Exception $e) {
        echo "<pre>";
        echo "Error: " . $e->getMessage() . "\n";
        echo "Detalles de conexión:\n";
        echo "Host: " . $host . "\n";
        echo "User: " . $user . "\n";
        echo "Database: " . $database . "\n";
        echo "Port: " . $port . "\n";
        echo "</pre>";
        die();
    }
}