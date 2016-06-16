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
    * __construct
    *
    * Constructor privado para forzar el singleton.
    */
    private function __construct(){}

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
    * Guarda las rutas registradas para el enrutador.
    */
    protected $_rutas = array();

    /**
    * instancia
    * @return Bicharengo
    *
    * Genera o obtiene la primera y unica instancia valida de esta clase.
    */
    static function instancia(){
        if (self::$_instancia == null) {
            self::$_instancia = new self();
        }
        return self::$_instancia;
    }

    /**
    * ruta
    * @param string [$metodo] Verbo HTTP 
    * @param string [$uri] Uri para enrutar.
    * @param callable [$manejador] Manejador para la ruta.
    *
    * Registra una ruta para ser llamada por el enrutador.
    */
    public function ruta($metodo, $uri, $manejador)
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
    * @param string [$clave] nombre de la clave al guardar
    * @param string [$valor] Uri para enrutar.
    *
    * Guarda un valor dentro del framework (almacenamiento volatil, no persiste).
    */
    public function set($clave, $valor)
    {
        $this->_vars[$clave] = $valor;
    }

    /**
    * get
    * @param string [$clave] nombre de la clave al guardar
    * @return mixed
    *
    * Obtiene un valor dentro del framework (almacenamiento volatil, no persiste).
    */
    public function get($clave)
    {
        return $this->_vars[$clave];
    }

    /**
    * get
    * @param string [$superglobal] superglobal de la cual fijar la entrada.
    * @param string [$clave] nombre de la clave
    * @param string [$valor_defecto = null] valor por defecto para usar en caso
    * de no existir la clave en la superglobal
    * @return mixed
    *
    * Obtiene una variable de entrada.
    */
    public function entrada($superglobal, $clave, $valor_defecto = null)
    {
        $sg = null;
        switch ($superglobal) {
            case 'get':
                $sg = $_GET;
            break;
            case 'post':
                $sg = $_POST;
            break;
            case 'request':
                $sg = $_REQUEST;
            break;
            case 'cookie':
                $sg = $_COOKIE;
            break;
            case 'session':
                $sg = $_SESSION;
            break;
            case 'server':
                $sg = $_SERVER;
            break;
            default:
                exit("superglobal mala");
            break;
        }

        if (isset($sg[$clave])) {
            return $sg[$clave];
        }else{
            return $valor_defecto;
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