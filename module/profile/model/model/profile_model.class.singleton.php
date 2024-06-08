<?php
    class profile_model {

        private $bll;
        static $_instance;
        
        function __construct() {
            $this -> bll = profile_bll::getInstance();
        }

        public static function getInstance() {
            if (!(self::$_instance instanceof self)) {
                self::$_instance = new self();
            }
            return self::$_instance;
        }

        public function get_listinvoices($args){
            return $this -> bll -> get_listinvoices_BLL($args);
        }
        public function get_listlikes($args){
            return $this -> bll -> get_listlikes_BLL($args);
        } 
        public function get_generatepdf($args){
            return $this -> bll -> get_generatepdf_BLL($args);
        }
        public function get_getUserType($args){
            return $this -> bll -> get_getUserType_BLL($args);
        }
        public function get_changeUsername($args){
            return $this -> bll -> get_changeUsername_BLL($args);
        }   
        public function get_changePassword($args){
            return $this -> bll -> get_changePassword_BLL($args);
        } 
        public function get_changeAvatar($args){
            return $this -> bll -> get_changeAvatar_BLL($args);
        }
        
    }
?>