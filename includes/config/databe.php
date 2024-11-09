<?php

function conectarDB(): mysqli
{
    // Usa el host y puerto externos proporcionados en MYSQL_URL
    $host = 'autorack.proxy.rlwy.net';
    $port = 48982;
    $user = getenv('MYSQLUSER') ?: die("Error: La variable MYSQLUSER no está definida.");
    $pass = getenv('MYSQLPASSWORD') ?: die("Error: La variable MYSQLPASSWORD no está definida.");
    $name = getenv('MYSQLDATABASE') ?: die("Error: La variable MYSQLDATABASE no está definida.");

    $db = new mysqli($host, $user, $pass, $name, $port);

    if ($db->connect_error) {
        echo "No se pudo conectar: " . $db->connect_error;
        exit;
    }

    $db->set_charset('utf8');
    return $db;
}
