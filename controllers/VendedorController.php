<?php

namespace Controllers;
use MVC\Router;
use Model\Vendedor;

class VendedorController{
    public static function crear (Router $router){
        
        $errores = Vendedor::getErrores();
        $vendedor = new Vendedor;

        //Ejecutar el código despues
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    //Crear la nueva instancia
    $vendedor = new Vendedor($_POST['vendedor']);

    // Validar
    $errores = $vendedor->validar();

    // No hay errores
    if (empty($errores)) {
        //Guardar en la base de datos
        $vendedor->guardar();
    }
}

        $router->render('vendedores/crear',[
            'errores' => $errores,
            'vendedor' => $vendedor
        ]);
    }

    public static function actualizar(Router $router){
        
        $errores = Vendedor::getErrores();
        $id = validarORedireccionar('/admin');

        //Obtener el arreglo del vendedor
        $vendedor = Vendedor::find($id);

        //Ejecutar el código despues
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Asignar los datos
    $args = $_POST['vendedor'];

    //Sincronizar con la base de datos
    $vendedor->sincronizar($args);
    
    //Validar
    $errores = $vendedor->validar();

    // No hay errores
    if (empty($errores)) {
        
        //Guardar en la base de datos
        $vendedor->guardar();
    }
}

        
        $router->render('vendedores/actualizar',[
            'errores' => $errores,
            'vendedor' => $vendedor
        ]);

    }
    public static function eliminar(){
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            //validar el id
            $id = $_POST['id'];
            $id = filter_var($id, FILTER_VALIDATE_INT);

            if ($id) {
                $tipo = $_POST['tipo'];

                if(validarTipoContenido($tipo)){
                    $vendedor = Vendedor::find($id);
                    $vendedor->eliminar();
                }
             }
        }
    }
}