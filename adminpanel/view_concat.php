<?php 
define('mcsystem', true);
session_start();
if($_SESSION['auth_admin'] == "yes_auth"){      
	if(isset($_GET["logout"])){
		unset($_SESSION['auth_admin']);
        header("Location: login");
    }
	include("inc_blocks/dbblok.php");
	include("inc_blocks/functions.php");
	
	$id = mysqli_real_escape_string($connect_link,defend_input($_GET["id"]));
	
	if($_SESSION['bank_department'] == "system"){
		if($_POST["concatreset_submit"]){
		$_SESSION['msg'] = "<p id='form-success'>Birləşmə redaktə üçün geri qaytarıldı!</p>";
		
		$bosconcreset = "enter_date=null, verify_date=null, verified=null";
		
		$concresetupdate = mysqli_query($connect_link, "UPDATE pledge_concat SET $bosconcreset WHERE id='$id'");}
	}
	
	if($_SESSION['users_role'] == 'verifier' || $_SESSION['bank_department'] == "system"){
		
	if($_POST["concatconfirm_submit"]){
		$concverifier = $_SESSION['auth_admin_login'];
		$_SESSION['msg'] = "<p id='form-success'>Birləşmə uğurla təsdiqləndi!</p>";
		$bosconconfirm = "verify_date=NOW(), verified='yes', verifier='".$concverifier."'";
		$conconfirmupdate = mysqli_query($connect_link, "UPDATE pledge_concat SET $bosconconfirm WHERE id='$id'");}
	}
	
	if($_SESSION['users_role'] == 'officer' || $_SESSION['bank_department'] == "system"){
		if($_POST["updconc_submit"]){
			
		$creditsel = mysqli_real_escape_string($connect_link,defend_input($_POST['credit_select']));
		$pledgesel = mysqli_real_escape_string($connect_link,defend_input($_POST['pledge_select']));
		$contractsel = mysqli_real_escape_string($connect_link,defend_input($_POST['contract_select']));
		$contractdate = mysqli_real_escape_string($connect_link,defend_input($_POST['form_contractdate']));
		$endindate = mysqli_real_escape_string($connect_link,defend_input($_POST['form_endate']));
		
		$error = array();
		
		if(!$creditsel){$error[] = "girov qoyulacaq krediti siyahıdan seçin!";}
		if(!$pledgesel){$error[] = "bərkidilən girovu siyahıdan seçin!";}
		if(!$contractsel){$error[] = "girovun müqavilə növünü siyahıdan seçin!";}
		if(!$contractdate){$error[] = "girovun rəsmiləşmə tarixini qeyd edin!";}
			
			if(count($error)){
				$_SESSION['msg'] = "<p id='form-error'>".implode('<br>',$error)."</p>";
			}
			else{
				$_SESSION['msg'] = "<p id='form-success'>Birləşmə redaktə edildi!</p>";
				
				$concedit = "credit_id='".$creditsel."', pledge_id='".$pledgesel."', contract_type='".$contractsel."', start_date='".$contractdate."', enter_date=NOW(), end_date='".$endindate."'";
				
				$concupdate = mysqli_query($connect_link, "UPDATE pledge_concat SET $concedit WHERE id='$id'");
			}
		}
	}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="author" content="OR-KHAN">
<link href="css/mystyle.css" rel="stylesheet" type="text/css">
<link href="css/reset.css" rel="stylesheet" type="text/css">
<title>Girov birləşməsinə bax</title>
</head>

<body>
<div id="anablok">
	<div id="basblok">
		<div id="titrblok">
			<?php include("inc_blocks/trblok.php")?>
		</div>
		<div id="ilkblok">
			<?php include("inc_blocks/hmeblok.php")?>
		</div>
	</div>
	<div id="altmenyu">
		<?php include("inc_blocks/dmblok.php")?>
	</div>
	<div id="esasblok">
		<?php include("inc_blocks/vconcblok.php")?>
	</div>
</div>
</body>
</html>
<?php 
}
else{
	header("Location: login");
}
?>