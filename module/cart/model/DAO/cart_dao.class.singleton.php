<?php
	class cart_dao{
		static $_instance;

    	private function __construct() {
    	}

    	public static function getInstance() {
        	if(!(self::$_instance instanceof self)){
            	self::$_instance = new self();
        	}
        	return self::$_instance;
    	}

		function select_list($db,$id_user){

		$sql=	"SELECT cart.*, vivienda.price,vivienda.nameviv,  vivienda.stock FROM cart JOIN vivienda ON cart.id_vivienda = vivienda.idvivienda WHERE cart.id_user ='$id_user'";
		$stmt = $db->ejecutar($sql);

				return $db->listar($stmt); 
		}

		function select_carrito($db,$id_vivienda,$id_user){

			$sql = "SELECT `id`,`id_user`, `id_vivienda` FROM `cart` WHERE `id_user`='$id_user'AND `id_vivienda` = '$id_vivienda' AND `isactive` = 1 ";

            $stmt = $db->ejecutar($sql);

				$result = $db->listar($stmt);
			

				if (count($result) > 0) {
					return "si";
				} else {
					return "no";
				}
		}
		
		function update_addtocart($db, $id_vivienda, $id_user) {
			$sql = "UPDATE `cart` 
					SET `quantity` = `quantity` + 1 
					WHERE `id_user` = '$id_user' 
					AND `id_vivienda` = '$id_vivienda' 
					AND (`bill_id` IS NULL OR `bill_id` = '')";
		
			$stmt = $db->ejecutar($sql);
		
			if ($stmt) {
				return "added";
			} else {
				return "error";
			}
		}

		function insert_createcart($db,$id_vivienda,$id_user){
			

			$sql = "INSERT INTO `cart`(id_user,id_vivienda,quantity)
			VALUES ($id_user,$id_vivienda,1)";

			$stmt = $db->ejecutar($sql);

			if ($stmt) {
				return "created";
			} else {
				return "error";
			}
		}
		function select_count($db,$id_user){
			$sql = "SELECT SUM(quantity) AS total_quantity
            FROM cart
            WHERE id_user = '$id_user'AND `bill_id` IS NULL OR `bill_id` = ''";
			$stmt = $db->ejecutar($sql);
			if ($stmt) {
				$row = $stmt->fetch_assoc();
				
				return $row['total_quantity'];
			} else {
				return false;
			}

		}
		function select_countpricebill($db, $id_user, $bill) {
			$sql = "SELECT SUM(vivienda.price * cart.quantity) AS total_price
					FROM cart
					INNER JOIN vivienda ON cart.id_vivienda = vivienda.idvivienda
					WHERE cart.id_user = '$id_user' AND cart.bill_id = '$bill'";
			$stmt = $db->ejecutar($sql);
			if ($stmt) {
				$row = $stmt->fetch_assoc();
				return $row['total_price'];
			} else {
				return false;
			}
		}
		function select_countbill($db, $id_user, $bill) {
			$sql = "SELECT SUM(quantity) AS total_quantity
					FROM cart
					WHERE id_user = '$id_user' AND bill_id = '$bill'";
			$stmt = $db->ejecutar($sql);
			if ($stmt) {
				$row = $stmt->fetch_assoc();
				return $row['total_quantity'];
			} else {
				return false;
			}
		}

		function update_carrito($db,$id_user,$id_vivienda,$quantity){
			$sql ="UPDATE cart  SET quantity = $quantity  WHERE `id_user` = '$id_user' AND `id_vivienda` = '$id_vivienda'";

			$stmt = $db->ejecutar($sql);

			return "updated";


		}
		function delete_carrito($db,$id_user,$id_vivienda){

			$sql ="DELETE FROM cart  WHERE `id_user` = '$id_user' AND `id_vivienda` = '$id_vivienda'";

			$stmt = $db->ejecutar($sql);

			return "deleted";

		}

		function see_bill($db, $bill){
			$sql = "SELECT * FROM `cart` WHERE `bill_id` = '$bill'";
			$stmt = $db->ejecutar($sql);
			
				
			if ($stmt->num_rows > 0) {
					
				return true;
			} else {
					return false;
			}
		}
		function update_checkout($db, $id_user, $bill) {
			$sql = "UPDATE cart  
					SET bill_id = '$bill', isactive = 0 
					WHERE (`id_user` = '$id_user' AND (`bill_id` IS NULL OR `bill_id` = ''))";
			
			$stmt = $db->ejecutar($sql);
			if ($stmt) {
				return 'done';
			} else {
				return false; 
			}
		}
		function create_invoice($db, $id_user, $bill, $qtty, $price) {
			$sql = "INSERT INTO bills (`ID`, `id_user`, `items`, `price`) 
					VALUES ('$bill', '$id_user', $qtty, $price)";
			$stmt = $db->ejecutar($sql);
			if ($stmt) {
				return 'done';
			} else {
				return false; 
			}
		}


	}

	
?>