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
		
			
			
			$pdfFilePath ='C:\wamp64\www\RealistaF\Realistaframework\uploads\pdf\prueba' . $args . '.pdf';
			
			//$pdfGenerator = new PDFGenerator($pdfFilePath);
		
			
			$qrFilePath = 'uploads/qr/prueba' . $args . '.png';
			$qr = new QR();
			$qr->generateToFile($args, $qrFilePath);
		
			$pdfGenerator = new PDFGenerator($pdfFilePath,$qrFilePath);
			$pdfFilePath = $pdfGenerator->generatePDF($items, $args, $qrFilePath);
		
			return $pdfFilePath; 
		}
	    public function get_changeUsername_BLL($args){

			$newUsername = $args[0];
    		$accessToken = $args[1];
    		 $decode = middleware::decode_token($accessToken);
    		$user = $this->dao->select_userP($this->db, $newUsername);
			// $decode = middleware::decode_token($args[1]);
			// $user = $this -> dao -> select_userP($this->db, $args[0]);
			if($user=="exists"){

				return "exists";
			}else{

				$done=$this -> dao -> update_Username($this->db, $newUsername,$decode['id']);

				$_SESSION['username'] = $newUsername;
				$_SESSION['tiempo'] = time();

				$accesstoken= middleware::create_accesstoken($newUsername,$decode['id']);
				$refreshtoken= middleware::create_refreshtoken($newUsername,$decode['id']);
				$token = array($accesstoken,$refreshtoken);

				return $token;
			 
			}
		}

		public function get_getUserType_BLL($args){
			$decode = middleware::decode_token($args);

			return $this->dao->select_typeuser($this->db,$decode['id']);
		}
		
	}
?>