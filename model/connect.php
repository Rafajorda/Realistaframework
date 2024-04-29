<?php
	class connect{
		public static function con(){


		$cred =	parse_ini_file($_SERVER['DOCUMENT_ROOT'] . '/RealistaFramework/model/credentials.ini');
			$host = $cred['DB_HOST'];  
    		$user =  $cred['DB_USER'];                    
    		$pass = $cred['DB_PASS'];                             
    		$db = $cred['DB_DB'];                      
    		$port = $cred['DB_PORT'];                           
    		
    		$conexion = mysqli_connect($host, $user, $pass, $db, $port)or die(mysql_error());
			
			if ($conexion->connect_error) {
				die("Connection failed: " . $conexion->connect_error);
			}
			return $conexion;
		}
		public static function close($conexion){
			mysqli_close($conexion);
		}
	}