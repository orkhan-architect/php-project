<?php 
if($_SERVER["REQUEST_METHOD"] == "POST"){
	session_start();
	if($_SESSION['captcha_code'] == strtolower($_POST['captcha_code'])){
		echo 'true';
	}
	else{
		echo 'false';
	}
}
?>