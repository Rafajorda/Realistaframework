<?php
//$page = isset($_GET['page']) ? $_GET['page'] : 'homepage';
$_GET['page'] = isset($_GET['page']) ? $_GET['page'] : 'homepage';
$page = $_GET['page'];
	switch($_GET['page']){
		case "homepage":
			include("module/home/view/home.html");
			break;
		case "controller_vivienda":
			include("module/home/controller/".$page.".php");
			break;
		case "404":
			include("view/inc/error".$page.".php");
			break;
		case "503":
			include("view/inc/error".$page.".php");
			break;
		case "portfolio":
			include ("portfolio.html");
			break;
		case "shop":
			include ("module/shop/view/shop.html");
			break;
		case "login":
			include ("module/login/view/login-register.html");
			//include("module/login/ctrl/ctrl_login.php");
			break;
		case "contact":
			include ("contact.html");
			break;
		default:
			include("module/home/view/home.html");
			break;
		
	}
?>