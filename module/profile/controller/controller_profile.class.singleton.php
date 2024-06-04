<?php
    class controller_profile {

        static $instance;

        
        function __construct() {}

        static function getInstance() {
            if (self::$instance === null) {
                self::$instance = new self();
            }
            return self::$instance;
        }

        function view() {
           // echo("hola  profile view");
            common::load_view('top_page_profile.html', VIEW_PATH_PROFILE . 'profile.html');
        }
        
       
    
    }
    
?>