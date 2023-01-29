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
		if($_POST["notifreset_submit"]){
		$_SESSION['msg'] = "<p id='form-success'>Bildiriş redaktə üçün geri qaytarıldı!</p>";
		
		$bosnotifreset = "note_date=null, verifydate=null, verified=null";
		
		$notifresetupdate = mysqli_query($connect_link, "UPDATE notification_data SET $bosnotifreset WHERE id='$id'");}
	}
	
	if($_SESSION['users_role'] == 'verifier' || $_SESSION['users_role'] == 'manager' || $_SESSION['bank_department'] == "system"){
		if($_POST["noteconfirm_submit"]){
			$confbos = $_SESSION['auth_admin_login'];
		
			$_SESSION['msg'] = "<p id='form-success'>Təsdiqlənmə uğurla sona yetdi!</p>";
		
			$bossconfirm = "verified='yes', verifingbos='".$confbos."', verifydate=NOW()";
		
			$bconfupdate = mysqli_query($connect_link, "UPDATE notification_data SET $bossconfirm WHERE id='$id'");}
	}
	
	if($_SESSION['users_role'] == 'officer' || $_SESSION['users_role'] == 'user' || $_SESSION['bank_department'] == "system"){
		
		if($_POST["notifedit_submit"]){
			
		$clientsel = mysqli_real_escape_string($connect_link,defend_input($_POST['clientid_select']));
		$notesel = mysqli_real_escape_string($connect_link,defend_input($_POST['note_select']));
		$notifications = mysqli_real_escape_string($connect_link,defend_input($_POST['form_note']));
		
		$error = array();
		
		if(!$clientsel){$error[] = "müştərini siyahıdan seçin!";}
		if(!$notesel){$error[] = "müştəriyə göndərilən qeyd növünü siyahıdan seçin!";}
		if(!$notifications){$error[] = "müştəriyə mütləq dərəcədə nəsə yazılmalıdır!";}
		
		if(count($error)){
			$_SESSION['msg'] = "<p id='form-error'>".implode('<br>',$error)."</p>";
		}
		else{
			$_SESSION['msg'] = "<p id='form-success'>Bildiriş uğurla redaktə edildi!</p>";
			
			$notifedit = "client='".$clientsel."', note_type='".$notesel."', note_text='".$notifications."', note_date=NOW()";
				
			$notifupdate = mysqli_query($connect_link, "UPDATE notification_data SET $notifedit WHERE id='$id'");
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
<title>Müştəri bildirişinə bax</title>
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
		<?php include("inc_blocks/vnotifblok.php")?>
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