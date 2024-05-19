<?php
	class shop_dao{
		static $_instance;

		private function __construct() {
		}

 		public static function getInstance() {
     	    if(!(self::$_instance instanceof self)){
    	    	self::$_instance = new self();
    		}
    		return self::$_instance;
		}
		public function prueba($db){
			$sql = "SELECT * FROM vivienda";
			$stmt = $db -> ejecutar($sql);
			return $db -> listar($stmt);
		}

		public function select_all_vivienda($db, $total_prod, $items_page){
			
			$sql = "SELECT `vivienda`.*, `categoria`.`namecat`, `tipo`.`nametipo`, `city`.`namecity`, `operation`.`nameop`,`ahorro`.`nameahorro`, `images`.`imgimages`
			FROM `tipo`
				LEFT JOIN `vivienda` ON `vivienda`.`tipo` = `tipo`.`idtipo`
				LEFT JOIN `categoria` ON `vivienda`.`categoria` = `categoria`.`idcat`
				LEFT JOIN `operation` ON `vivienda`.`operation` = `operation`.`idop`
				LEFT JOIN `city` ON `vivienda`.`city` = `city`.`idcity`
				LEFT JOIN `images` ON `vivienda`.`images` = `images`.`idimages`
				LEFT JOIN `ahorro` ON `vivienda`.`ahorro` = `ahorro`.`idahorro`
				WHERE `vivienda`.`idvivienda` IS NOT NULL
				LIMIT $total_prod, $items_page";

			$stmt = $db -> ejecutar($sql);
			return $db -> listar($stmt);
		}

	function select_details($db,$id){

		$sql_visitas = "UPDATE vivienda SET visitas = visitas + 1 WHERE idvivienda = '$id'";
		$db->ejecutar($sql_visitas);
		// $conexion = connect::con();
   		//  mysqli_query($conexion, $sql_visitas);

		$sql = "SELECT `vivienda`.*, `categoria`.`namecat`, `tipo`.`nametipo`, `city`.`namecity`, `operation`.`nameop`,`ahorro`.`nameahorro`, `images`.`imgimages`
		FROM `tipo`
			LEFT JOIN `vivienda` ON `vivienda`.`tipo` = `tipo`.`idtipo`
			LEFT JOIN `categoria` ON `vivienda`.`categoria` = `categoria`.`idcat`
			LEFT JOIN `operation` ON `vivienda`.`operation` = `operation`.`idop`
			LEFT JOIN `city` ON `vivienda`.`city` = `city`.`idcity`
			LEFT JOIN `images` ON `vivienda`.`images` = `images`.`idimages`
			LEFT JOIN `ahorro` ON `vivienda`.`ahorro` = `ahorro`.`idahorro`
		WHERE idvivienda = '$id'";

		$stmt = $db -> ejecutar($sql);
		return $db -> listar($stmt);
		}

		function filtershome_vivienda($filtershome){
        $select = "SELECT `vivienda`.*, `categoria`.`namecat`, `tipo`.`nametipo`, `city`.`namecity`, `operation`.`nameop`,`ahorro`.`nameahorro`, `images`.`imgimages`
		FROM `tipo`
			LEFT JOIN `vivienda` ON `vivienda`.`tipo` = `tipo`.`idtipo`
			LEFT JOIN `categoria` ON `vivienda`.`categoria` = `categoria`.`idcat`
			LEFT JOIN `operation` ON `vivienda`.`operation` = `operation`.`idop`
			LEFT JOIN `city` ON `vivienda`.`city` = `city`.`idcity`
			LEFT JOIN `images` ON `vivienda`.`images` = `images`.`idimages`
			LEFT JOIN `ahorro` ON `vivienda`.`ahorro` = `ahorro`.`idahorro`";

        if ((isset($filtershome[0]['categoria'])) && $filtershome[0]['categoria']){
            $prueba = $filtershome[0]['categoria'][0];
            $select.= " WHERE categoria = '$prueba'";
        }else if((isset($filtershome[0]['city'])) && $filtershome[0]['city']) {
            $prueba = $filtershome[0]['city'][0];
            $select.= " WHERE city = '$prueba'";
        }else if((isset($filtershome[0]['operation'])) && $filtershome[0]['operation']) {
            $prueba = $filtershome[0]['operation'][0];
            $select.= " WHERE operation = '$prueba'";
		}else if((isset($filtershome[0]['tipo'])) && $filtershome[0]['tipo']) {
            $prueba = $filtershome[0]['tipo'][0];
            $select.= " WHERE tipo = '$prueba'";
		}else if((isset($filtershome[0]['ahorro'])) && $filtershome[0]['ahorro']) {
            $prueba = $filtershome[0]['ahorro'][0];
            $select.= " WHERE ahorro = '$prueba'";
		}
       
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

		function select_filtersshop($db,$filtershop,$total_prod, $items_page){
		

			$consulta ="SELECT `vivienda`.*, `categoria`.`namecat`, `tipo`.`nametipo`, `city`.`namecity`, `operation`.`nameop`,`ahorro`.`nameahorro`, `images`.`imgimages`
			FROM `tipo`
				LEFT JOIN `vivienda` ON `vivienda`.`tipo` = `tipo`.`idtipo`
				LEFT JOIN `categoria` ON `vivienda`.`categoria` = `categoria`.`idcat`
				LEFT JOIN `operation` ON `vivienda`.`operation` = `operation`.`idop`
				LEFT JOIN `city` ON `vivienda`.`city` = `city`.`idcity`
				LEFT JOIN `images` ON `vivienda`.`images` = `images`.`idimages`
				LEFT JOIN `ahorro` ON `vivienda`.`ahorro` = `ahorro`.`idahorro`";


				for ($i=0; $i < count($filtershop); $i++){
					
					if ($i==0){
						if( $filtershop[$i][0]=="superficie"){
							$consulta.= " WHERE vivienda." . $filtershop[$i][0] . "<" . $filtershop[$i][1];
						
						}else if( $filtershop[$i][0]=="superficieMIN"){

							$consulta.= " WHERE vivienda.superficie" . ">" . $filtershop[$i][1];
						
						}
						else if( $filtershop[$i][0]=="pricemin"){
							$consulta.= " WHERE vivienda.price" . ">" . $filtershop[$i][1];
						
						}else if( $filtershop[$i][0]=="pricemax"){

							$consulta.= " WHERE vivienda.price" . "<" . $filtershop[$i][1];
						
						}else if( $filtershop[$i][0]=="order"){
							if( $filtershop[$i][1]=="1"){
								$consulta.= " ORDER BY vivienda.price DESC";
							}else if( $filtershop[$i][1]=="2"){
								$consulta.= " ORDER BY vivienda.price ";
							}else if( $filtershop[$i][1]=="3"){
								$consulta.= " ORDER BY vivienda.superficie";
							}else if( $filtershop[$i][1]=="4"){
								$consulta.= " ORDER BY vivienda.superficie DESC ";
							}else if( $filtershop[$i][1]=="5"){
								$consulta.= " ORDER BY vivienda.visitas DESC ";
							}
						
						}else{
						$consulta.= " WHERE vivienda." . $filtershop[$i][0] . "=" . $filtershop[$i][1];
						}
						

					}else {
						if( $filtershop[$i][0]=="superficie"){
							$consulta.= " AND vivienda." . $filtershop[$i][0] . "<" . $filtershop[$i][1];
						}else if( $filtershop[$i][0]=="superficieMIN"){

							$consulta.= " AND vivienda.superficie" . ">" . $filtershop[$i][1];
						
						}else if( $filtershop[$i][0]=="pricemin"){
							$consulta.= " AND vivienda.price" . ">" . $filtershop[$i][1];
						
						}else if( $filtershop[$i][0]=="pricemax"){

							$consulta.= " AND vivienda.price" . "<" . $filtershop[$i][1];					
						}
						else if( $filtershop[$i][0]=="order"){
							if( $filtershop[$i][1]=="1"){
							$consulta.= " ORDER BY vivienda.price DESC";
							} else if( $filtershop[$i][1]=="2"){
								$consulta.= " ORDER BY vivienda.price ";
							}else if( $filtershop[$i][1]=="3"){
								$consulta.= " ORDER BY vivienda.superficie DESC";
							}else if( $filtershop[$i][1]=="4"){
								$consulta.= " ORDER BY vivienda.superficie ASC";
							}else if( $filtershop[$i][1]=="5"){
								$consulta.= " ORDER BY vivienda.visitas DESC ";
							}
						
						}else{
						$consulta.= " AND vivienda." . $filtershop[$i][0] . "=" . $filtershop[$i][1];
						}



					}        
				}   
				$consulta.= " LIMIT $total_prod, $items_page";

				$stmt = $db -> ejecutar($consulta);
				return $db -> listar($stmt);
		}

	 	public function select_count($db){
			$sql = "SELECT COUNT(*) contador
			FROM vivienda";
			$stmt = $db -> ejecutar($sql);
			return $db -> listar($stmt);
			
		}

		public function select_count_shop($db,$filtershop){

		$consulta = "SELECT COUNT(*) contador
		FROM `tipo`
			LEFT JOIN `vivienda` ON `vivienda`.`tipo` = `tipo`.`idtipo`
			LEFT JOIN `categoria` ON `vivienda`.`categoria` = `categoria`.`idcat`
			LEFT JOIN `operation` ON `vivienda`.`operation` = `operation`.`idop`
			LEFT JOIN `city` ON `vivienda`.`city` = `city`.`idcity`
			LEFT JOIN `images` ON `vivienda`.`images` = `images`.`idimages`
			LEFT JOIN `ahorro` ON `vivienda`.`ahorro` = `ahorro`.`idahorro`";


            for ($i=0; $i < count($filtershop); $i++){
				
                if ($i==0){
					if( $filtershop[$i][0]=="superficie"){
						$consulta.= " WHERE vivienda." . $filtershop[$i][0] . "<" . $filtershop[$i][1];
					
					}else if( $filtershop[$i][0]=="superficieMIN"){

						$consulta.= " WHERE vivienda.superficie" . ">" . $filtershop[$i][1];
					
					}
					else if( $filtershop[$i][0]=="pricemin"){
						$consulta.= " WHERE vivienda.price" . ">" . $filtershop[$i][1];
					
					}else if( $filtershop[$i][0]=="pricemax"){

						$consulta.= " WHERE vivienda.price" . "<" . $filtershop[$i][1];
					
					}else if( $filtershop[$i][0]=="order"){
						if( $filtershop[$i][1]=="1"){
							$consulta.= " ORDER BY vivienda.price DESC";
						}else if( $filtershop[$i][1]=="2"){
							$consulta.= " ORDER BY vivienda.price ";
						}else if( $filtershop[$i][1]=="3"){
							$consulta.= " ORDER BY vivienda.superficie";
						}else if( $filtershop[$i][1]=="4"){
							$consulta.= " ORDER BY vivienda.superficie DESC ";
						}else if( $filtershop[$i][1]=="5"){
							$consulta.= " ORDER BY vivienda.visitas DESC ";
						}
					
					}else{
                    $consulta.= " WHERE vivienda." . $filtershop[$i][0] . "=" . $filtershop[$i][1];
					}
					

                }else {
					if( $filtershop[$i][0]=="superficie"){
						$consulta.= " AND vivienda." . $filtershop[$i][0] . "<" . $filtershop[$i][1];
					}else if( $filtershop[$i][0]=="superficieMIN"){

						$consulta.= " AND vivienda.superficie" . ">" . $filtershop[$i][1];
					
					}else if( $filtershop[$i][0]=="pricemin"){
						$consulta.= " AND vivienda.price" . ">" . $filtershop[$i][1];
					
					}else if( $filtershop[$i][0]=="pricemax"){

						$consulta.= " AND vivienda.price" . "<" . $filtershop[$i][1];					
					}
					else if( $filtershop[$i][0]=="order"){
						if( $filtershop[$i][1]=="1"){
						$consulta.= " ORDER BY vivienda.price DESC";
						} else if( $filtershop[$i][1]=="2"){
							$consulta.= " ORDER BY vivienda.price ";
						}else if( $filtershop[$i][1]=="3"){
							$consulta.= " ORDER BY vivienda.superficie DESC";
						}else if( $filtershop[$i][1]=="4"){
							$consulta.= " ORDER BY vivienda.superficie ASC";
						}else if( $filtershop[$i][1]=="5"){
							$consulta.= " ORDER BY vivienda.visitas DESC ";
						}
					
					}else{
                    $consulta.= " AND vivienda." . $filtershop[$i][0] . "=" . $filtershop[$i][1];
					}

				}
			}
			$stmt = $db -> ejecutar($consulta);
			return $db -> listar($stmt);
		}

		public function select_count_ahorro_related($db,$ahorro,$idvivienda){
			$sql = "SELECT COUNT(*) AS contador
					FROM vivienda 
					WHERE ahorro = '$ahorro'
					AND idvivienda != '$idvivienda'";
			$stmt = $db -> ejecutar($sql);
			return $db -> listar($stmt);
			
		}

		public function select_ahorro_related($db,$ahorro, $loaded, $viviendas,$idvivienda){
			
			$sql ="SELECT `vivienda`.*, `categoria`.`namecat`, `tipo`.`nametipo`, `city`.`namecity`, `operation`.`nameop`,`ahorro`.`nameahorro`, `images`.`imgimages`
			FROM `tipo`
			LEFT JOIN `vivienda` ON `vivienda`.`tipo` = `tipo`.`idtipo`
			LEFT JOIN `categoria` ON `vivienda`.`categoria` = `categoria`.`idcat`
			LEFT JOIN `operation` ON `vivienda`.`operation` = `operation`.`idop`
			LEFT JOIN `city` ON `vivienda`.`city` = `city`.`idcity`
			LEFT JOIN `images` ON `vivienda`.`images` = `images`.`idimages`
			LEFT JOIN `ahorro` ON `vivienda`.`ahorro` = `ahorro`.`idahorro`
			WHERE `ahorro`.`idahorro` = '$ahorro'
			AND idvivienda != '$idvivienda'
			LIMIT $loaded, $viviendas";


			$stmt = $db -> ejecutar($sql);
			return $db -> listar($stmt);


			
		}

		function select_extra_vivienda($db,$ahorro,$vivienda){
			$sql ="SELECT `vivienda`.*, 
			`categoria`.`namecat`, 
			`tipo`.`nametipo`, 
			`city`.`namecity`, 
			`operation`.`nameop`,
			`ahorro`.`nameahorro`, 
			`images`.`imgimages`
			FROM `vivienda`
		 	LEFT JOIN `categoria` ON `vivienda`.`categoria` = `categoria`.`idcat`
			LEFT JOIN `tipo` ON `vivienda`.`tipo` = `tipo`.`idtipo`
		 	LEFT JOIN `city` ON `vivienda`.`city` = `city`.`idcity`
			LEFT JOIN `operation` ON `vivienda`.`operation` = `operation`.`idop`
		 	LEFT JOIN `ahorro` ON `vivienda`.`ahorro` = `ahorro`.`idahorro`
			LEFT JOIN `images` ON `vivienda`.`images` = `images`.`idimages`
			WHERE `vivienda`.`idvivienda` != '$vivienda' -- Exclude the given vivienda
			AND `vivienda`.`ahorro` != '$ahorro'
			ORDER BY (
		 	-- Define your similarity metric here
			(`vivienda`.`categoria` = (SELECT `categoria` FROM `vivienda` WHERE `idvivienda` = '$vivienda')) +
		 	(`vivienda`.`tipo` = (SELECT `tipo` FROM `vivienda` WHERE `idvivienda` = '$vivienda')) +
			(`vivienda`.`city` = (SELECT `city` FROM `vivienda` WHERE `idvivienda` = '$vivienda')) +
		 	(`vivienda`.`operation` = (SELECT `operation` FROM `vivienda` WHERE `idvivienda` = '$vivienda'))
			) DESC
			LIMIT 1";

			$stmt = $db -> ejecutar($sql);
			return $db -> listar($stmt);
		}

		// public function likes($idvivienda,$iduser){
			// 	$sql="SELECT COUNT(*) AS count
			// 	FROM likes
			// 	WHERE idvivienda = $idvivienda AND id_user = $iduser";



			// // 	$conexion = connect::con();
			// // 	$res = mysqli_query($conexion, $sql);
			// // 	connect::close($conexion);


			// // 	$retrArray = array();
			// // if (mysqli_num_rows($res) > 0) {
			// // 	while ($row = mysqli_fetch_assoc($res)) {
			// // 		$retrArray[] = $row;
			// // 	}
			// // }
			// // return $retrArray;

			// $conexion = connect::con();
			// $res = mysqli_query($conexion, $sql);
			// connect::close($conexion);

			// if ($res && mysqli_num_rows($res) > 0) {
			//     $row = mysqli_fetch_assoc($res);
			//     return $row['count'];
			// } else {   
			//     return 0;
			// }


		// }

		// function likes($db,$idvivienda, $iduser) {
		// 		$sql = "SELECT COUNT(*) AS combination_exists
		// 				FROM likes
		// 				WHERE idvivienda = $idvivienda AND id_user = $iduser";
		
		// 			$stmt = $db -> ejecutar($sql);
		// 			/
		// 		if ($res && mysqli_num_rows($res) > 0) {
		// 			$row = mysqli_fetch_assoc($res);
		// 			// Return 1 if combination exists, else return 0
		// 			return $row['combination_exists'] > 0 ? 1 : 0;
		// 		} else {
		// 			// Return 0 if no rows found
		// 			return 0;
		// 		}
		// }
		function likes($db, $idvivienda, $iduser) {
			
			$sql = "SELECT COUNT(*) AS combination_exists
					FROM likes
					WHERE idvivienda = $idvivienda AND id_user = $iduser";
		
			
			$res = $db -> ejecutar($sql);
		
			// Check if the query was successful and if there are rows returned
			if ($res && mysqli_num_rows($res) > 0) {
				$row = mysqli_fetch_assoc($res);
				// Return 1 if the combination exists, else return 0
				return $row['combination_exists'] > 0 ? 1 : 0;
			} else {
				// Return 0 if no rows found
				return 0;
			}
		}
	

		function addlike($db,$idvivienda, $iduser) {
				$sql = "INSERT INTO `likes`(`idvivienda`, `id_user`) VALUES ($idvivienda,$iduser)";
	
				$res = $db -> ejecutar($sql);
		
				return 0;
		}

		function deletelike($db,$idvivienda, $iduser) {
				$sql = "DELETE FROM `likes` WHERE `likes`.`idvivienda` = $idvivienda AND `likes`.`id_user` = $iduser";
				$res = $db -> ejecutar($sql);
	
				return 0;
		}


	}
?>
