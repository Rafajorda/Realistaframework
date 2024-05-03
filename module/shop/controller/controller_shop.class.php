<?php
class controller_shop{  
    function view(){
      // echo ("hola view");
        common::load_view('top_page_shop.html', VIEW_PATH_SHOP . 'shop.html');
    }
}
?>

<!-- 


// $path = $_SERVER['DOCUMENT_ROOT'] . '/realistaframework';
// include($path . "/module/shop/model/DAO_shop.php");
// include($path . "/model/middleware_auth.php");
// @session_start();
// if (isset($_SESSION["tiempo"])) {  
//     $_SESSION["tiempo"] = time(); //Devuelve la fecha actual
// } 
// switch ($_GET['op']) {
//     case 'list':
//         include('module/shop/view/shop.html');
//         break;

//     case 'all_vivienda':

//         try {
//             $daoshop = new DAOShop();
//             $items_page = 3;
//             $Dates_vivienda = $daoshop->select_all_vivienda($_POST['total_prod'],$items_page);
//         } catch (Exception $e) {
//             echo json_encode("error");
//         }

//         if (!empty($Dates_vivienda)) {
//             echo json_encode($Dates_vivienda);
//         } else {
//             echo json_encode("error");
//         }
//         break;

//     case 'details_vivienda':
//         try {
//             $daoshop = new DAOShop();
//             $Date_vivienda = $daoshop->select_one_vivienda($_GET['id']);
//         } catch (Exception $e) {
//             echo json_encode("error");
//         }
//         // try {
//         //     $daoshop_img = new DAOShop();
//         //     $Date_images = $daoshop_img->select_imgs_vivienda($_GET['idvivienda']);
//         // } catch (Exception $e) {
//         //     echo json_encode("error");
//         // }

//         if (!empty($Date_vivienda)) {
//             $rdo = array();
//             $rdo[0] = $Date_vivienda;
//           //  $rdo[1][] = $Date_images;
//             echo json_encode($rdo);
//         } else {
//             echo json_encode("error");
//         }
//         break;


//     case 'filtershome_vivienda':
//             $homeQuery = new DAOShop();
//             $selSlide = $homeQuery -> filtershome_vivienda($_POST['filtros']);
//             if (!empty($selSlide)) {
//                 echo json_encode($selSlide);
//             }
//             else {
//                 echo "error";
//             }
            
//         break;


//     case 'filtershop':
//             $homeQuery = new DAOShop();
//             $filtershop = isset($_POST['filtros']) ? $_POST['filtros'] : null;
//             $total_prod = isset($_POST['total_prod']) ? $_POST['total_prod'] : null;
//             $items_page = 3;
           
//             $selSlide = $homeQuery -> filtersshop($filtershop,$total_prod,$items_page);
//             if (!empty($selSlide)) {
//                 echo json_encode($selSlide);
//             }
//             else {
//                 echo json_encode([]);       
//             }
//         break;

//      case 'filtersearch':
//                 $homeQuery = new DAOShop();
//                 $selSlide = $homeQuery -> filtersearch($_POST['filtros']);
//                 if (!empty($selSlide)) {
//                     echo json_encode($selSlide);
//                 }
//                 else {
//                     echo "error";
//                 }
//             break;

//      case 'count';    
//                 $homeQuery = new DAOShop();
//                 $selSlide = $homeQuery -> select_count();
//                 if (!empty($selSlide)) {
//                     echo json_encode($selSlide);
//                 }
//                 else {
//                   echo "error";
//                 }
//             break;
    
//         // case 'count_filters';    
//         //     $homeQuery = new DAOShop();
//         //     $selSlide = $homeQuery -> select_count_filter($_POST['filter']);
//         //     if (!empty($selSlide)) {
//         //         echo json_encode($selSlide);
//         //     }
//         //     else {
//         //         echo "error";
//         //     }
//         //     break;
    
//         case 'count_shop';    
//             $homeQuery = new DAOShop();
//             $selSlide = $homeQuery -> count_shop($_POST['filtrosshop']);
//             if (!empty($selSlide)) {
//                 echo json_encode($selSlide);
//             }
//             else {
//                 echo "error";
//             }
//             break;
        
//         // case 'count_search';    
//         //     $homeQuery = new DAOShop();
//         //     $selSlide = $homeQuery -> count_search($_POST['filters_search']);
//         //     if (!empty($selSlide)) {
//         //         echo json_encode($selSlide);
//         //     }
//         //     else {
//         //         echo "error";
//         //     }
//         //     break;
//         case 'count_ahorro_related':
//             error_log(print_r($_POST, true)); // Log $_POST array

//             $ahorro = $_POST['ahorro'];
//             $idvivienda = $_POST['idvivienda'];
//             try {
//                 $dao = new DAOShop();
//                 $rdo = $dao->count_more_ahorro_related($ahorro,$idvivienda);
//             } catch (Exception $e) {
//                 echo json_encode("error");
//                 exit;
//             }
//             if (!$rdo) {
//                 echo json_encode("error");
//                 exit;
//             } else {
//                 $dinfo = array();
//                 foreach ($rdo as $row) {
//                     array_push($dinfo, $row);
//                 }
//                 echo json_encode($dinfo);
//             }
//             break;
//             case 'ahorro_related':
//                 $ahorro = $_POST['type'];
//                 $loaded =  $_POST['loaded'];
//                 $viviendas =  $_POST['viviendas'];
//                 $idvivienda = $_POST['idvivienda'];
//                 try {
//                     $dao = new DAOShop();
//                     $rdo = $dao->select_ahorro_related($ahorro, $loaded, $viviendas,$idvivienda);
//                 } catch (Exception $e) {
//                     echo json_encode("error");
//                     exit;
//                 }
//                 if (!$rdo) {
//                     echo json_encode("error");
//                     exit;
//                 } else {
//                     $dinfo = array();
//                     foreach ($rdo as $row) {
//                         array_push($dinfo, $row);
//                     }
//                     echo json_encode($dinfo);
//                 }
//                 break;


//                 case 'extra_vivienda':
//                     $ahorro = $_POST['ahorro'];
//                     $vivienda =  $_POST['idvivienda'];
//                     try {
//                         $dao = new DAOShop();
//                         $rdo = $dao->select_extra_vivienda($ahorro,$vivienda);
//                     } catch (Exception $e) {
//                         echo json_encode("error");
//                         exit;
//                     }
//                     if (!$rdo) {
//                         echo json_encode("error");
//                         exit;
//                     } else {
//                         $dinfo = array();
//                         foreach ($rdo as $row) {
//                             array_push($dinfo, $row);
//                         }
//                         echo json_encode($dinfo);
//                     }
//                     break;
//                 case'likes':
//                     $json = decode_token($_POST['accesstoken']);
//                     try {
//                         $dao = new DAOShop();
//                         $rdo = $dao->likes($_POST['idvivienda'],$json['id']);
//                         echo json_encode($rdo);
//                     } catch (Exception $e) {
//                         echo json_encode(array("error" => "error2"));
//                     // echo json_encode("error2");
//                     // exit;
//                 }
//                 // if (!$rdo) {
//                 //     echo json_encode("error1");
//                 //     exit;
//                 // } else {               
//                 //     echo json_encode($rdo);
//                 // }
//                     break;
//                 case'addlike':
//                     $json = decode_token($_POST['accesstoken']);
//                     try {
//                         $dao = new DAOShop();
//                         $rdo = $dao->addlike($_POST['idvivienda'],$json['id']);
//                         echo json_encode($rdo);
//                     } catch (Exception $e) {
//                         echo json_encode(array("error" => "error2"));
//                     // echo json_encode("error2");
//                     // exit;
//                     }

//                     break;
//                 case'deletelike':
//                     $json = decode_token($_POST['accesstoken']);
//                     try {
//                         $dao = new DAOShop();
//                         $rdo = $dao->deletelike($_POST['idvivienda'],$json['id']);
//                         echo json_encode($rdo);
//                     } catch (Exception $e) {
//                         echo json_encode(array("error" => "error2"));
//                     // echo json_encode("error2");
//                     // exit;
//                     }

//                     break;


//     default;
//        // include("module/exceptions/views/pages/error404.php");
//         break;
// } -->
