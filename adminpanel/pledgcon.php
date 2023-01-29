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
	
	if($_SESSION['users_role'] == 'officer' || $_SESSION['bank_department'] == "system"){
		if($_POST["concatenate_submit"]){
			
		$creditsel = mysqli_real_escape_string($connect_link,defend_input($_POST['credit_select']));
		$pledgesel = mysqli_real_escape_string($connect_link,defend_input($_POST['pledge_select']));
		$contractsel = mysqli_real_escape_string($connect_link,defend_input($_POST['contract_select']));
		$contractdate = mysqli_real_escape_string($connect_link,defend_input($_POST['form_contractdate']));
		$credofficer = $_SESSION['auth_admin_login'];
		$ver_res = mysqli_query($connect_link,"SELECT compliance FROM users WHERE login='{$_SESSION['auth_admin_login']}'");
		$ver_row = mysqli_fetch_assoc($ver_res);
		$credverifier = $ver_row['compliance'];
		
		$error = array();
		
		if(!$creditsel){$error[] = "girov qoyulacaq krediti siyahıdan seçin!";}
		if(!$pledgesel){$error[] = "bərkidilən girovu siyahıdan seçin!";}
		if(!$contractsel){$error[] = "girovun müqavilə növünü siyahıdan seçin!";}
		if(!$contractdate){$error[] = "girovun rəsmiləşmə tarixini qeyd edin!";}
		
		if(count($error)){
			$_SESSION['msg'] = "<p id='form-error'>".implode('<br>',$error)."</p>";
		}
		else{
			$_SESSION['msg'] = "<p id='form-success'>Bərkidilmə uğurla yaddaşa verildi!</p>";
			mysqli_query($connect_link,"INSERT INTO pledge_concat(credit_id, pledge_id, contract_type, start_date, officer, verifier, enter_date)
						VALUES(
							'".$creditsel."',
							'".$pledgesel."',
							'".$contractsel."',
							'".$contractdate."',
							'".$credofficer."',
							'".$credverifier."',
							NOW()
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
<title>Girov birləşdir</title>
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
		<?php include("inc_blocks/pleconcablok.php")?>
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