<?php
//  $path = $_SERVER['DOCUMENT_ROOT'] . '/RealistaF/RealistaFramework/';
//  include($path . "utils/common.inc.php");
class controller_home{

    static $instance;

    
    function __construct() {}

    static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    function view(){
      // echo ("hola view");
        common::load_view('top_page_home.html', VIEW_PATH_HOME . 'home.html');
    }

    function carrusel() {
        //echo json_encode("patata");
        echo json_encode(common::load_model('home_model', 'get_carrusel'));
        
    }

    function category() {
        echo json_encode(common::load_model('home_model', 'get_category'));
    }
    
    function type() {
        //echo json_encode('Hola');
        echo json_encode(common::load_model('home_model', 'get_type'));
    }
    function city() {
        //echo json_encode('Hola');
        echo json_encode(common::load_model('home_model', 'get_city'));
    }
    function operation() {
        //echo json_encode('Hola');
        echo json_encode(common::load_model('home_model', 'get_operation'));
    }
    function recommend() {
        //echo json_encode('Hola');
        echo json_encode(common::load_model('home_model', 'get_recommend'));
    }
    function visits() {
        //echo json_encode('Hola');
        echo json_encode(common::load_model('home_model', 'get_visits'));
    }
    // function count() {
    //     //echo ("hola count");
    //     echo json_encode(common::load_model('home_model', 'get_count'));
    //   }
    //   function count_shop(){
    //      echo json_encode(common::load_model('home_model', 'get_count_shop',$_POST['filtrosshop']));
    //    // echo("hola!!");
    //   }
    function ahorrov(){
        error_log ("hola ahorro");
       //echo json_encode(common::load_model('search_model', 'get_ahorro_vivienda'));
     }

}


?>