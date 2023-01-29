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
	
	if($_SESSION['users_role'] == 'officer' || $_SESSION['users_role'] == 'user' || $_SESSION['bank_department'] == "system"){
		
		if($_POST["notif_submit"]){
			
		$clientsel = mysqli_real_escape_string($connect_link,defend_input($_POST['clientid_select']));
		$notesel = mysqli_real_escape_string($connect_link,defend_input($_POST['note_select']));
		$notifications = mysqli_real_escape_string($connect_link,defend_input($_POST['form_note']));
		$enteruser = $_SESSION['auth_admin_login'];
		$bosresult = mysqli_query($connect_link,"SELECT compliance FROM users WHERE login='{$_SESSION['auth_admin_login']}'");
		$bosrow = mysqli_fetch_assoc($bosresult);
		$confirmuser = $bosrow["compliance"];
		
		$error = array();
		
		if(!$clientsel){$error[] = "müştərini siyahıdan seçin!";}
		if(!$notesel){$error[] = "müştəriyə göndərilən qeyd növünü siyahıdan seçin!";}
		if(!$notifications){$error[] = "müştəriyə mütləq dərəcədə nəsə yazılmalıdır!";}
		
		if(count($error)){
			$_SESSION['msg'] = "<p id='form-error'>".implode('<br>',$error)."</p>";
		}
		else{
			$_SESSION['msg'] = "<p id='form-success'>Bildiriş uğurla göndərildi!</p>";
			mysqli_query($connect_link,"INSERT INTO notification_data(client, note_type, note_text, bank, note_date, verifingbos)
						VALUES(
							'".$clientsel."',
							'".$notesel."',
							'".$notifications."',
							'".$enteruser."',
							NOW(),
							'".$confirmuser."'
						)");
			}
		}
	};
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="author" content="OR-KHAN">
<link href="css/mystyle.css" rel="stylesheet" type="text/css">
<link href="css/reset.css" rel="stylesheet" type="text/css">
<title>Bildiriş əlavə et</title>
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
		<?php include("inc_blocks/notifadblok.php")?>
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