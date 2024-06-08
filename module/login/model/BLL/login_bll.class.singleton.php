<?php
	class login_bll {
		private $dao;
		private $db;
		static $_instance;

		function __construct() {
			$this -> dao = login_dao::getInstance();
			$this -> db = db::getInstance();
		}

		public static function getInstance() {
			if (!(self::$_instance instanceof self)) {
				self::$_instance = new self();
			}
			return self::$_instance;
		}

		public function get_register_BLL($args) {
	
			$hashed_pass = password_hash($args[1], PASSWORD_DEFAULT, ['cost' => 12]);
            $hashavatar = md5(strtolower(trim($args[2]))); 
            $avatar = "https://i.pravatar.cc/500?u=$hashavatar";
			$token_email = common::generate_Token_secure(20);

			if (!empty($this -> dao -> select_user($this->db, $args[0]))) {
				return array(
					'success' => false,
					'message' => 'El usuario ya está en uso, por favor, elige otro nombre de usuario.'
				);
            } else {
				$result = $this -> dao -> insert_user($this->db, $args[0], $hashed_pass, $args[2], $avatar, $token_email);
				$message = [ 'type' => 'validate', 
								'token' => $token_email, 
								'toEmail' =>  $args[2]];
				$email = json_decode(mail::send_email($message), true);
				if (!empty($email)) {
					return;  
				}   
				if ($result) {
					return array(
						'success' => true,
						'message' => 'Usuario registrado exitosamente.'
					);
				} else {
					// Error al insertar el usuario
					// Devuelve un objeto JSON con un mensaje de error
					return array(
						'success' => false,
						'message' => 'Hubo un problema al registrar el usuario. Por favor, inténtalo de nuevo más tarde.'
					);
				}
				
			}
			//return 'potato';
		}

		public function get_login_BLL($args) {


			if (!empty($this -> dao -> select_user($this->db, $args[0], $args[0]))) {	
				$user = $this -> dao -> select_user($this->db, $args[0], $args[0]);
				if($user[0]["origin"]=="local"){
					if (password_verify($args[1], $user[0]['password']) && $user[0]['activate'] == 1) {
						//$jwt = jwt_process::encode($user[0]['username']);
						$_SESSION['username'] = $user[0]['username'];
						$_SESSION['tiempo'] = time();
						// session_regenerate_id();
						$reset= $this -> dao -> reset_fails($this->db,$user[0]['username']);
					 $potato=	$this -> dao -> rescount($this->db,$args[0]);
						$accesstoken= middleware::create_accesstoken($user[0]["username"],$user[0]["id_user"]);
						$refreshtoken= middleware::create_refreshtoken($user[0]["username"],$user[0]["id_user"]);
						$token = array($accesstoken,$refreshtoken);
						$_SESSION['username'] = $user[0]['username']; //Guardamos el usario 
						$_SESSION['tiempo'] = time(); //Guardamos el tiempo que se logea
						return $token;
					} else if (password_verify($args[1], $user[0]['password']) && $user[0]['activate'] == 0) {
						return 'activate error';
					} else {
						$count = $this -> dao -> seecount($this->db,$args[0]);
						if($count<3){ 
						$fail= $this -> dao -> addcount($this->db,$args[0]);
						return 'error_passwd';
						}else{
						$activate=	$this -> dao -> set_active($this->db,$args[0]);
						
						$message = common::generate_OTP();
						$updateotp =$this -> dao -> addOTP($this->db,$args[0],$message);
						$rr= OTP::OTP_send2($message);
							return'3_fails';
						}
					}
				}else{
					return 'social';
				}
				
            } else {
				return 'error_user';
			}
		}
		public function get_OTPTOKEN_BLL($args){
			
			$OTPtoken = middleware::create_OTPtoken($args);
			return $OTPtoken;

		}
		public function get_OTP_verify_BLL($args){
			
			$OTPuser = $args[0];
			$OTPcode = $args[1];
			$decode = middleware::decode_token($OTPuser);

			if($this -> dao -> select_OTP_verify($this->db,$decode['username'],$OTPcode)){
				$this -> dao -> update_OTP_verify($this->db,$decode['username']);
				return 'verify';
			} else {
				return $decode['username'];
				
			}

		}
		public function get_Social_credentials_BLL(){
			$cred = parse_ini_file($_SERVER['DOCUMENT_ROOT'] . '/utils/credentials.ini');


			$credentials = [
				'apiKey'=> $cred['SOCIAL_API'],
				'authDomain' => $cred['SOCIAL_AUTH'],
				'projectId'=> $cred['SOCIAL_PROJECT'],
				'storageBucket'=> $cred['SOCIAL_STORAGEB'],
				'messagingSenderId'=> $cred['SOCIAL_MESSAGING'],
				'appId'=> $cred['SOCIAL_APPID'],
				'measurementId' =>$cred['SOCIAL_MEASUREMENTID']
			];


			return $credentials;
		}

		public function get_social_login_BLL($args) {
			if (!empty($this -> dao -> select_user_social($this->db, $args[1], $args[2],$args[4]))) {
				$user = $this -> dao -> select_user($this->db, $args[1], $args[2]);
				// // $jwt = jwt_process::encode($user[0]['username']);
				// // return json_encode($jwt);
				
				$accesstoken= middleware::create_accesstoken($user[0]["username"],$user[0]["id_user"]);
						$refreshtoken= middleware::create_refreshtoken($user[0]["username"],$user[0]["id_user"]);
						$token = array($accesstoken,$refreshtoken);
						$_SESSION['username'] = $user[0]['username']; //Guardamos el usario 
						$_SESSION['tiempo'] = time();
				return $token;
				// return "hola";
            } else {
				$this -> dao -> insert_social_login($this->db, $args[0], $args[1], $args[2], $args[3],$args[4]);
				$user = $this -> dao -> select_user($this->db, $args[1], $args[2]);
				// //$jwt = jwt_process::encode($user[0]['username']);

				$accesstoken= middleware::create_accesstoken($user[0]["username"],$user[0]["id_user"]);
						$refreshtoken= middleware::create_refreshtoken($user[0]["username"],$user[0]["id_user"]);
						$token = array($accesstoken,$refreshtoken);
						$_SESSION['username'] = $user[0]['username']; //Guardamos el usario 
						$_SESSION['tiempo'] = time();
				return $token;
				// return "hola";
			}
		}

		public function get_verify_email_BLL($args) {
			if($this -> dao -> select_verify_email($this->db, $args)){
				$this -> dao -> update_verify_email($this->db, $args);
				return 'verify';
			} else {
				return 'fail';
			}
		}

		public function get_recover_email_BBL($args) {
			$user = $this -> dao -> select_recover_password($this->db, $args);
			$token = common::generate_Token_secure(20);

			if (!empty($user)) {
				$this -> dao -> update_recover_password($this->db, $args, $token);
                $message = ['type' => 'recover', 
                            'token' => $token, 
                            'toEmail' => $args];
                $email = json_decode(mail::send_email($message), true);
				if (!empty($email)) {
					return;  
				}   
            }else{
                return 'error';
            }
		}


		public function get_verify_token_BLL($args) {
			if($this -> dao -> select_verify_email($this->db, $args)){
				return 'verify';
			}
			return 'fail';
		}

		public function get_new_password_BLL($args) {
			$hashed_pass = password_hash($args[1], PASSWORD_DEFAULT, ['cost' => 12]);
			if($this -> dao -> update_new_passwoord($this->db, $args[0], $hashed_pass)){
				return 'done';
			}
			return 'fail';
		}

		public function get_data_user_BLL($args) {

			$decode = middleware::decode_token($args);
			return $this -> dao -> select_data_user($this->db, $decode['username']);
		}

		public function get_actividad_BLL() {
            if (!isset($_SESSION["tiempo"])) {  
				return "inactivo";
			} else {  
				if((time() - $_SESSION["tiempo"]) >= 1800) {  
						return "inactivo";
				}else{
					return (time() - $_SESSION["tiempo"]);
				}
			}
		}

		public function get_controluser_BLL($args) {
			// $token = explode('"', $args);
			// $void_email = "";
			// $decode = middleware::decode_username($token[1]);
			// $user = $this -> dao -> select_user($this->db, $decode, $void_email);

			// if (!isset ($_SESSION['username']) != $user){
			// 	if(isset ($_SESSION['username']) != $user) {
			// 		return 'not_match';
			// 	}
			// 	return 'match';
			// }
			$token_dec = middleware::decode_token($args);
			
			if (isset($_SESSION['username']) && ($_SESSION['username']) == $token_dec['username']) {
				return "Correct_User";
				exit();
			} else {
				return "Wrong_User";
				exit();
			}
		}

		public function get_refresh_token_BLL($args) {
			$token = explode('"', $args);
			$void_email = "";
			$decode = middleware::decode_username($token[1]);
			$user = $this -> dao -> select_user($this->db, $decode, $void_email);

			$new_token = jwt_process::encode($user[0]['username']);

            return $new_token;
		}

		public function get_expires_BLL($args) {
			// $token = explode('"', $args);
			// $decode = middleware::decode_exp($token[1]);
			
            // if(time() >= $decode) {  
			// 	return "inactivo"; 
			// } else{
			// 	return "activo";
			// }

			$refreshtoken_dec = middleware::decode_token($args[0]);
			$accesstoken_dec = middleware::decode_token($args[1]);
		   
			if ($refreshtoken_dec['exp'] < time()) {
				return "Wrong_User";
			}
			if($accesstoken_dec['username']==$refreshtoken_dec['username']){
				$new_token = middleware::create_accesstoken($refreshtoken_dec['username'],$refreshtoken_dec['id']);
				return $new_token;
			}else{
				return "Wrong_User";
			}





		}
	}