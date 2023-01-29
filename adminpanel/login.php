<?php 
define('mcsystem', true);
session_start();
include("inc_blocks/dbblok.php");
include("inc_blocks/functions.php");
if($_POST["submit_enter"]){
    $login = mysqli_real_escape_string($connect_link,defend_input($_POST["input_login"]));
    $pass  = mysqli_real_escape_string($connect_link,defend_input($_POST["input_pass"]));
	if($login && $pass){
    	$pass = md5($pass);
    	$pass = strrev($pass);
    	$pass = strtolower("mb03foo33".$pass."qj2jjd55");
   		$result = mysqli_query($connect_link,"SELECT * FROM users WHERE login = '$login' AND pass = '$pass'");  
		if(mysqli_num_rows($result) > 0){
			$row = mysqli_fetch_assoc($result);
    		$_SESSION['auth_admin'] = 'yes_auth'; 
    		$_SESSION['auth_admin_login'] = $row["login"];
			$_SESSION['user_branch'] = $row["branch"];
			$_SESSION['bank_department'] = $row["department"];
			$_SESSION['users_role'] = $row["role"];
			$_SESSION['customer_view'] = $row["view_customer"];
			$_SESSION['customer_edit'] = $row["edit_customer"];
			$_SESSION['order_view'] = $row["view_order"];
			$_SESSION['order_edit'] = $row["edit_order"];
			$_SESSION['credit_view'] = $row["view_credit"];
			$_SESSION['credit_edit'] = $row["edit_credit"];
			$_SESSION['pledge_view'] = $row["view_pledge"];
			$_SESSION['pledge_edit'] = $row["edit_pledge"];
			$_SESSION['concat_view'] = $row["view_concat"];
			$_SESSION['concat_edit'] = $row["edit_concat"];
			$_SESSION['notif_view'] = $row["view_notif"];
			$_SESSION['notif_edit'] = $row["edit_notif"];
			header("Location: index");
		}
        else{
        	$msgerror = "Login və(və ya) Şifrə düzgün deyil.";
		}        
	}
    else{
		$msgerror = "Bütün sahələri doldurun!";
    } 
}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="author" content="OR-KHAN">
<link rel="stylesheet" type="text/css" href="css/reset.css">
<link rel="stylesheet" type="text/css" href="css/style-login.css">
<title>İdarəetmə paneli - GİRİŞ</title>
</head>

<body>
	<div id="block-pass-login">
	<?php 	
    if($msgerror){
		echo '<p id="msgerror" >'.$msgerror.'</p>';        
    }    
	?>
		<form method="post" >
			<ul id="pass-login">
				<li><label>Login</label><input type="text" name="input_login" /></li>
				<li><label>Şifrə</label><input type="password" name="input_pass" /></li>
			</ul>
			<p align="right"><input type="submit" name="submit_enter" id="submit_enter" value="Giriş" /></p>
		</form>
	</div>
</body>
</html>
