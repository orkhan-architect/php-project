<?php 
if($_SERVER["REQUEST_METHOD"] == "POST"){
	define('mcsystem', true);
	include("db_connect.php");
	include("defend.php");

	$email = mysqli_real_escape_string($connect_link,defend_input($_POST["email"]));
		
	if($email != ""){    
		$resultmailque = mysqli_query($connect_link,"SELECT email FROM cstmr_data WHERE email='$email'");
		if(mysqli_num_rows($resultmailque) > 0){
			$newpass = fungenpass();
			$pass = md5($newpass);
			$pass = strrev($pass);
			$pass = strtolower("3vg2nh3q".$pass."3mo5a");
			$updatemailus = mysqli_query($connect_link,"UPDATE cstmr_data SET passw='$pass' WHERE email='$email'");   
			send_mail('orxan_tuk_muh@hotmail.com',
			             $email,
						'mgcresys.az saytı üçün yeni şifrə',
						'Sizin şifrə: '.$newpass);   
				echo 'yes';    
		}
		else{
			echo 'Göstərilən E-mail tapılmadı!';
		}
	}
	else{
		echo 'E-mail ünvanınızı göstərin';
	}
}
?>