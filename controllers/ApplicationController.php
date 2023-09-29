<?php

/**
 * Cette classe est le contrôleur frontal de l'application.
 * Elle permet de définir les routes de l'application et de
 * déterminer le contrôleur à appeler pour chaque requête.
 */
class ApplicationController{
    private static $instance;
    private $routes;

    /**
     * Constructeur privé de la classe ApplicationController.
     * Ce constructeur initialise les routes principales de l'application. (index et error)
     */
    private function __construct(){
        $this->routes = [
            '/' => CONTROLLERS_DIR.'/index.php',
            'error' => CONTROLLERS_DIR.'/error.php'
        ];
    }

    /**
     * Retourne l'instance unique de cette classe.
     * @return ApplicationController l'instance unique de cette classe.
     */
    public static function getInstance(){
        if(!isset(self::$instance)){
            self::$instance = new ApplicationController;
        }
        return self::$instance;
    }

    /**
     * Ajoute une nouvelle route à l'application.
     * @param String $path l'url de la route à ajouter.
     * @param String $ctrl le chemin du contrôleur à appeler pour cette route, qui recevra la requête.
     */
    public function addRoute($path, $ctrl){
        $filePath = $ctrl;
        // Si le chemin du contrôleur ne se termine pas par .php, on le rajoute
        if(!str_ends_with($ctrl, '.php')){
            $filePath = $filePath.".php";
        }
        // Si le chemin existe, on l'ajoute au tableau des routes
        if(file_exists($filePath)){
            $this->routes[$path] = $filePath;
        }
    }

    /**
     * Retourne le chemin de la route correspondant à la requête actuelle.
     * @return string chemin de la route correspondant à la requête actuelle.
     */
    private function requestPath(){
        $request_uri = explode('/', trim($_SERVER['REQUEST_URI'], '/'));
        $script_name = explode('/', trim($_SERVER['SCRIPT_NAME'], '/'));
        
        $parts = array_diff_assoc($request_uri, $script_name);
        if (empty($request_uri[0]))
        {
            return '/';
        }
        $path = implode('/', $parts);
        if (($position = strpos($path, '?')) !== FALSE)
        {
            $path = substr($path, 0, $position);
        }
        return $path;
    }

    /**
     * Retourne les classes PHP contenues dans le code PHP passé en paramètre.
     * @param String $php_code le code PHP dont on veut récupérer les classes.
     * @return array tableau contenant les classes PHP contenues dans le code PHP passé en paramètre.
     */
    private function getPhpClasses($php_code) {
        $classes = array();
        $tokens = token_get_all($php_code);
        $count = count($tokens);
        for ($i = 2; $i < $count; $i++) {
            if ($tokens[$i - 2][0] == T_CLASS
                && $tokens[$i - 1][0] == T_WHITESPACE
                && $tokens[$i][0] == T_STRING) {

                $class_name = $tokens[$i][1];
                $classes[] = $class_name;
            }
        }
        return $classes;
    }

    /**
     * Retourne les classes PHP contenues dans le fichier PHP passé en paramètre.
     * @param String $filepath le chemin du fichier PHP dont on veut récupérer les classes.
     * @return array tableau contenant les classes PHP contenues dans le fichier PHP passé en paramètre.
     */
    private function fileGetPhpClasses($filepath) {
        $php_code = file_get_contents($filepath);
        return $this->getPhpClasses($php_code);
    }


    /**
     * Exécute la route correspondant à la requête actuelle.
     * Si la route n'existe pas, la route error est exécutée.
     */
    public function process(){
        $path = $this->requestPath();
        if (array_key_exists($path, $this->routes)){
            $filePath = $this->routes[$path];
            if(!str_ends_with($filePath, '.php')){
                $filePath = $filePath.".php";
            }
            
            require_once $filePath;
            $ctrl_class = $this->fileGetPhpClasses($filePath)[0];
            $controller = new $ctrl_class();
            switch ($_SERVER['REQUEST_METHOD']) {
                case 'GET': {
                    $controller->get($_REQUEST);
                    break;
                }
                case 'POST': {
                    $controller->post($_REQUEST);
                    break;
                }
                
                default:
                    $controller->get($_REQUEST);
                    break;
            }
        } else {
            require_once VIEWS_DIR.'/404.php';
        }
    }

}

