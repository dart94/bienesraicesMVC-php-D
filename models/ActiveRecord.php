<?php

namespace Model;

class ActiveRecord{

    //base de Datos
    protected static $db;
    protected static $columbasDB = [];

    protected static $tabla = '';
    
    //Errores
    protected static $errores = [];

    //Definir la conexión a la BD
    public static function setDB($database){
    self::$db = $database;
    }



    public function guardar(){
        if(!is_null($this->id)){
            $this->actualizar();}
             else {
            $this->crear();
        }
    }

    public function crear(){

        //Sanitizar los datos
    $atributos = $this->sanitizarAtributos();

        // Inseetar en la base de datos
        $query = " INSERT INTO " . static::$tabla . " ( ";
        $query .= join(', ',array_keys($atributos));
        $query .= " ) VALUES (' "; 
        $query .= join("', '",array_values($atributos));
        $query .= " ')";

        $resultado = self::$db->query($query);

        //Mensaje de exito
        if ($resultado) {
            // Rediccionar
            header('Location: /admin?resultado=1');
        }
    }

    

    public function actualizar(){
        //Sanitizar los datos
        $atributos = $this->sanitizarAtributos();

        // Inseetar en la base de datos
        $valores = [];
        foreach($atributos as $key => $value){
            $valores[] = "{$key} = '{$value}'";
        }

        $query = "UPDATE " . static::$tabla . " SET ";
        $query .= join(', ',$valores);
        $query .= " WHERE id = '" . self::$db->escape_string($this->id) . "'";
        $query .= " LIMIT 1";

        $resultado = self::$db->query($query);
        if($resultado){
            //redirecionar
            header('Location: /admin?resultado=2');
        }

    }

    //Eliminar un registro
    public function eliminar(){
        $query = "DELETE FROM " . static::$tabla . " WHERE id = " . self::$db->escape_string($this->id) . " LIMIT 1";
        $resultado = self::$db->query($query);
        //Mensaje de exito
        if ($resultado) {
            //Eliminar el archivo
            $this->borrarImagen();
            // Rediccionar
            header('Location: /admin?resultado=3');
        }
    
    }

public function atributos(){
    $atributos = [];
    foreach(static::$columbasDB as $columna) {
        if($columna ==='id') continue;
        $atributos[$columna] = $this->$columna;
    }
    return $atributos;
}    

public function sanitizarAtributos(){
    $atributos = $this->atributos();
    $sanitizado = [];

    foreach($atributos as $key => $value){
       $sanitizado [$key] = self::$db->escape_string($value);
    }

    return $sanitizado;
}

// subida de archivos
public function setImagen($imagen){

    //Elimina la imagen anterior
    if(!is_null($this->id)){
        $this->borrarImagen();
        
    }

    //asignar al atributo de imagen el nombre de la imagen
    if($imagen){
        $this->imagen = $imagen;
    }
}

//Eliminar la imagen
public function borrarImagen(){
    //Comprobar si existe el archivo
    $existearchivo = file_exists(CARPETAS_IMAGENES . $this->imagen);
    if($existearchivo){
        unlink(CARPETAS_IMAGENES . $this->imagen);
    }
    
}

//Validacion
public static function getErrores(){
       return static::$errores;
}

public function validar(){
    static::$errores = [];
    return static::$errores;
}

//Lista todas las propiedades
public static function all(){
    $query = "SELECT * FROM " . static::$tabla;

    $resultado = self::consultarSQL($query);

    return $resultado;
}

// Obtiene un determinado registro
public static function get($cantidad){
    $query = "SELECT * FROM " . static::$tabla . " LIMIT " . $cantidad;;

    $resultado = self::consultarSQL($query);

    return $resultado;
}

// Buscar una propiedad
public static function find($id){
    $query = "SELECT * FROM " . static::$tabla . " WHERE id = {$id}";
    $resultado = self::consultarSQL($query);

    return array_shift($resultado);
}

public static function consultarSQL($query){
    //Consultar la base de datos
    $resultado = self::$db->query($query);

    //Iterar los resultados
    $array = [];
    while($registro = $resultado->fetch_assoc()){
        $array[] = static::crearObjeto($registro);
    }

    //liberar la memoria
    $resultado->free();


    //retornar los resultados
    return $array;
    }

    protected static function crearObjeto($registro){
        $objeto = new static;

        foreach($registro as $key => $value){
            if(property_exists($objeto, $key)){
                $objeto->$key = $value;
            }
        }
        return $objeto;
    }

    //Sincronizar con la base de datos
    public function sincronizar($args = []){
        foreach($args as $key => $value){
            if(property_exists($this, $key) && !is_null($value)){
                $this->$key = $value;
            }
        }

    }

}