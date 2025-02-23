<?php
    class controller_login {

        static $instance;

        
        function __construct() {}

        static function getInstance() {
            if (self::$instance === null) {
                self::$instance = new self();
            }
            return self::$instance;
        }

        function view() {
            common::load_view('top_page_login.html', VIEW_PATH_LOGIN . 'login.html');
        }

        function recover_view() {
            common::load_view('top_page_login.html', VIEW_PATH_LOGIN . 'recover_pass.html');
        }
    
        function login() {
            echo json_encode(common::load_model('login_model', 'get_login', [$_POST['username'], $_POST['password']]));
        }

        function register() {
              echo json_encode(common::load_model('login_model','get_register', [$_POST['username'], $_POST['password'], $_POST['email']]));     
        }

        function social_login() {
            echo json_encode(common::load_model('login_model', 'get_social_login', [$_POST['id'], $_POST['username'], $_POST['email'], $_POST['avatar'], $_POST['type']]));
        } 
    
        function verify_email() {
            $verify = json_encode(common::load_model('login_model', 'get_verify_email', $_POST['token_email']));
            echo json_encode($verify);
        }

        function send_recover_email() {
            echo json_encode(common::load_model('login_model', 'get_recover_email', $_POST['email_forg']));
        }

        function verify_token() {
            echo json_encode(common::load_model('login_model', 'get_verify_token', $_POST['token_email']));
        }

        function new_password() {
            echo json_encode(common::load_model('login_model', 'get_new_password', [$_POST['token_email'], $_POST['password']]));
        }  
    
        function logout() {

            unset($_SESSION['username']);
            unset($_SESSION['tiempo']);
            session_destroy();
            echo json_encode('Done');
        } 

        function data_user() {
            echo json_encode(common::load_model('login_model', 'get_data_user', $_POST['accesstoken']));
        }

        function actividad() {
            echo json_encode(common::load_model('login_model', 'get_activity'));
        }

        function controluser() {
            echo json_encode(common::load_model('login_model', 'get_controluser', $_POST['accesstoken']));
        }

        function refresh_token() {
            echo json_encode(common::load_model('login_model', 'get_refresh_token', [$_POST['accesstoken'], $_POST['refreshtoken']]));
        } 
        
        function expires() {
            echo json_encode(common::load_model('login_model', 'get_expires', [$_POST['accesstoken'], $_POST['refreshtoken']]));
        }

        function refresh_cookie() {
            session_regenerate_id();
        } 
        function OTPTOKEN(){
            echo json_encode(common::load_model('login_model', 'get_OTPTOKEN', $_POST['username']));
        }
        function OTP_verify(){
            echo json_encode(common::load_model('login_model', 'get_OTP_verify',[$_POST['OTPuser'],$_POST['OTPcode']]));
        }
        function Social_credentials(){
            echo json_encode(common::load_model('login_model', 'get_Social_credentials'));
        }
    
    }
    
?>