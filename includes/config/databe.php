<?php

function conectarDB(): mysqli
{
    $host = getenv('DB_HOST');
    $user = getenv('DB_USER');
    $pass = getenv('DB_PASS');
    $name = getenv('DB_NAME');
    $port = getenv('DB_PORT');

    $db = new mysqli($host, $user, $pass, $name, $port);

    if ($db->connect_error) {
        echo "No se pudo conectar: " . $db->connect_error;
        exit;
    }

    $db->set_charset('utf8');
    return $db;
}
