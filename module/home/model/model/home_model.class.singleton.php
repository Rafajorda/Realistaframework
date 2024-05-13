<?php
    class home_model {

        private $bll;
        static $_instance;
        
        function __construct() {
            $this -> bll = home_bll::getInstance();
        }

        public static function getInstance() {
            if (!(self::$_instance instanceof self)) {
                self::$_instance = new self();
            }
            return self::$_instance;
        }

        public function get_carrusel() {
            return $this -> bll -> get_carrusel_BLL();
        }

        public function get_category() {
            return $this -> bll -> get_category_BLL();
        }

        public function get_type() {
           // return 'hola type';
            return $this -> bll -> get_type_BLL();
        }

        public function get_city() {
            // return 'hola type';
             return $this -> bll -> get_city_BLL();
        }

        public function get_operation() {
            // return 'hola type';
             return $this -> bll -> get_operation_BLL();
         }

         public function get_recommend() {
            // return 'hola type';
             return $this -> bll -> get_recommend_BLL();
         }

         public function get_visits() {
            // return 'hola type';
             return $this -> bll -> get_visits_BLL();
         }

        //  public function get_count() {
        //     return $this -> bll -> get_count_BLL();
        // }
        // public function get_count_shop($args) {
        //     return $this -> bll -> get_count_shop_BLL($args);
        // }

    }
?>