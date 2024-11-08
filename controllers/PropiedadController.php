<?php

namespace Controllers;
use MVC\Router;
use Model\Propiedad;
use Model\Vendedor;
use Intervention\Image\ImageManagerStatic as Image;


class PropiedadController{
    public static function index(Router $router){
        $propiedades = Propiedad::all();
        $vendedores = Vendedor::all();

        $resultado = $_GET['resultado'] ?? null;


        $router->render('propiedades/admin',[
            'propiedades' => $propiedades,
            'resultado' => $resultado,
            'vendedores' => $vendedores
        ]);
    }


    public static function crear(Router $router){

        $propiedad = new Propiedad;
        $vendedores = Vendedor::all();
        //Arreglo con mensajes de errores
        $errores = Propiedad::getErrores();
        

        //Ejecutar el código despues
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    /** Crea una nueva instancia*/ 
    $propiedad = new Propiedad($_POST['propiedad']);

    // Generar nombre
    $nombreImagen = md5(uniqid(rand(), true))  . ".jpg";

    //Setear la imagen
    //Realiza un resize a la imagen con intervention
    if($_FILES['propiedad']['tmp_name']['imagen']){
        $image = Image::make($_FILES['propiedad']['tmp_name']['imagen'])->fit(800,600);
        $propiedad->setImagen($nombreImagen);
    };

    // Validar
    $errores = $propiedad->validar();

    if (empty($errores)) {
        
        
        //Crear la carpeta para subir la imagenes
        if(!is_dir(CARPETAS_IMAGENES)){
            mkdir(CARPETAS_IMAGENES);
        }

        /**Subida de archivos */
        // Guarda la imagen en el servidor
        $image->save(CARPETAS_IMAGENES . $nombreImagen);

        //Guarda en la base de datos
        $propiedad->guardar();
    }
}

        
        $router->render('propiedades/crear',[
            'propiedad' => $propiedad,
            'vendedores' => $vendedores,
            'errores' => $errores
        ]);
    }

    public static function actualizar(Router $router){
        $id = validarORedireccionar('/admin');

        $propiedad = Propiedad::find($id);

        $errores = $propiedad->getErrores();

        $vendedores = Vendedor::all();

        //Metodo para actualizar la propiedad

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            // Asignar los datos
            $args = $_POST['propiedad'];
            $propiedad->sincronizar($args); 
        
            $errores = $propiedad->validar();
        
            //Validacion subida de archivos
            $nombreImagen = md5(uniqid(rand(), true))  . ".jpg";
            
            if($_FILES['propiedad']['tmp_name']['imagen']){
                $image = Image::make($_FILES['propiedad']['tmp_name']['imagen'])->fit(800,600);
                $propiedad->setImagen($nombreImagen);
            }
            //Revisar que el arreglo de errores este vacio
            if (empty($errores)) {
                if($_FILES['propiedad']['tmp_name']['imagen']){
                //almacenar la imagen
                    $image->save(CARPETAS_IMAGENES . $nombreImagen);
                }
                //guardar la propiedad 
               $propiedad->guardar();
            }
        }

        $router->render('propiedades/actualizar',[
            'propiedad' => $propiedad,
            'errores' => $errores,
            'vendedores' => $vendedores
        ]);

    }

    public static function eliminar(){
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            //Validar ID
            $id = $_POST['id'];
            $id = filter_var($id, FILTER_VALIDATE_INT);
        
            if ($id) {
                $tipo = $_POST['tipo'];
                if(validarTipoContenido($tipo)){
                    $propiedad = Propiedad::find($id);
                    $propiedad->eliminar();
                    }
                }
            }
        }
    }