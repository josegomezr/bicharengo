<?php 

/**
* Bicharengo
* @package Bicharengo
*
*/
class Bicharengo
{
    /**
    * __construct
    *
    * Force singleton by making __construct private.
    */
    private function __construct(){}

    /**
    * $_instance
    * @staticvar Bicharengo
    *
    * Storage for our only instance of Bicharengo 
    */
    static $_instance = null;

    /**
    * $_vars
    * @var array
    *
    * This is gonna be our storage for passing data across the app.
    */
    protected $_vars = array();

    /**
    * $_routes
    * @var array
    *
    * Storage for routes
    */
    protected $_routes = array();

    /**
    * build
    * @return Bicharengo
    *
    * Builds up Bicharengo
    */
    static function build(){
        if (self::$_instance == null) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    /**
    * route
    * @param string [$method] HTTP Verb 
    * @param string [$uri] uri pattern to match
    * @param callable [$handler] callable to handle the route.
    *
    * Register a route
    */
    public function route($method, $uri, $handler)
    {
        if (is_callable($handler)) {
            $handler = array('callable', $handler);
        } else if (strstr($handler, '->') === FALSE) {
            $handler = array('instance', $handler);
        } else if (strstr($handler, '::') === FALSE) {
            $handler = array('static', $handler);
        }else{
            exit("not a callable!");
        }

        $method = strtoupper($method);
        
        if(!isset($this->_routes[$method]))
            $this->_routes[$method] = array();
        
        $this->_routes[$method][$uri] = $handler;
    }

    /**
    * set
    * @param string [$key] key name
    * @param string [$value] value to store
    *
    * Store a value, then will be accesible globally within the app
    */
    public function set($key, $value)
    {
        $this->_vars[$key] = $value;
    }

    /**
    * get
    * @param string [$key] nombre de la key al guardar
    * @return mixed
    *
    * Get a value stored withint the app
    */
    public function get($key)
    {
        return $this->_vars[$key];
    }

    /**
    * input
    * @param string [$superglobal] superglobal to look in.
    * @param string [$key] key name
    * @param string [$default = null] default value if key is not present.
    * @return mixed
    *
    * Get an input var.
    */
    public function input($superglobal, $key, $default = null)
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

        if (isset($sg[$key])) {
            return $sg[$key];
        }else{
            return $default;
        }
    }

    /**
    * run
    *
    * Run this app.
    */
    public function run()
    {
        $path = $_SERVER['PATH_INFO'];
        $method = $_SERVER['REQUEST_METHOD'];
        $routes = $this->_routes[$method];

        $handler = null;
        $uri_matches = array();

        if (isset($routes[$path])) {
            $handler = $routes[$path];
        }else{
            $placeholders = array(
                ':string:' => '([a-zA-Z]+)',
                ':num:' => '([0-9]+)',
                ':any:' => '(.*)'
            );

            foreach ($routes as $uri_pattern => $callable) {
                $uri_pattern = strtr($uri_pattern, $placeholders);
                if (preg_match('#^/?' . $uri_pattern . '/?$#', $path, $matches)) {
                    $handler = $callable;
                    $uri_matches = $matches;
                    break;
                }
            }
        }
        if ($handler === null) {
            exit('404');
        }

        $response = null;
        $handler_type = array_shift($handler);
        switch ($handler_type) {
            case 'callable':
            case 'static':
                $response = call_user_func_array($handler, array($this));
                $response = call_user_func_array($handler, array($this));
            break;
            case 'instance':
                $cls = new $handler[0];
                $response = call_user_func_array($handler, array($this));
            break;
        }

        exit($response);
    }
}
