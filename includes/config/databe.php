<?php

echo 'DB_HOST: ' . getenv('DB_HOST') . "<br>";
echo 'DB_USER: ' . getenv('DB_USER') . "<br>";
echo 'DB_PASS: ' . getenv('DB_PASS') . "<br>";
echo 'DB_NAME: ' . getenv('DB_NAME') . "<br>";

function conectarDB(): mysqli
{
    $db = new mysqli(
        getenv('DB_HOST'),
        getenv('DB_USER'),
        getenv('DB_PASS'),
        getenv('DB_NAME')
    );

    $db->set_charset('utf8');

    if ($db->connect_error) {
        die("Connection failed: " . $db->connect_error);
    }

    return $db;
}
