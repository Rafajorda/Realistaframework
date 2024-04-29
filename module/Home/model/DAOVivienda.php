<?php
$path = $_SERVER['DOCUMENT_ROOT'] . '/realistaV13';
include($path . "/model/connect.php");
    
	class DAOVivienda{

function select_categories() {
	
	$conexion = connect::con();

	
  if (!$conexion) {
    die("Connection failed: " . mysqli_connect_error());
}

$sql= "SELECT *FROM categoria";

	$res = mysqli_query($conexion, $sql);
	connect::close($conexion);

	$retrArray = array();
	if (mysqli_num_rows($res) > 0) {
		while ($row = mysqli_fetch_assoc($res)) {
			$retrArray[] = $row;
		}
	}
	return $retrArray;
}

function select_types() {
	
	$conexion = connect::con();

	
  if (!$conexion) {
    die("Connection failed: " . mysqli_connect_error());
}

$sql= "SELECT *FROM tipo";

	$res = mysqli_query($conexion, $sql);
	connect::close($conexion);

	$retrArray = array();
	if (mysqli_num_rows($res) > 0) {
		while ($row = mysqli_fetch_assoc($res)) {
			$retrArray[] = $row;
		}
	}
	return $retrArray;
}
function select_operations() {
	
	$conexion = connect::con();

	
  if (!$conexion) {
    die("Connection failed: " . mysqli_connect_error());
}

$sql= "SELECT *FROM operation";

	$res = mysqli_query($conexion, $sql);
	connect::close($conexion);

	$retrArray = array();
	if (mysqli_num_rows($res) > 0) {
		while ($row = mysqli_fetch_assoc($res)) {
			$retrArray[] = $row;
		}
	}
	return $retrArray;
}
function select_city() {
	
	$conexion = connect::con();

	
  if (!$conexion) {
    die("Connection failed: " . mysqli_connect_error());
}

$sql= "SELECT *FROM city";

	$res = mysqli_query($conexion, $sql);
	connect::close($conexion);

	$retrArray = array();
	if (mysqli_num_rows($res) > 0) {
		while ($row = mysqli_fetch_assoc($res)) {
			$retrArray[] = $row;
		}
	}
	return $retrArray;
}
function select_ahorro() {
	
	$conexion = connect::con();

	
  if (!$conexion) {
    die("Connection failed: " . mysqli_connect_error());
}

$sql= "SELECT *FROM ahorro";

	$res = mysqli_query($conexion, $sql);
	connect::close($conexion);

	$retrArray = array();
	if (mysqli_num_rows($res) > 0) {
		while ($row = mysqli_fetch_assoc($res)) {
			$retrArray[] = $row;
		}
	}
	return $retrArray;
}

function select_recommend() {
	
	$conexion = connect::con();

	
  if (!$conexion) {
    die("Connection failed: " . mysqli_connect_error());
}

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


	$res = mysqli_query($conexion, $sql);
	connect::close($conexion);

	$retrArray = array();
	if (mysqli_num_rows($res) > 0) {
		while ($row = mysqli_fetch_assoc($res)) {
			$retrArray[] = $row;
		}
	}
	return $retrArray;
}
// 
// function select_busqueda($busqueda) {
	
// 	$conexion = connect::con();

	
//   if (!$conexion) {
//     die("Connection failed: " . mysqli_connect_error());
// }
// for ($i=0; $i < count($busqueda); $i++){
// $sql= "SELECT tabla, id, name, img
// FROM (";
// 	if($busqueda[$i][0]=="categoria"){

//     "SELECT 'categoria' AS tabla, idcat AS id, namecat AS name, imgcat AS img
//     FROM categoria
//     UNION ALL
// 	WHERE idcat" =$busqueda[$i][1] ;
// 	}
// 	if($busqueda[$i][0]=="city"){
//     "SELECT 'city' AS tabla, idcity AS id, namecity AS name, imgcity AS img
//     FROM city
//     UNION ALL"
// 	;
// }
// if($busqueda[$i][0]=="tipo"){
//     "SELECT 'tipo' AS tabla, idtipo AS id, nametipo AS name, imgtipo AS img
//     FROM tipo
// 	UNION ALL
// 	WHERE idtipo" =$busqueda[$i][1] }
// if($busqueda[$i][0]=="operation"){
//     "SELECT 'operation' AS tabla, idop AS id, nameop AS name, imgop AS img
//     FROM operation
// 	UNION ALL
// 	WHERE idop" =$busqueda[$i][1] ;
// }
// if($busqueda[$i][0]=="ahorro"){
//    " SELECT 'ahorro' AS tabla, idahorro AS id, nameahorro AS name, imgahorro AS img
//     FROM ahorro
// 	WHERE idahorro" =$busqueda[$i][1] ;
// }
//  ")AS all_tables";

// } 
// $res = mysqli_query($conexion, $sql);
// connect::close($conexion);

// $retrArray = array();
// if (mysqli_num_rows($res) > 0) {
// 	while ($row = mysqli_fetch_assoc($res)) {
// 		$retrArray[] = $row;
// 	}
// }
// return $retrArray;
// }

function select_busqueda($busqueda) {
    $conexion = connect::con();
    $resultados = array();

    if (!$conexion) {
        die("Connection failed: " . mysqli_connect_error());
    }

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

    $res = mysqli_query($conexion, $sql);

    if ($res) {
        while ($row = mysqli_fetch_assoc($res)) {
            $resultados[] = $row;
        }
    }

    connect::close($conexion);

    return $resultados;
}






function select_visitas(){
	
	$consulta ="SELECT `vivienda`.*, `categoria`.`namecat`, `tipo`.`nametipo`, `city`.`namecity`, `operation`.`nameop`,`ahorro`.`nameahorro`, `images`.`imgimages`
	FROM `tipo`
		LEFT JOIN `vivienda` ON `vivienda`.`tipo` = `tipo`.`idtipo`
		LEFT JOIN `categoria` ON `vivienda`.`categoria` = `categoria`.`idcat`
		LEFT JOIN `operation` ON `vivienda`.`operation` = `operation`.`idop`
		LEFT JOIN `city` ON `vivienda`.`city` = `city`.`idcity`
		LEFT JOIN `images` ON `vivienda`.`images` = `images`.`idimages`
		LEFT JOIN `ahorro` ON `vivienda`.`ahorro` = `ahorro`.`idahorro`
		ORDER BY `visitas` DESC
		LIMIT 4";


	$conexion = connect::con();
	$res = mysqli_query($conexion, $consulta);
	connect::close($conexion);

	$retrArray = array();
		if ($res -> num_rows > 0) {
	while ($row = mysqli_fetch_assoc($res)) {
		$retrArray[] = $row;
	}
}
return $retrArray;

}


// function select_categories() {
//     $sql = "SELECT * FROM categoria";

//     $conexion = connect::con();
    
//     if (!$conexion) {
//         die("Connection failed: " . mysqli_connect_error());
//     }

//     $res = mysqli_query($conexion, $sql);

//     if (!$res) {
//         die("Query failed: " . mysqli_error($conexion));
//     }

//     connect::close($conexion);

//     $retrArray = array();
//     if (mysqli_num_rows($res) > 0) {
//         while ($row = mysqli_fetch_assoc($res)) {
//             $retrArray[] = $row;
//         }
//     }
    
//     return $retrArray;
// }


	}