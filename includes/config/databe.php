<?php

function conectarDB(): mysqli
{
    // Configuración directa sin variables de entorno
    $host = 'autorack.proxy.rlwy.net';  // Host externo
    $user = 'root';                     // Usuario proporcionado
    $pass = 'vnrotqSGIQVLCSwArWfQiKlHyQvNItGQ'; // Contraseña proporcionada
    $name = 'railway';                  // Nombre de la base de datos
    $port = 48982;                      // Puerto externo específico

    // Intenta la conexión a la base de datos
    $db = new mysqli($host, $user, $pass, $name, $port);

    if ($db->connect_error) {
        echo "No se pudo conectar: " . $db->connect_error;
        exit;
    }

    $db->set_charset('utf8');
    return $db;
}

