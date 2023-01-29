<?php 
	if($_SERVER["REQUEST_METHOD"] == "POST"){
		define('mcsystem', true);
		include("../myblocks/db_connect.php");
		include("../myblocks/defend.php");
		$login = mysqli_real_escape_string($connect_link, defend_input($_POST['form_login']));
		$resultlogusers = mysqli_query($connect_link,"SELECT login FROM cstmr_data WHERE login = '$login'");
		if(mysqli_num_rows($resultlogusers) > 0){
			echo 'false';
		}
		else{
			echo 'true'; 
		}
	}
?>