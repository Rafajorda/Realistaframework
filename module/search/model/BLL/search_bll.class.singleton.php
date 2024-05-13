<?php
// include("model/db.class.singleton.php");
// include("module/home/model/DAO/home_dao.class.singleton.php");
	class search_bll {
		private $dao;
		private $db;
		static $_instance;

		function __construct() {
			$this -> dao = search_dao::getInstance();
			$this -> db = db::getInstance();
		}

		public static function getInstance() {
			if (!(self::$_instance instanceof self)) {
				self::$_instance = new self();
			}
			return self::$_instance;
		}

		public function get_type_vivienda_BLL() {
			//return "hola carrusel bll";
			return $this -> dao -> select_type_vivienda($this -> db);
		}

		public function get_ahorro_vivienda_BLL() {
			return $this -> dao -> select_ahorro_vivienda($this -> db);
		}

		// public function get_type_ahorro_vivienda_BLL($args) {
		// 	return $this -> dao -> select_type_ahorro_vivienda($this -> db,$args[0]);
		// }
		public function get_type_ahorro_vivienda_BLL($args) {
			if ($args !== null && isset($args[0])) {
				return $this->dao->select_type_ahorro_vivienda($this->db, $args[0]);
			} else {
				return $this->dao->select_type_ahorro_vivienda($this->db);
			}
		}
		public function get_autocomplete_BLL($args) {
			
			$complete = $args['complete'] ?? null;
			$ahorro = $args['ahorro'] ?? null;
			$type = $args['type'] ?? null;
			return $this -> dao -> select_autocomplete($this -> db,$complete,$ahorro,$type);
		}
		
	}
?>