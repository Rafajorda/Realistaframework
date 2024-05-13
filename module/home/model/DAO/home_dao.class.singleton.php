<?php
	class home_dao{
		static $_instance;

    	private function __construct() {
    	}

    	public static function getInstance() {
        	if(!(self::$_instance instanceof self)){
            	self::$_instance = new self();
        	}
        	return self::$_instance;
    	}

		public function select_data_carrusel($db) {
	
			 $sql= "SELECT *FROM ahorro";
			
			$stmt = $db -> ejecutar($sql);
			return $db -> listar($stmt);
	
		}

		public function select_data_category($db) {
	
				$sql= "SELECT *FROM categoria";

			$stmt = $db -> ejecutar($sql);
			return $db -> listar($stmt);
			
		}

		public function select_data_type($db){
			$sql= "SELECT *FROM tipo";

			$stmt = $db -> ejecutar($sql);
			return $db -> listar($stmt);
		}

		public function select_data_city($db){
			$sql= "SELECT *FROM city";

			$stmt = $db -> ejecutar($sql);
			return $db -> listar($stmt);
		}

		public function select_data_operation($db){
		$sql= "SELECT *FROM operation";

		$stmt = $db -> ejecutar($sql);
		return $db -> listar($stmt);
		}

		public function select_data_recommend($db) {
		
		$sql= "SELECT tabla, id, name, img, visit
		FROM (
			SELECT 'categoria' AS tabla, idcat AS id, namecat AS name, imgcat AS img, visit
			FROM categoria
			UNION ALL
			SELECT 'city' AS tabla, idcity AS id, namecity AS name, imgcity AS img, visit
			FROM city
			UNION ALL
			SELECT 'tipo' AS tabla, idtipo AS id, nametipo AS name, imgtipo AS img, visit
			FROM tipo
		) AS all_tables
		ORDER BY visit DESC
		LIMIT 4";

		$stmt = $db -> ejecutar($sql);
		return $db -> listar($stmt);
		
		}


		public function select_busqueda($busqueda,$db) {
		
			$sql = "SELECT tabla, id, name, img FROM (";

			for ($i = 0; $i < count($busqueda); $i++) {
				switch ($busqueda[$i][0]) {
					case "categoria":
						$sql .= "SELECT 'categoria' AS tabla, idcat AS id, namecat AS name, imgcat AS img FROM categoria WHERE idcat = {$busqueda[$i][1]}";
						break;
					case "city":
						$sql .= "SELECT 'city' AS tabla, idcity AS id, namecity AS name, imgcity AS img FROM city WHERE idcity = {$busqueda[$i][1]}";
						break;
					case "tipo":
						$sql .= "SELECT 'tipo' AS tabla, idtipo AS id, nametipo AS name, imgtipo AS img FROM tipo WHERE idtipo = {$busqueda[$i][1]}";
						break;
					case "operation":
						$sql .= "SELECT 'operation' AS tabla, idop AS id, nameop AS name, imgop AS img FROM operation WHERE idop = {$busqueda[$i][1]}";
						break;
					case "ahorro":
						$sql .= "SELECT 'ahorro' AS tabla, idahorro AS id, nameahorro AS name, imgahorro AS img FROM ahorro WHERE idahorro = {$busqueda[$i][1]}";
						break;
					default:
						break;
				}

				if ($i < count($busqueda) - 1) {
					$sql .= " UNION ALL ";
				}
			}

			$sql .= ") AS all_tables";

			$stmt = $db -> ejecutar($sql);
			return $db -> listar($stmt);
	
		}


		public function select_data_visits($db){
		
			$sql ="SELECT `vivienda`.*, `categoria`.`namecat`, `tipo`.`nametipo`, `city`.`namecity`, `operation`.`nameop`,`ahorro`.`nameahorro`, `images`.`imgimages`
			FROM `tipo`
				LEFT JOIN `vivienda` ON `vivienda`.`tipo` = `tipo`.`idtipo`
				LEFT JOIN `categoria` ON `vivienda`.`categoria` = `categoria`.`idcat`
				LEFT JOIN `operation` ON `vivienda`.`operation` = `operation`.`idop`
				LEFT JOIN `city` ON `vivienda`.`city` = `city`.`idcity`
				LEFT JOIN `images` ON `vivienda`.`images` = `images`.`idimages`
				LEFT JOIN `ahorro` ON `vivienda`.`ahorro` = `ahorro`.`idahorro`
				ORDER BY `visitas` DESC
				LIMIT 4";

			$stmt = $db -> ejecutar($sql);
			return $db -> listar($stmt);
	

		}

		// public function select_count($db){
		// 	$sql = "SELECT COUNT(*) contador
		// 	FROM vivienda";
		// 	$stmt = $db -> ejecutar($sql);
		// 	return $db -> listar($stmt);
			
		// }

		// public function select_count_shop($db,$filtershop){

		// 	$consulta = "SELECT COUNT(*) contador
		// 	FROM `tipo`
		// 	LEFT JOIN `vivienda` ON `vivienda`.`tipo` = `tipo`.`idtipo`
		// 	LEFT JOIN `categoria` ON `vivienda`.`categoria` = `categoria`.`idcat`
		// 	LEFT JOIN `operation` ON `vivienda`.`operation` = `operation`.`idop`
		// 	LEFT JOIN `city` ON `vivienda`.`city` = `city`.`idcity`
		// 	LEFT JOIN `images` ON `vivienda`.`images` = `images`.`idimages`
		// 	LEFT JOIN `ahorro` ON `vivienda`.`ahorro` = `ahorro`.`idahorro`";


        //     for ($i=0; $i < count($filtershop); $i++){
				
        //         if ($i==0){
		// 			if( $filtershop[$i][0]=="superficie"){
		// 				$consulta.= " WHERE vivienda." . $filtershop[$i][0] . "<" . $filtershop[$i][1];
					
		// 			}else if( $filtershop[$i][0]=="superficieMIN"){

		// 				$consulta.= " WHERE vivienda.superficie" . ">" . $filtershop[$i][1];
					
		// 			}
		// 			else if( $filtershop[$i][0]=="pricemin"){
		// 				$consulta.= " WHERE vivienda.price" . ">" . $filtershop[$i][1];
					
		// 			}else if( $filtershop[$i][0]=="pricemax"){

		// 				$consulta.= " WHERE vivienda.price" . "<" . $filtershop[$i][1];
					
		// 			}else if( $filtershop[$i][0]=="order"){
		// 				if( $filtershop[$i][1]=="1"){
		// 					$consulta.= " ORDER BY vivienda.price DESC";
		// 				}else if( $filtershop[$i][1]=="2"){
		// 					$consulta.= " ORDER BY vivienda.price ";
		// 				}else if( $filtershop[$i][1]=="3"){
		// 					$consulta.= " ORDER BY vivienda.superficie";
		// 				}else if( $filtershop[$i][1]=="4"){
		// 					$consulta.= " ORDER BY vivienda.superficie DESC ";
		// 				}else if( $filtershop[$i][1]=="5"){
		// 					$consulta.= " ORDER BY vivienda.visitas DESC ";
		// 				}
					
		// 			}else{
        //             $consulta.= " WHERE vivienda." . $filtershop[$i][0] . "=" . $filtershop[$i][1];
		// 			}
					

        //         }else {
		// 			if( $filtershop[$i][0]=="superficie"){
		// 				$consulta.= " AND vivienda." . $filtershop[$i][0] . "<" . $filtershop[$i][1];
		// 			}else if( $filtershop[$i][0]=="superficieMIN"){

		// 				$consulta.= " AND vivienda.superficie" . ">" . $filtershop[$i][1];
					
		// 			}else if( $filtershop[$i][0]=="pricemin"){
		// 				$consulta.= " AND vivienda.price" . ">" . $filtershop[$i][1];
					
		// 			}else if( $filtershop[$i][0]=="pricemax"){

		// 				$consulta.= " AND vivienda.price" . "<" . $filtershop[$i][1];					
		// 			}
		// 			else if( $filtershop[$i][0]=="order"){
		// 				if( $filtershop[$i][1]=="1"){
		// 				$consulta.= " ORDER BY vivienda.price DESC";
		// 				} else if( $filtershop[$i][1]=="2"){
		// 					$consulta.= " ORDER BY vivienda.price ";
		// 				}else if( $filtershop[$i][1]=="3"){
		// 					$consulta.= " ORDER BY vivienda.superficie DESC";
		// 				}else if( $filtershop[$i][1]=="4"){
		// 					$consulta.= " ORDER BY vivienda.superficie ASC";
		// 				}else if( $filtershop[$i][1]=="5"){
		// 					$consulta.= " ORDER BY vivienda.visitas DESC ";
		// 				}
					
		// 			}else{
        //             $consulta.= " AND vivienda." . $filtershop[$i][0] . "=" . $filtershop[$i][1];
		// 			}

		// 		}
		// 	}
		// 	$stmt = $db -> ejecutar($consulta);
		// 	return $db -> listar($stmt);
		// }

	}
?>