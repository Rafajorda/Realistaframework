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
        function listinvoices(){
            echo json_encode(common::load_model('profile_model', 'get_listinvoices',$_POST['accesstoken']));
          }
        function listlikes(){
            echo json_encode(common::load_model('profile_model', 'get_listlikes',$_POST['accesstoken']));
        }
        function generatepdf(){
            echo json_encode(common::load_model('profile_model', 'get_generatepdf',$_POST['invoiceID']));
        }
        function getUserType(){
            echo json_encode(common::load_model('profile_model', 'get_getUserType',$_POST['accesstoken']));
        }
        function changeUsername(){
            echo json_encode(common::load_model('profile_model', 'get_changeUsername', Array($_POST['newUsername'], $_POST['accesstoken'])));
        }
       
    
    }
    
?>