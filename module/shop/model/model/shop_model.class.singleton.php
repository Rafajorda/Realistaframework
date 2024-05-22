<?php
    class shop_model {

        private $bll;
        static $_instance;
        
        function __construct() {
            $this -> bll = shop_bll::getInstance();
        }

        public static function getInstance() {
            if (!(self::$_instance instanceof self)) {
                self::$_instance = new self();
            }
            return self::$_instance;
        }

        public function get_list($args) {
            return $this -> bll -> get_list_BLL($args);
        }
        public function get_count() {
            return $this -> bll -> get_count_BLL();
        }
        public function get_count_shop($args) {
            return $this -> bll -> get_count_shop_BLL($args);
        }
        public function get_filtershop($args) {
            return $this -> bll -> get_filtershop_BLL($args);
        }
       public function get_details($args){
        return $this -> bll -> get_details_BLL($args);
       }
       public function get_ahorro_related($args){
        return $this -> bll -> get_ahorro_related_BLL($args);
       }
       public function get_count_ahorro_related($args){
        return $this -> bll -> get_count_ahorro_related_BLL($args);
       }
       public function get_extra_vivienda($args){
        return $this -> bll -> get_extra_vivienda_BLL($args);
       }
       public function get_likes($args) {
        return $this -> bll -> get_likes_BLL($args);
        }
        public function get_addlike($args) {
            return $this -> bll -> get_addlike_BLL($args);
        }
        public function get_deletelike($args) {
            return $this -> bll -> get_deletelike_BLL($args);
        }

    }
?>