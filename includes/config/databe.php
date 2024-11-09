<?php
function conectarDB(): mysqli
{
    // Verificar todas las variables de entorno necesarias
    $required_vars = [
        'MYSQLHOST',
        'MYSQLUSER',
        'MYSQLPASSWORD',
        'MYSQLDATABASE',
        'MYSQLPORT'
    ];

    $missing_vars = [];
    $config = [];

    foreach ($required_vars as $var) {
        $value = getenv($var);
        if ($value === false || $value === '') {
            $missing_vars[] = $var;
        }
        $config[$var] = $value;
    }

    if (!empty($missing_vars)) {
        die("Error: Las siguientes variables de entorno no están definidas: " . 
            implode(', ', $missing_vars));
    }

    try {
        $db = new mysqli(
            $config['MYSQLHOST'],
            $config['MYSQLUSER'],
            $config['MYSQLPASSWORD'],
            $config['MYSQLDATABASE'],
            $config['MYSQLPORT']
        );

        if ($db->connect_error) {
            throw new Exception("Error de conexión: " . $db->connect_error);
        }

        $db->set_charset('utf8');
        return $db;
    } catch (Exception $e) {
        die("Error de conexión a la base de datos: " . $e->getMessage());
    }
}