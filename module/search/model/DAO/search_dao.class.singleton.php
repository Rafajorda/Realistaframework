<?php
	class search_dao{
		static $_instance;

    	private function __construct() {
    	}

    	public static function getInstance() {
        	if(!(self::$_instance instanceof self)){
            	self::$_instance = new self();
        	}
        	return self::$_instance;
    	}
		public function select_ahorro_vivienda($db){
			$sql = "SELECT * FROM ahorro";	
			$stmt = $db -> ejecutar($sql);
			return $db -> listar($stmt);
        }

		public function select_type_vivienda($db){
			$sql = "SELECT * FROM tipo";

			$stmt = $db -> ejecutar($sql);
			return $db -> listar($stmt);
        }

       public function select_type_ahorro_vivienda($db,$ahorro = null) {


            $sql = "SELECT DISTINCT t.idtipo, t.nametipo
                    FROM tipo t
                    INNER JOIN vivienda v ON t.idtipo = v.tipo
                    INNER JOIN ahorro a ON v.ahorro = a.idahorro";
             if ($ahorro !== null && $ahorro !== "0") {
                $sql .= " WHERE a.idahorro = '$ahorro'";
            }
        
			$stmt = $db -> ejecutar($sql);
			return $db -> listar($stmt);
        }



         public function select_only_ahorro($db,$complete, $ahorro){
            $select = "SELECT DISTINCT  c.*
            FROM vivienda v
            JOIN city c ON v.city = c.idcity
            WHERE v.ahorro = '$ahorro' AND c.namecity LIKE '$complete%'";

            
            
            // $retrArray = array();
            // if ($res -> num_rows > 0) {
            //     while ($row = mysqli_fetch_assoc($res)) {
            //         $retrArray[] = $row;
            //     }
            // }
            $stmt = $db -> ejecutar($sql);
			return $db -> listar($stmt);
        }

       public function select_only_type($type, $complete){
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

       public function select_autocomplete($db,$complete, $ahorro, $type) {
            $sql = "SELECT DISTINCT c.*
                       FROM vivienda v
                       JOIN city c ON v.city = c.idcity
                       WHERE c.namecity LIKE '$complete%'";
        
            if ($ahorro !== null) {
                $sql .= " AND v.ahorro = '$ahorro'";
            }
            
            if ($type !== null) {
                $sql .= " AND v.tipo = '$type'";
            }
        
            $stmt = $db -> ejecutar($sql);
			return $db -> listar($stmt);
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
?>