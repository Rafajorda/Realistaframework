<?php
    class controller_cart {

        static $instance;

        
        function __construct() {}

        static function getInstance() {
            if (self::$instance === null) {
                self::$instance = new self();
            }
            return self::$instance;
        }

        function view() {
           // echo("hola  cart view");
            common::load_view('top_page_cart.html', VIEW_PATH_CART . 'cart.html');
        }
        function list(){
            echo json_encode(common::load_model('cart_model', 'get_list',$_POST['accesstoken']));
          }
        function addtocart(){
            echo json_encode(common::load_model('cart_model', 'get_addtocart', array($_POST['idvivienda'],$_POST['accesstoken'])));
        }
        function count(){
            echo json_encode(common::load_model('cart_model', 'get_count',$_POST['accesstoken']));
        }
        function update_quantity(){
            echo json_encode(common::load_model('cart_model', 'get_update_quantity',array($_POST['accesstoken'],$_POST['idvivienda'],$_POST['quantity'])));
          }
        function delete_item(){
            echo json_encode(common::load_model('cart_model', 'get_delete_item',array($_POST['accesstoken'],$_POST['idvivienda'])));
        }
        function checkout(){
            echo json_encode(common::load_model('cart_model', 'get_checkout',$_POST['accesstoken']));
        }
       
    
    }
    
?>