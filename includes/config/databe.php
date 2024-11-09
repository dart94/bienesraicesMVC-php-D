<?php
function conectarDB() : mysqli {
    $host = $_ENV['MYSQLHOST'] ?? 'localhost';
    $user = $_ENV['MYSQLUSER'] ?? 'root';
    $password = $_ENV['MYSQLPASSWORD'] ?? '';
    $database = $_ENV['MYSQLDATABASE'] ?? 'test';
    $port = $_ENV['MYSQLPORT'] ?? 3306;

    try {
        $db = new mysqli($host, $user, $password, $database, $port);

        if ($db->connect_error) {
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
