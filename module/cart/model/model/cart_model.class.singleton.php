<?php
    class cart_model {

        private $bll;
        static $_instance;
        
        function __construct() {
            $this -> bll = cart_bll::getInstance();
        }

        public static function getInstance() {
            if (!(self::$_instance instanceof self)) {
                self::$_instance = new self();
            }
            return self::$_instance;
        }

        public function get_list($args){
            return $this -> bll -> get_list_BLL($args);
        }
            
        public function get_count($args){
            return $this -> bll -> get_count_BLL($args);              
        }

        public function get_addtocart($args){
            return $this -> bll -> get_addtocart_BLL($args);
        }
        public function get_update_quantity($args){
            return $this -> bll -> get_update_quantity_BLL($args);
        }
        public function get_delete_item($args){
            return $this -> bll -> get_delete_item_BLL($args);
        }
        public function get_checkout($args){
            return $this -> bll -> get_checkout_BLL($args);
        }
    }
?>