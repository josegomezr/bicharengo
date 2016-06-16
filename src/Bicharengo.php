<?php 

/**
* Bicharengo
* @package Bicharengo
*
* Clase principal de este cacharro.
*/
class Bicharengo
{
    /**
    * $_instancia
    * @staticvar Bicharengo
    *
    * Guarda la instancia actual del framework.
    */
    static $_instancia = null;

    /**
    * $_vars
    * @var array
    *
    * Guarda las variables globales dentro del framework.
    */
    protected $_vars = array();

    /**
    * $_rutas
    * @var array
    *
    * Guarda las rutas registradas para el router.
    */
    protected $_rutas = array();

    /**
    * instance
    * @return Bicharengo
    *
    * Genera o obtiene la primera y unica instancia valida de esta clase.
    */
    static function instance(){
        if (self::$_instancia == null) {
            self::$_instancia = new self();
        }
        return self::$_instancia;
    }

    /**
    * instance
    * @param string [$metodo] Método HTTP 
    * @param string [$uri] Uri para enrutar.
    * @param string [$manejador] Manejador para la ruta.
    *
    * Registra una ruta para ser llamada por el enrutador.
    */
    public function route($metodo, $uri, $manejador)
    {
        if(!is_callable($manejador)){
            exit("que es esto?!");
        }
        $metodo = strtoupper($metodo);
        if(!isset($this->_rutas[$metodo]))
            $this->_rutas[$metodo] = array();
        $this->_rutas[$metodo][$uri] = $manejador;
    }

    /**
    * set
    * @param string [$key] nombre de la llave al guardar
    * @param string [$value] Uri para enrutar.
    *
    * Guarda un valor dentro del framework (almacenamiento volatil, no persiste).
    */
    public function set($key, $value)
    {
        $this->_vars[$key] = $value;
    }

    /**
    * get
    * @param string [$key] nombre de la llave al guardar
    * @return mixed
    *
    * Obtiene un valor dentro del framework (almacenamiento volatil, no persiste).
    */
    public function get($key)
    {
        return $this->_vars[$key];
    }

    /**
    * get
    * @param string [$which] superglobal de la cual fijar la entrada.
    * @param string [$key] nombre de la clave
    * @param string [$default_value = null] valor por defecto para usar en caso
    * de no existir la llave en la superglobal
    * @return mixed
    *
    * Obtiene una variable de entrada.
    */
    public function input($which, $key, $default_value = null)
    {
        $superglobal = null;
        switch ($which) {
            case 'get':
                $superglobal = $_GET;
            break;
            case 'post':
                $superglobal = $_POST;
            break;
            case 'request':
                $superglobal = $_REQUEST;
            break;
            case 'cookie':
                $superglobal = $_COOKIE;
            break;
            case 'session':
                $superglobal = $_SESSION;
            break;
            case 'server':
                $superglobal = $_SERVER;
            break;
            default:
                exit("superglobal mala");
            break;
        }

        if (isset($superglobal[$key])) {
            return $superglobal[$key];
        }else{
            return $default_value;
        }
    }

    /**
    * run
    *
    * Ejecuta la aplicacion.
    */
    public function run()
    {
        $path = $_SERVER['PATH_INFO'];
        $metodo = $_SERVER['REQUEST_METHOD'];
        $rutas = $this->_rutas[$metodo];

        if (isset($rutas[$path])) {
            $manejador = $rutas[$path];
            call_user_func_array($manejador, array($this));
            return;
        }

        exit("error 404");
    }
}