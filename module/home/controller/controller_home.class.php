<?php
//  $path = $_SERVER['DOCUMENT_ROOT'] . '/RealistaF/RealistaFramework/';
//  include($path . "utils/common.inc.php");
class controller_home{
    
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

}


//     // $data = 'hola crtl vivienda';
//    //  die('<script>console.log('.json_encode( $data ) .');</script>');
//    $path = $_SERVER['DOCUMENT_ROOT'] . '/realistaframework';
//    include($path . "/module/home/model/DAOVivienda.php");
//    // include ("module/vivienda/model/DAOVivienda.php");
//     @session_start();
//     if (isset($_SESSION["tiempo"])) {  
//         $_SESSION["tiempo"] = time(); //Devuelve la fecha actual
//     } 
    
//     switch($_GET['op']){
    
//         case 'homePageCategory':
//                 header('Content-Type: application/json');
            
//                 try {
//                     $daovivienda = new DAOVivienda();
//                     $selectCategory = $daovivienda->select_categories();

            
//                     if (!empty($selectCategory)) {
//                         echo json_encode($selectCategory);
//                     } else {
//                         echo json_encode(array("error" => "No categories found"));
//                     }
//                 } catch (Exception $e) {
//                     http_response_code(500); // Internal Server Error
//                      error_log("Error in homePageCategory: " . $e->getMessage());
//                      echo json_encode(array("error" => "Internal Server Error"));
//                 }
            
//                 break;


//             case 'homePagerecommend':
//                     header('Content-Type: application/json');
                
//                     try {
//                         $daovivienda = new DAOVivienda();
//                         $selectrecommend = $daovivienda->select_recommend();
    
                
//                         if (!empty($selectrecommend)) {
//                             echo json_encode($selectrecommend);
//                         } else {
//                             echo json_encode(array("error" => "No categories found"));
//                         }
//                     } catch (Exception $e) {
//                         http_response_code(500); // Internal Server Error
//                          error_log("Error in homePagerecomend: " . $e->getMessage());
//                          echo json_encode(array("error" => "Internal Server Error"));
//                     }
                
//                     break;

//         case 'homePageType':
//                     header('Content-Type: application/json');
                
//                     try {
//                         $daovivienda = new DAOVivienda();
//                         $selectType = $daovivienda->select_Types();
    
                
//                         if (!empty($selectType)) {
//                             echo json_encode($selectType);
//                         } else {
//                             echo json_encode(array("error" => "No typesfound"));
//                         }
//                     } catch (Exception $e) {
//                         http_response_code(500); // Internal Server Error
//                          error_log("Error in homePageCategory: " . $e->getMessage());
//                          echo json_encode(array("error" => "Internal Server Error"));
//                     }
                
//                     break;

//         case 'homePageCity':
//                         header('Content-Type: application/json');
                    
//                         try {
//                             $daovivienda = new DAOVivienda();
//                             $selectCity = $daovivienda->select_city();
        
                    
//                             if (!empty($selectCity)) {
//                                 echo json_encode($selectCity);
//                             } else {
//                                 echo json_encode(array("error" => "No cities found"));
//                             }
//                         } catch (Exception $e) {
//                             http_response_code(500); // Internal Server Error
//                              error_log("Error in homePageCity: " . $e->getMessage());
//                              echo json_encode(array("error" => "Internal Server Error"));
//                         }
                    
//                         break;
//         case 'homePageOperation':
//                         header('Content-Type: application/json');
                    
//                         try {
//                             $daovivienda = new DAOVivienda();
//                             $selectCategory = $daovivienda->select_operations();
        
                    
//                             if (!empty($selectCategory)) {
//                                 echo json_encode($selectCategory);
//                             } else {
//                                 echo json_encode(array("error" => "No operation found"));
//                             }
//                         } catch (Exception $e) {
//                             http_response_code(500); // Internal Server Error
//                              error_log("Error in homePageoperation: " . $e->getMessage());
//                              echo json_encode(array("error" => "Internal Server Error"));
//                         }
                    
//                 break;
//         case 'homePageAhorro':
//                             header('Content-Type: application/json');
                        
//                             try {
//                                 $daovivienda = new DAOVivienda();
//                                 $selectCategory = $daovivienda->select_ahorro();
            
                        
//                                 if (!empty($selectCategory)) {
//                                     echo json_encode($selectCategory);
//                                 } else {
//                                     echo json_encode(array("error" => "No operation found"));
//                                 }
//                             } catch (Exception $e) {
//                                 http_response_code(500); // Internal Server Error
//                                  error_log("Error in homePageahorro: " . $e->getMessage());
//                                  echo json_encode(array("error" => "Internal Server Error"));
//                             }
                        
//                             break;
//         case 'homePageVisitas':
//                             try {
//                                 $daovivienda = new DAOVivienda();
//                                 $Dates_vivienda = $daovivienda->select_visitas();
//                             } catch (Exception $e) {
//                                 echo json_encode("error");
//                             }
                        
//                             if (!empty($Dates_vivienda)) {
//                                     echo json_encode($Dates_vivienda);
//                             } else {
//                                     echo json_encode("error");
//                             }
//                                 break;
//         case 'homePagebusqueda':
//             try {
//                 $daovivienda = new DAOVivienda();
//                 $Dates_vivienda = $daovivienda->select_busqueda($_POST['busqueda']);
//                     } catch (Exception $e) {
//                         echo json_encode("error");
//                     }
                            
//                     if (!empty($Dates_vivienda)) {
//                             echo json_encode($Dates_vivienda);
//                     } else {
//                         echo json_encode("error");
//                     }
//             break;
        


                        
                        

//         default;
//                 include("view/inc/error404.php");
//                 break;
//     }

?>