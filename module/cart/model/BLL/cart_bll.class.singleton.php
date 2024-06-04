<?php
// include("model/db.class.singleton.php");
// include("module/home/model/DAO/home_dao.class.singleton.php");
	class cart_bll {
		private $dao;
		private $db;
		static $_instance;

		function __construct() {
			$this -> dao = cart_dao::getInstance();
			$this -> db = db::getInstance();
		}

		public static function getInstance() {
			if (!(self::$_instance instanceof self)) {
				self::$_instance = new self();
			}
			return self::$_instance;
		}

		public function get_list_BLL($args) {
			
			$decode = middleware::decode_token($args);
			return  $this->dao->select_list($this->db,$decode['id']);

		}
		

		public function get_addtocart_BLL($args) {
			 $decode = middleware::decode_token($args[1]);
			 $exists = $this->dao->select_carrito($this->db, $args[0], $decode['id']);
			if ($exists === 'si') {
				return $this->dao->update_addtocart($this->db, $args[0], $decode['id']);
			} else {
				return $this->dao->insert_createcart($this->db, $args[0], $decode['id']);
			}


			return $exists;
		}
		public function get_count_bll($args){

			$decode = middleware::decode_token($args);
			return $this->dao->select_count($this->db,$decode['id']);
		}
		public function get_update_quantity_BLL($args){
			$decode = middleware::decode_token($args[0]);
			return $this->dao->update_carrito($this->db, $decode['id'],$args[1],$args[2]);
			
		}

		public function get_delete_item_BLL($args){

			$decode = middleware::decode_token($args[0]);
			return $this->dao->delete_carrito($this->db, $decode['id'],$args[1]);
		}

		public function get_checkout_BLL($args){
			$decode = middleware::decode_token($args);
			do{
				$bill= common::generate_OTP();
				$bill_id = $decode['id'] . "-" . $bill;
				$checkbill=$this->dao->see_bill($this->db,$bill_id);
			}while ($checkbill==true);
			 $this->dao->update_checkout($this->db,$decode['id'],$bill_id);
			$countbill= $this->dao->select_countbill($this->db,$decode['id'],$bill_id);
			$pricebill = $this->dao->select_countpricebill($this->db,$decode['id'],$bill_id);
			$done= $this->dao->create_invoice($this->db,$decode['id'],$bill_id,$countbill,$pricebill);
			  return "done";
		}

	}
?>