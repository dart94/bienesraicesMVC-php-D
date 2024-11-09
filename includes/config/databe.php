<?php

function conectarDB(): mysqli
{
    $host = getenv('RAILWAY_PRIVATE_DOMAIN') ?: die("Error: La variable RAILWAY_PRIVATE_DOMAIN no está definida.");
    $user = getenv('MYSQLUSER') ?: die("Error: La variable MYSQLUSER no está definida.");
    $pass = getenv('MYSQLPASSWORD') ?: die("Error: La variable MYSQLPASSWORD no está definida.");
    $name = getenv('MYSQLDATABASE') ?: die("Error: La variable MYSQLDATABASE no está definida.");
    $port = 3306;

    // Intenta conectar a la base de datos
    $db = new mysqli($host, $user, $pass, $name, $port);

    if ($db->connect_error) {
        echo "No se pudo conectar: " . $db->connect_error;
        exit;
    }

    $db->set_charset('utf8');
    return $db;
}
