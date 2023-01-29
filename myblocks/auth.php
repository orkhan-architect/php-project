<?php 
if($_SERVER["REQUEST_METHOD"] == "POST"){
	define('mcsystem', true);
	include("../myblocks/db_connect.php");
	include("../myblocks/defend.php");
	
    $login = defend_input($_POST["login"]);
	$login = mysqli_real_escape_string($connect_link,$_POST["login"]);
	
    $pass = md5(defend_input($_POST["pass"]));
	$pass = strrev($pass);
    $pass = "3vg2nh3q".$pass."3mo5a";
	
    if($_POST["rememberme"] == "yes"){
		setcookie('rememberme',$login.'+'.$pass,time()+3600*24*31, "/");
    }       
	$resultsiteusers = mysqli_query($connect_link,"SELECT * FROM cstmr_data WHERE (login = '$login') AND passw = '$pass'");
	
	if(mysqli_num_rows($resultsiteusers) > 0){
		$rowsiteusers = mysqli_fetch_assoc($resultsiteusers);
		session_start();
    	$_SESSION['auth'] = 'yes_auth'; 
    	$_SESSION['auth_pass'] = $rowsiteusers["passw"];
    	$_SESSION['auth_login'] = $rowsiteusers["login"];		
    	$_SESSION['auth_ptype'] = $rowsiteusers["person_type"];
    	$_SESSION['auth_client'] = $rowsiteusers["client"];    	
    	$_SESSION['auth_clmails'] = $rowsiteusers["email"];		
		$_SESSION['auth_status'] = $rowsiteusers["status"];
		$_SESSION['bosverify_status'] = $rowsiteusers["verified"];
		$_SESSION['mybranch_status'] = $rowsiteusers["branch_code"];
		
		echo 'yes_auth';
	}
	else{
		echo 'no_auth';
	}  
}
?>