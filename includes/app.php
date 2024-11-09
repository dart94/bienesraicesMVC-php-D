<?php
use Model\ActiveRecord;
require __DIR__ . '/../vendor/autoload.php';
// Cargar el archivo .env solo en desarrollo
if (getenv('RAILWAY_ENVIRONMENT') === false) { 
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
    $dotenv->load();
}

require 'funciones.php';
require 'config/databe.php';

//Conexión a la base

$db = conectarDB();


ActiveRecord::setdb($db);



