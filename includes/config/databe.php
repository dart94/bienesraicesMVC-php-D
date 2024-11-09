<?php
function conectarDB() : mysqli {
    // En Docker con Railway, usamos el host interno
    $host = 'mysql.railway.internal';  // Host fijo para Docker en Railway
    $user = 'root';
    $password = $_ENV['MYSQL_ROOT_PASSWORD'] ?? '';  // Usando la variable correcta
    $database = 'railway';
    $port = 3306;  // Puerto interno fijo en Docker

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