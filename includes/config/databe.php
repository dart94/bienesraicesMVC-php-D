<?php

function conectarDB(): mysqli
{
    // Extrae los detalles de conexión desde MYSQL_PUBLIC_URL
    $url = getenv('MYSQL_PUBLIC_URL');
    if (!$url) {
        die("Error: La variable MYSQL_PUBLIC_URL no está definida.");
    }

    $dbUrl = parse_url($url);
    $host = $dbUrl['host'] ?? die("Error: Host no definido en MYSQL_PUBLIC_URL.");
    $port = $dbUrl['port'] ?? 3306;
    $user = $dbUrl['user'] ?? die("Error: Usuario no definido en MYSQL_PUBLIC_URL.");
    $pass = $dbUrl['pass'] ?? die("Error: Contraseña no definida en MYSQL_PUBLIC_URL.");
    $name = ltrim($dbUrl['path'], '/') ?: die("Error: Nombre de la base de datos no definido en MYSQL_PUBLIC_URL.");

    // Intenta conectar a la base de datos
    $db = new mysqli($host, $user, $pass, $name, $port);

    if ($db->connect_error) {
        echo "No se pudo conectar: " . $db->connect_error;
        exit;
    }

    $db->set_charset('utf8');
    return $db;
}
