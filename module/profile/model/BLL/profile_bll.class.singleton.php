<?php
// include("model/db.class.singleton.php");
// include("module/home/model/DAO/home_dao.class.singleton.php");
//require_once '/utils/vendor/autoload.php';
require_once 'C:/wamp64/www/RealistaF/Realistaframework/utils/PDF.inc.php';
	class profile_bll {
		private $dao;
		private $db;
		static $_instance;

		function __construct() {
			$this -> dao = profile_dao::getInstance();
			$this -> db = db::getInstance();
		}

		public static function getInstance() {
			if (!(self::$_instance instanceof self)) {
				self::$_instance = new self();
			}
			return self::$_instance;
		}

		public function get_listinvoices_BLL($args) {
			
			$decode = middleware::decode_token($args);
			return  $this->dao->select_listbills($this->db,$decode['id']);

		}
		public function get_listlikes_BLL($args) {
			
			$decode = middleware::decode_token($args);
			return  $this->dao->select_listlikes($this->db,$decode['id']);

		}


		public function get_generatepdf_BLL($args) {
			
			$items = $this->dao->select_items($this->db, $args);
		
			
			if ($items === false) {
				return false; 
			}
		
			
			$pdfFilePath = 'C:/Users/usuario/Desktop/pruebapdf/prueba' . $args . '.pdf';
		
			
			//$pdfGenerator = new PDFGenerator($pdfFilePath);
		
			
			$qrFilePath = 'C:/Users/usuario/Desktop/pruebapdf/qrcodes_' . $args . '.png';
			$qr = new QR();
			$qr->generateToFile($args, $qrFilePath);
		
			$pdfGenerator = new PDFGenerator($pdfFilePath,$qrFilePath);
			$pdfFilePath = $pdfGenerator->generatePDF($items, $args, $qrFilePath);
		
			return $pdfFilePath; 
		}
		
	}
?>