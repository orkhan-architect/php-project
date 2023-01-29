<?php 
define('mcsystem', true);
session_start();
include("inc_blocks/dbblok.php");
include("inc_blocks/functions.php");
	
if($_SESSION['users_role'] == 'user' || $_SESSION['bank_department'] == "system"){
	if($_POST["contract_submit"]){			
		$contractclient = mysqli_real_escape_string($connect_link,defend_input($_POST['cont_clientid']));
		$contractcredit = mysqli_real_escape_string($connect_link,defend_input($_POST['contrcreditid']));
		$enteruser = $_SESSION['auth_admin_login'];
		
		$error = array();
		
		if(!$contractclient){$error[] = "müştərinin PİN ID-ni və ya VÖENi qeyd edin!";}
		if(!$contractcredit){$error[] = "mövcud krediti siyahıdan seçin!";}
		
		if($_POST['pledge'] == 'girovlu'){
		$contractpledge = mysqli_real_escape_string($connect_link,defend_input($_POST['contrpledgeid']));
		$contractpleform = mysqli_real_escape_string($connect_link,defend_input($_POST['contrpleform']));
		$error = array();
		if(!$contractpledge){$error[] = "mövcud girovu siyahıdan seçin!";}
		if(!$contractpleform){$error[] = "girovqoyma formasını siyahıdan seçin!";}
			
		$pledgedb = "pledge_id, pledge_form, ";
		$pledgeval = "'".$contractpledge."', '".$contractpleform."', ";
		}
		
		if(count($error)){
			$_SESSION['msg'] = "<p id='form-error'>".implode('<br>',$error)."</p>";
		}
		else{
			$_SESSION['msg'] = "<p id='form-success'>Müqavilə uğurla bazaya əlavə edildi!</p>";
			mysqli_query($connect_link,"INSERT INTO contract_data($pledgedb client_id, credit_id, printed_user, print_date)
						VALUES(
							$pledgeval
							'".$contractclient."',
							'".$contractcredit."',
							'".$enteruser."',
							NOW()
						)");
		}
	}
}
?>