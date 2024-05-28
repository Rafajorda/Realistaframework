<?php
    class login_dao {
        static $_instance;

        private function __construct() {
        }

        public static function getInstance() {
            if(!(self::$_instance instanceof self)){
                self::$_instance = new self();
            }
            return self::$_instance;
        }

        public function insert_user($db, $username, $hashed_pass, $email, $avatar, $token_email) {
           
            $sql ="   INSERT INTO `users`(`username`, `password`, `email`, `type_user`, `avatar`, token_email, activate,fails,OTP,origin) 
            VALUES ('$username','$hashed_pass','$email','client','$avatar','$token_email', 0,0,000000,'local')";

            // $sql = "INSERT INTO users (id, username, password, email, user_type, avatar, token_email, activate)
            // VALUES ('$id', '$username_reg', '$hashed_pass', '$email_reg', 'client', '$avatar', '$token_email', 0)";

            return $stmt = $db->ejecutar($sql);
        }
       
        public function select_user($db, $username,$email){
            $sql = "SELECT `id_user`,`username`, `password`, `email`, `type_user`, `avatar`, `token_email`, `activate`, `fails`, `OTP`, `origin` FROM `users` WHERE username='$username'";

            $stmt = $db->ejecutar($sql);
                return $db->listar($stmt);
            
        }
        public function select_user_Social($db, $username,$email,$origin){
            $sql = "SELECT `id_user`,`username`, `password`, `email`, `type_user`, `avatar`, `token_email`, `activate`, `fails`, `OTP`, `origin` FROM `users` WHERE username='$username'AND `origin` = '$origin'";

            $stmt = $db->ejecutar($sql);
                return $db->listar($stmt);
            
        }

        public function select_social_login($db, $id){

			$sql = "SELECT * FROM users WHERE id='$id'";
            $stmt = $db->ejecutar($sql);

            return $db->listar($stmt);
        }


        public function insert_social_login($db, $id, $username, $email, $avatar, $param) {
            $emailp = $email . '_' . $param;
            $sql = "INSERT INTO users (username, password, email, type_user, avatar, token_email, activate, fails, OTP, origin, UID)     
                    VALUES ('$username', '', '$emailp', 'client', '$avatar', '', 1, 0, '000000', '$param', '$id')";
        
            return $db->ejecutar($sql);
        }

        public function select_verify_email($db, $token_email){

			$sql = "SELECT token_email FROM users WHERE token_email = '$token_email'";

            $stmt = $db->ejecutar($sql);
            return $db->listar($stmt);
        } 

        public function select_OTP_verify($db, $username,$OTP){

			$sql = "SELECT username FROM users WHERE username = '$username' AND OTP = '$OTP'";

            $stmt = $db->ejecutar($sql);
            return $db->listar($stmt);
        } 

        public function update_OTP_verify($db, $username){

            $sql = "UPDATE users SET activate = 1 WHERE username = '$username'";

            $stmt = $db->ejecutar($sql);
            return "update";
        }

        public function reset_fails($db, $username){

            $sql = "UPDATE users SET fails = 0 WHERE username = '$username'";

            $stmt = $db->ejecutar($sql);
            return "update";

        }
        public function update_verify_email($db, $token_email){

            $sql = "UPDATE users SET activate = 1, token_email= '' WHERE token_email = '$token_email'";

            $stmt = $db->ejecutar($sql);
            return "update";
        }
        public function set_active($db,$username){
            $sql = "UPDATE users SET activate = 0 WHERE username='$username'";
            $stmt = $db->ejecutar($sql);
            return "failure";

        }

        public function select_recover_password($db, $email){
			$sql = "SELECT `email` FROM `users` WHERE email = '$email' AND password NOT LIKE ('')";
            $stmt = $db->ejecutar($sql);
            return $db->listar($stmt);
        }

        


        public function update_recover_password($db, $email, $token_email){
			$sql = "UPDATE `users` SET `token_email`= '$token_email' WHERE `email` = '$email'";
            $stmt = $db->ejecutar($sql);
            return "ok";
        }

        public function update_new_passwoord($db, $token_email, $password){
            $sql = "UPDATE `users` SET `password`= '$password', `token_email`= '' WHERE `token_email` = '$token_email'";
            $stmt = $db->ejecutar($sql);
            return "ok";
        }




        public function select_data_user($db, $username){

			$sql =  "SELECT * FROM users WHERE username='$username'";
            
            $stmt = $db->ejecutar($sql);
            return $db->listar($stmt);
            
        }
        public function seecount($db, $username){

			$sql =  "SELECT fails FROM users WHERE username='$username'";
            
            $stmt = $db->ejecutar($sql);
             $result=  $db->listar($stmt);
             return $result[0]['fails'];
        }
        public function addcount($db, $username){

			$sql = "UPDATE users SET fails= fails + 1 WHERE username='$username'";
            
            $stmt = $db->ejecutar($sql);
            return "ouch";
        }
        public function rescount($db, $username){

			$sql = "UPDATE users SET fails =0 WHERE username='$username'";
            
            $stmt = $db->ejecutar($sql);
           return "done";
        }
        public function addOTP($db, $username,$OTP){

			$sql = "UPDATE users SET OTP=  $OTP WHERE username='$username'";
            
            $stmt = $db->ejecutar($sql);
            return "ouch";
        }

       


    }

?>