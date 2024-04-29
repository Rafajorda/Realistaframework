<?php
$path = $_SERVER['DOCUMENT_ROOT'] . '/realistaV13';
include($path . "/module/search/model/DAO_search.php");
@session_start();
if (isset($_SESSION["tiempo"])) {  
    $_SESSION["tiempo"] = time(); //Devuelve la fecha actual
 } 
switch ($_GET['op']) {
    case 'type_vivienda':
        try {
            $dao = new DAOSearch();
            $rdo = $dao->select_type_vivienda();
        } catch (Exception $e) {
            echo json_encode("error");
            exit;
        }
        if (!$rdo) {
            echo json_encode("error");
            exit;
        } else {
            $dinfo = array();
            foreach ($rdo as $row) {
                array_push($dinfo, $row);
            }
            echo json_encode($dinfo);
        }
        break;
        case 'ahorro_vivienda':
            try {
                $dao = new DAOSearch();
                $rdo = $dao->select_ahorro_vivienda();
            } catch (Exception $e) {
                echo json_encode("error");
                exit;
            }
            if (!$rdo) {
                echo json_encode("error");
                exit;
            } else {
                $dinfo = array();
                foreach ($rdo as $row) {
                    array_push($dinfo, $row);
                }
                echo json_encode($dinfo);
            }
            break;
        case 'type_ahorro_vivienda':
                try {
                    $dao = new DAOSearch();
                    if (isset($_POST['ahorro'])) {
                        $rdo = $dao->select_type_ahorro($_POST['ahorro']);
                    } else {
                        $rdo = $dao->select_type_ahorro();
                    }
                    
                } catch (Exception $e) {
                    echo json_encode("error");
                    exit;
                }
                if (!$rdo) {
                    echo json_encode("error");
                    exit;
                } else {
                    $dinfo = array();
                    foreach ($rdo as $row) {
                        array_push($dinfo, $row);
                    }
                    echo json_encode($dinfo);
                }
                break;

  
    case 'brand_category':
        try {
            $dao = new DAOSearch();
            $rdo = $dao->select_motor_brand($_POST['motor']);
        } catch (Exception $e) {
            echo json_encode("error");
            exit;
        }
        if (!$rdo) {
            echo json_encode("error");
            exit;
        } else {
            $dinfo = array();
            foreach ($rdo as $row) {
                array_push($dinfo, $row);
            }
            echo json_encode($dinfo);
        }
        break;

    case 'autocomplete':
        try {
            $dao = new DAOSearch();
            
            $type = isset($_POST['type']) ? $_POST['type'] : null;
            $ahorro = isset($_POST['ahorro']) ? $_POST['ahorro'] : null;
         //   echo json_encode($type , $ahorro );
            $rdo = $dao->select_ahorro_type($_POST['complete'], $ahorro, $type);
           
        } catch (Exception $e) {
            echo json_encode("error");
            exit;
        }
        if (!$rdo) {
            echo json_encode("error");
            exit;
        }  else {
            $dinfo = array();
            foreach ($rdo as $row) {
                array_push($dinfo, $row);
            }
            echo json_encode($dinfo);
        }
        break;

    default:
        include("view/inc/error/error404.php");
        break;
}
