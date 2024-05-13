<?php
    class controller_search{  
       function type_vivienda(){
         // echo ("hola view");
      //   echo json_encode(common::load_model('search_model', 'get_type_vivienda'));
       }
      function ahorrov(){
       // echo("hola ahorro");
        echo json_encode(common::load_model('search_model', 'get_ahorro_vivienda'));
      }
      function type_ahorro_vivienda(){
       //  echo ("hola ahorro vivienda");
      $ahorro = isset($_POST['ahorro']) ? $_POST['ahorro'] : null;
        echo json_encode(common::load_model('search_model', 'get_type_ahorro_vivienda',$ahorro));
      }
      
    //   function autocomplete(){
    //    $ahorro = isset($_POST['ahorro']) ? $_POST['ahorro'] : null;

    //     // echo ("hola autocomplete");
    //    echo json_encode(common::load_model('search_model', 'get_autocomplete'.$ahorro));
    //   }

    public function autocomplete() {
      //  $array = $_POST['array'] ?? [];
        echo json_encode(common::load_model('search_model', 'get_autocomplete',$_POST['array']));
    }

    }
?>