<?php
class controller_shop{  
    function view(){
      // echo ("hola view");
        common::load_view('top_page_shop.html', VIEW_PATH_SHOP . 'shop.html');
    } 
    function list() {
    //  echo("hola list");
      echo json_encode(common::load_model('shop_model', 'get_list', array($_POST['total_prod'], $_POST['items_page'])));
    }
    function filtershop() {
      //  echo("hola list");
      $filtershop = isset($_POST['filtros']) ? $_POST['filtros'] : null;
        echo json_encode(common::load_model('shop_model', 'get_filtershop', array($filtershop,$_POST['total_prod'], $_POST['items_page'])));
      }
    function details(){
      echo json_encode(common::load_model('shop_model', 'get_details',$_POST['idvivienda']));
    }
    function count(){
      //echo ("hola count");
      echo json_encode(common::load_model('shop_model', 'get_count'));
    }
    function count_shop(){
       echo json_encode(common::load_model('shop_model', 'get_count_shop',$_POST['filtrosshop']));
     // echo("hola!!");
    }
    function ahorro_related() {
      //  echo("hola list");
        echo json_encode(common::load_model('shop_model', 'get_ahorro_related', array($_POST['type'], $_POST['loaded'], $_POST['viviendas'], $_POST['idvivienda'])));
      }
    function extra_vivienda() {
        //  echo("hola list");
        echo json_encode(common::load_model('shop_model', 'get_extra_vivienda', array($_POST['ahorro'],$_POST['idvivienda'])));
      }
    function count_ahorro_related() {
      //  echo("hola list");
       echo json_encode(common::load_model('shop_model', 'get_count_ahorro_related', array($_POST['ahorro'], $_POST['idvivienda'])));
    }
    function likes(){
      echo json_encode(common::load_model('shop_model', 'get_likes',array($_POST['accesstoken'],$_POST['idvivienda'])));
    }
    function addlike(){
      echo json_encode(common::load_model('shop_model', 'get_addlike',array($_POST['accesstoken'],$_POST['idvivienda'])));
    }
    function deletelike(){
      echo json_encode(common::load_model('shop_model', 'get_deletelike',array($_POST['accesstoken'],$_POST['idvivienda'])));
    }
}
?>




