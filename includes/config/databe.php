<?php
function conectarDB() : mysqli {
    // Usar la URL pública de Railway
    $host = 'autorack.proxy.rlwy.net';  // Host público
    $user = 'root';
    $password = $_ENV['MYSQL_ROOT_PASSWORD'] ?? '';
    $database = 'railway';
    $port = 48982;  // Puerto público

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