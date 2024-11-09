<?php
function conectarDB(): mysqli
{
    // Obtener la URL de conexión
    $url = getenv('MYSQL_URL');
    
    if (!$url) {
        die("Error: La variable MYSQL_URL no está definida. Verifica las variables de entorno.");
    }

    try {
        // Parsear la URL de conexión
        $dbUrl = parse_url($url);
        
        // Extraer los componentes
        $host = $dbUrl['host'] ?? die("Error: Host no definido en MYSQL_URL");
        $port = $dbUrl['port'] ?? 3306;
        $user = $dbUrl['user'] ?? die("Error: Usuario no definido en MYSQL_URL");
        $pass = $dbUrl['pass'] ?? die("Error: Contraseña no definida en MYSQL_URL");
        $name = ltrim($dbUrl['path'], '/') ?: die("Error: Nombre de la base de datos no definido en MYSQL_URL");

        // Crear conexión
        $db = new mysqli($host, $user, $pass, $name, (int)$port);

        if ($db->connect_error) {
            throw new Exception("Error de conexión a MySQL: " . $db->connect_error);
        }

        $db->set_charset('utf8');
        return $db;
    } catch (Exception $e) {
        // Mostrar información de diagnóstico
        $debug_info = [
            'host' => $host ?? 'no definido',
            'port' => $port ?? 'no definido',
            'database' => $name ?? 'no definido',
            'MYSQL_URL_exists' => !empty(getenv('MYSQL_URL')) ? 'sí' : 'no'
        ];
        
        die("Error de conexión: " . $e->getMessage() . "\n" .
            "Información de diagnóstico: " . print_r($debug_info, true));
    }
}