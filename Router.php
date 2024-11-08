<?php

namespace MVC;

class Router {

    public $rutasGet = [];
    public $rutasPost = [];

    public function __construct() {
        // Iniciar sesión al crear una instancia del Router, si la sesión no está ya iniciada.
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function get($url, $fn) {
        $this->rutasGet[$url] = $fn;
    }

    public function post($url, $fn) {
        $this->rutasPost[$url] = $fn;
    }

    public function comprobarRutas() {
        $auth = $_SESSION['login'] ?? null;

        // Rutas protegidas
        $rutas_protegidas = [
            '/admin', 
            '/propiedades/crear',
            '/propiedades/actualizar',
            '/propiedades/eliminar',
            '/vendedores/crear',
            '/vendedores/actualizar',
            '/vendedores/eliminar'
        ];

        $urlActual = strtok($_SERVER['REQUEST_URI'], '?') ?? '/';
        $metodo = $_SERVER['REQUEST_METHOD'];

        // Determinar la función asociada a la URL actual
        if ($metodo === 'GET') {
            $fn = $this->rutasGet[$urlActual] ?? null;
        } else {
            $fn = $this->rutasPost[$urlActual] ?? null;
        }

        // Redirigir si la ruta está protegida y el usuario no está autenticado
        if (in_array($urlActual, $rutas_protegidas) && !$auth) {
            header('Location: /');
            exit;
        }

        // Ejecutar el callback si existe, o mostrar un mensaje de error si no
        if ($fn) {
            call_user_func($fn, $this);
        } else {
            echo "Por el momento no se puede acceder a la ruta $urlActual";
        }
    }

    // Renderiza una vista
    public function render($view, $datos = []) {
        // Convertir el arreglo de datos en variables individuales
        foreach ($datos as $key => $value) {
            $$key = $value;
        }

        // Iniciar el buffer de salida
        ob_start();

        // Incluir la vista y capturar el contenido
        include_once __DIR__ . "/views/$view.php";
        $contenido = ob_get_clean();

        // Incluir el layout principal
        include_once __DIR__ . "/views/layout.php";
    }
}
