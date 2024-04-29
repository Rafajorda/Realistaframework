<?php
	$path = $_SERVER['DOCUMENT_ROOT'] . '/realistaframework';
	include($path . "/model/connect.php");
    
	class DAOSearch {
		function select_type_vivienda(){
			$sql = "SELECT * FROM tipo";

			$conexion = connect::con();
            $res = mysqli_query($conexion, $sql);
            connect::close($conexion);
            return $res;
        }
        function select_ahorro_vivienda(){
			$sql = "SELECT * FROM ahorro";

			$conexion = connect::con();
            $res = mysqli_query($conexion, $sql);
            connect::close($conexion);
            return $res;
        }

        function select_type_ahorro($ahorro = null) {


            $sql = "SELECT DISTINCT t.idtipo, t.nametipo
                    FROM tipo t
                    INNER JOIN vivienda v ON t.idtipo = v.tipo
                    INNER JOIN ahorro a ON v.ahorro = a.idahorro";
             if ($ahorro !== null && $ahorro !== "0") {
                $sql .= " WHERE a.idahorro = '$ahorro'";
            }
        
            $conexion = connect::con();
            $res = mysqli_query($conexion, $sql);
            connect::close($conexion);
        
            return $res;
        }



        function select_only_ahorro($complete, $ahorro){
            $select = "SELECT DISTINCT  c.*
            FROM vivienda v
            JOIN city c ON v.city = c.idcity
            WHERE v.ahorro = '$ahorro' AND c.namecity LIKE '$complete%'";

            $conexion = connect::con();
            $res = mysqli_query($conexion, $select);
            connect::close($conexion);
            
            $retrArray = array();
            if ($res -> num_rows > 0) {
                while ($row = mysqli_fetch_assoc($res)) {
                    $retrArray[] = $row;
                }
            }
            return $retrArray;
        }

        function select_only_type($type, $complete){
            $select = "SELECT DISTINCT  c.*
               FROM vivienda v
               JOIN city c ON v.city = c.idcity
               WHERE v.tipo = '$type' AND c.namecity LIKE '$complete%'";

            
            $conexion = connect::con();
            $res = mysqli_query($conexion, $select);
            connect::close($conexion);
            
            $retrArray = array();
            if ($res -> num_rows > 0) {
                while ($row = mysqli_fetch_assoc($res)) {
                    $retrArray[] = $row;
                }
            }
            return $retrArray;
        }

        function select_ahorro_type($complete, $ahorro, $type) {
            $select = "SELECT DISTINCT c.*
                       FROM vivienda v
                       JOIN city c ON v.city = c.idcity
                       WHERE c.namecity LIKE '$complete%'";
        
            if ($ahorro !== null) {
                $select .= " AND v.ahorro = '$ahorro'";
            }
            
            if ($type !== null) {
                $select .= " AND v.tipo = '$type'";
            }
        
            $conexion = connect::con();
            $res = mysqli_query($conexion, $select);
            connect::close($conexion);
            
            $retrArray = array();
            if ($res->num_rows > 0) {
                while ($row = mysqli_fetch_assoc($res)) {
                    $retrArray[] = $row;
                }
            }
            return $retrArray;
        }






        function select_city($complete){
            $select = "SELECT DISTINCT  c.*
            FROM vivienda v
            JOIN city c ON v.city = c.idcity
            WHERE c.namecity LIKE '$complete%'";
            
            $conexion = connect::con();
            $res = mysqli_query($conexion, $select);
            connect::close($conexion);
            
            $retrArray = array();
            if ($res -> num_rows > 0) {
                while ($row = mysqli_fetch_assoc($res)) {
                    $retrArray[] = $row;
                }
            }
            return $retrArray;
        }
    



	}
