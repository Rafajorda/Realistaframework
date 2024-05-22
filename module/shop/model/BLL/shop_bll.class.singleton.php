<?php
// include("model/db.class.singleton.php");
// include("module/home/model/DAO/home_dao.class.singleton.php");
	class shop_bll {
		private $dao;
		private $db;
		static $_instance;

		function __construct() {
			$this -> dao = shop_dao::getInstance();
			$this -> db = db::getInstance();
		}

		public static function getInstance() {
			if (!(self::$_instance instanceof self)) {
				self::$_instance = new self();
			}
			return self::$_instance;
		}

		public function get_list_BLL($args) {
			//return "hola carrusel bll";
			return $this -> dao -> select_all_vivienda($this -> db, $args[0],$args[1]);
		}
		public function get_filtershop_BLL($args) {
			//return "hola carrusel bll";
			return $this -> dao -> select_filtersshop($this -> db, $args[0],$args[1],$args[2]);
		}
		public function get_count_BLL() {
			return $this -> dao -> select_count($this -> db);
		}
		public function get_count_shop_BLL($args) {
			return $this -> dao -> select_count_shop($this -> db,$args);
		}
		public function get_details_BLL($args) {
			return $this -> dao -> select_details($this -> db,$args);
		}
		public function get_ahorro_related_BLL($args) {
			//return "hola carrusel bll";
			return $this -> dao -> select_ahorro_related($this -> db, $args[0],$args[1], $args[2],$args[3]);
		}
		public function get_count_ahorro_related_BLL($args) {
			//return "hola carrusel bll";
			return $this -> dao -> select_count_ahorro_related($this -> db, $args[0],$args[1]);
		}
		public function get_extra_vivienda_BLL($args) {
			//return "hola carrusel bll";
			return $this -> dao -> select_extra_vivienda($this -> db, $args[0],$args[1]);
		}
		public function get_likes_BLL($args) {
			//return "hola carrusel bll";

			$token = middleware::decode_token($args[0]);
			
			//	$this -> dao->likes($args[1],$token['id']);
				// echo json_encode($rdo);
			
			return $this -> dao->likes($this -> db,$args[1],$token['id']);
		}
		public function get_addlike_BLL($args) {
			//return "hola carrusel bll";

			$token = middleware::decode_token($args[0]);
			
			//	$this -> dao->likes($args[1],$token['id']);
				// echo json_encode($rdo);
			
			return $this -> dao->addlike($this -> db,$args[1],$token['id']);
		}
		public function get_deletelike_BLL($args) {
		//return "hola carrusel bll";

		$token = middleware::decode_token($args[0]);
		
		//	$this -> dao->likes($args[1],$token['id']);
			// echo json_encode($rdo);
		
		return $this -> dao->deletelike($this -> db,$args[1],$token['id']);
		}
	}
?>