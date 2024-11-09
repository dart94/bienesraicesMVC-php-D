// Conexión a la base de datos
<?php
function conectarDB() : mysqli {

        // Debugging
        error_reporting(E_ALL);
        ini_set('display_errors', 1);
        
        echo "Intentando conectar con los siguientes parámetros:<br>";
        echo "Host: " . $_ENV['MYSQLHOST'] . "<br>";
        echo "User: " . $_ENV['MYSQLUSER'] . "<br>";
        echo "Database: " . $_ENV['MYSQLDATABASE'] . "<br>";
        echo "Port: " . ($_ENV['MYSQLPORT'] ?? '3306') . "<br>";
        echo "<br>";
    $db = new mysqli(
        $_ENV['MYSQLHOST'] ?? '',
        $_ENV['MYSQLUSER'] ?? '',
        $_ENV['MYSQLPASSWORD'] ?? '',
        $_ENV['MYSQLDATABASE'] ?? ''
    );

    if($db->connect_error) {
        echo "Error de conexión: " . $db->connect_error;
        exit;
    }

    $db->set_charset('utf8');
    return $db;
}