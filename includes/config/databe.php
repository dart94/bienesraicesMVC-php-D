<?php
function conectarDB() : mysqli {
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