<?php
	class profile_dao{
		static $_instance;

    	private function __construct() {
    	}

    	public static function getInstance() {
        	if(!(self::$_instance instanceof self)){
            	self::$_instance = new self();
        	}
        	return self::$_instance;
    	}

		function select_listbills($db,$id_user){

			$sql=	"SELECT * FROM bills WHERE id_user ='$id_user'";
			$stmt = $db->ejecutar($sql);
	
					return $db->listar($stmt); 
		}
		function select_listlikes($db, $id_user) {
			$sql = "SELECT 
						l.id_user,
						v.idvivienda,
						v.nameviv AS Vivienda_Name,
						v.price AS Vivienda_Price,
						v.superficie AS Vivienda_Superficie,
						v.ahorro AS Vivienda_Ahorro,
						i.imgimages AS Vivienda_Images,
						c.namecity AS City_Name,
						o.nameop AS Operation_Name,
						t.nametipo AS Tipo_Name,
						a.nameahorro AS Ahorro_Name 
					FROM 
						likes l
					INNER JOIN 
						vivienda v ON l.idvivienda = v.idvivienda
					INNER JOIN 
						city c ON v.city = c.idcity
					INNER JOIN 
						operation o ON v.operation = o.idop
					INNER JOIN 
						tipo t ON v.tipo = t.idtipo
					INNER JOIN 
						images i ON v.images = i.idimages
					INNER JOIN 
						ahorro a ON v.ahorro = a.idahorro 
					WHERE 
						l.id_user = '$id_user'";
			
			$stmt = $db->ejecutar($sql);
			
			return $db->listar($stmt); 
		}

		function select_items($db,$invoiceid){
			$sql= "SELECT
			c.id,
			c.id_user,
			c.id_vivienda,
			c.quantity,
			c.isactive,
			c.bill_id,
			v.nameviv,
			v.price
		FROM
			cart c
		INNER JOIN
			vivienda v ON c.id_vivienda = v.idvivienda
		WHERE
			c.bill_id = '$invoiceid'";
	
	
			$stmt = $db->ejecutar($sql);
				
				return $db->listar($stmt); 
		}
		function select_userP($db, $username) {
			$sql = "SELECT COUNT(*) AS count FROM `users` WHERE username = '$username'";
			$stmt = $db->ejecutar($sql);
			$result = $db->listar($stmt);
		
			// Check if any rows were returned
			if (!empty($result) && isset($result[0]['count'])) {
				if ($result[0]['count'] > 0) {
					return "exists"; // Username exists
				} else {
					return false; // Username doesn't exist
				}
			}
		
			return false; // Default to false if no rows were returned or count couldn't be obtained
		}

		function update_Username($db, $username, $id) {
			$sql = "UPDATE `users` SET `username` = '$username' WHERE `id_user` = $id";
			$stmt = $db->ejecutar($sql);
			
			
			if ($stmt) {
				return true; // Username updated successfully
			} else {
				return false; // Failed to update username
			}
		}
		public function select_typeuser($db, $userId) {
			$sql = "SELECT origin FROM users WHERE id_user = $userId";
			$stmt = $db->ejecutar($sql);
			$result = $db->listar($stmt);
		
			// Check if any rows were returned
			if (!empty($result) && isset($result[0]['origin'])) {
				return $result[0]['origin']; // Return the user type
			}
		
			return false; // Default to false if no rows were returned or type_user couldn't be obtained
		}






	}	
?>