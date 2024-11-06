<?php
use Model\ActiveRecord;
require __DIR__ . '/../vendor/autoload.php';
$doteenv = Dotenv\Dotenv::createImmutable(__DIR__);
$doteenv->safeLoad();

require 'funciones.php';
require 'config/databe.php';

//Conexión a la base

$db = conectarDB();


ActiveRecord::setdb($db);



