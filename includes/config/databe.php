<?php

function conectarDB(): mysqli
{
    $db = new mysqli(
        $_ENV['DB_HOST'],
        $_ENV['DB_USER'],
        $_ENV['DB_PASS'],
        $_ENV['DB_NAME'],
        $_ENV['DB_PORT']
    );

    $db->set_charset('utf8');

    if (!$db) {
        echo "No se pudo conectar";
        exit;
    }

    return $db;
}
