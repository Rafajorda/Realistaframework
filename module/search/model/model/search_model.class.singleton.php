<?php
    class search_model {

        private $bll;
        static $_instance;
        
        function __construct() {
            $this -> bll = search_bll::getInstance();
        }

        public static function getInstance() {
            if (!(self::$_instance instanceof self)) {
                self::$_instance = new self();
            }
            return self::$_instance;
        }

        public function get_type_vivienda() {
            return $this -> bll -> get_type_vivienda_BLL();
        }

        public function get_ahorro_vivienda() {
            return $this -> bll -> get_ahorro_vivienda_BLL();
        }

        public function get_type_ahorro_vivienda($args=null) {
           // return 'hola type';
            return $this -> bll -> get_type_ahorro_vivienda_BLL($args);
        }
        public function get_autocomplete($args) {
            // return $args;
             return $this -> bll -> get_autocomplete_BLL($args);
         }


    }
?>