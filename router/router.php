<?php

    require_once 'autoload.php';
    
    //  $path = $_SERVER['DOCUMENT_ROOT'] . '/';
    // include($path . "utils/common.inc.php");
    // include($path . "utils/mail.inc.php");
   // include($path . "paths.php");

    // ob_start();
    session_start();
    class router {
        private $uriModule;
        private $uriFunction;
        private $nameModule;
        static $_instance;
        
        public static function getInstance() {  /// Crea el constructor si no exixte
            if (!(self::$_instance instanceof self)) {
                self::$_instance = new self();
            }
            return self::$_instance;
        }
    
        function __construct() {   
            if(isset($_GET['module'])){
                $this -> uriModule = $_GET['module'];
            }else{
                $this -> uriModule = 'view';
            }
            if(isset($_POST['op'])){
                $this -> uriFunction = $_POST['op'];
            }else{
               if(isset($_GET['op'])){
                    if($_GET['op']==='verify'|$_GET['op']==='recover'){
                        $this -> uriFunction = 'view';
                    }else{
                         $this -> uriFunction = ($_GET['op'] === "") ? 'view' : $_GET['op'];
                    }
                }else{
                    $this -> uriFunction = 'view';
                }
            }
        }
    
        function routingStart() {
            try {
                call_user_func(array($this -> loadModule(), $this -> loadFunction()));
            }catch(Exception $e) {
                common::load_error();
            }
        }
        
        private function loadModule() {
            if (file_exists('resources/modules.xml')) {
                $modules = simplexml_load_file('resources/modules.xml');
                foreach ($modules as $row) {
                    if (in_array($this -> uriModule, (Array) $row -> uri)) {
                        $path = MODULES_PATH . $row -> name . '/controller/controller_' . (String) $row -> name . '.class.singleton.php';
                        if (file_exists($path)) {
                            require_once($path);
                            $controllerName = 'controller_' . (String) $row -> name;
                            $this -> nameModule = (String) $row -> name;
                            //return $controllerName::getInstance();
                            if (method_exists($controllerName, 'getInstance')) {
                                
                                return $controllerName::getInstance();
                            } else {
                                
                                return new $controllerName;
                            }
                            
                        }
                    }
                }
            }
            throw new Exception('Not Module found.');
        }   

      
        private function loadFunction() {
            $path = MODULES_PATH . $this -> nameModule . '/resources/function.xml'; 
            if (file_exists($path)) {
                $functions = simplexml_load_file($path);
                foreach ($functions as $row) {
                    if (in_array($this -> uriFunction, (Array) $row -> uri)) {
                        // $functionName = (string) $row->name;
                        // echo "<script>console.log('Function Loaded: " . $functionName . "');</script>";

                        return (String) $row -> name;
                    }
                }
            }
            throw new Exception('Not Function found.');
            return (String) 'view';
        }

    }
    
    router::getInstance() -> routingStart();

    //echo 'hola';
