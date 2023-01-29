<?php 
defined('mcsystem') or die('Cəhdin yaxşı idi, sərf etdiyin vaxtı başqa şeyə sərf et!');
if($_SESSION['auth'] != 'yes_auth' && $_COOKIE["rememberme"]){    
	$str = $_COOKIE["rememberme"];
	$all_len = strlen($str);
	$login_len = strpos($str,'+');
		
	$login = defend_input(substr($str,0,$login_len));
	$login = mysqli_real_escape_string($connect_link,substr($str,0,$login_len));
		
	$pass = defend_input(substr($str,$login_len+1,$all_len)); 
	$pass = mysqli_real_escape_string($connect_link,substr($str,$login_len+1,$all_len));
		
	$resultuserscookies = mysqli_query($connect_link,"SELECT * FROM cstmr_data WHERE (login = '$login') AND passw = '$pass'");
		
	if(mysqli_num_rows($resultuserscookies) > 0){
		$rowuserscookies = mysqli_fetch_assoc($resultuserscookies);
		session_start();
		$_SESSION['auth'] = 'yes_auth'; 
		$_SESSION['auth_pass'] = $rowuserscookies["passw"];
    	$_SESSION['auth_login'] = $rowuserscookies["login"];		
    	$_SESSION['auth_ptype'] = $rowuserscookies["person_type"];
    	$_SESSION['auth_client'] = $rowuserscookies["client"];    	
    	$_SESSION['auth_clmails'] = $rowuserscookies["email"];		
		$_SESSION['auth_status'] = $rowuserscookies["status"];
		$_SESSION['bosverify_status'] = $rowuserscookies["verified"];
		$_SESSION['mybranch_status'] = $rowuserscookies["branch_code"];
	}  
}
?>