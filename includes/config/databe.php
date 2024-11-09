<?php

function conectarDB(): mysqli
{
    $host = getenv('MYSQLHOST');
    $user = getenv('MYSQLUSER');
    $pass = getenv('MYSQLPASSWORD');
    $name = getenv('MYSQLDATABASE');
    $port = getenv('MYSQLPORT');

    // Verifica que $host esté definido antes de intentar conectarse
    if (!$host) {
        die("Error: MYSQLHOST no está definido.");
    }

    $db = new mysqli($host, $user, $pass, $name, $port);

    if ($db->connect_error) {
        echo "No se pudo conectar: " . $db->connect_error;
        exit;
    }

    $db->set_charset('utf8');
    return $db;
}
