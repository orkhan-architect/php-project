<?php 
define('mcsystem', true);
session_start();
if ($_SESSION['bosverify_status'] == 'yes' && $_SESSION['auth'] == 'yes_auth'){
	include("myblocks/db_connect.php");
	include("myblocks/defend.php");
	if($_POST["save_submit"]){	
	
	$plivadres = mysqli_real_escape_string($connect_link,defend_input($_POST['profil_ladres']));
	$pphonenum = mysqli_real_escape_string($connect_link,defend_input($_POST['profil_phonumb']));
	$pclmails = strtolower(mysqli_real_escape_string($connect_link,defend_input($_POST['profil_email'])));
	$pborro = mysqli_real_escape_string($connect_link,defend_input($_POST['pborrower']));
	$pguaran = mysqli_real_escape_string($connect_link,defend_input($_POST['pguarant']));
	$pmortg = mysqli_real_escape_string($connect_link,defend_input($_POST['pcoll']));
	$pmincap = mysqli_real_escape_string($connect_link,defend_input($_POST['profil_lesscap']));
	$pinval = mysqli_real_escape_string($connect_link,defend_input($_POST['profil_invalid']));
	$pcnotes = mysqli_real_escape_string($connect_link,defend_input($_POST['profil_clientnotes']));
		
		$error = array();
		
    	$pass = md5($_POST["profi_pasvor"]);
    	$pass = strrev($pass);
    	$pass = "3vg2nh3q".$pass."3mo5a";
		
		if($_SESSION['auth_pass'] != $pass){
			$error[]='Hazırki şifrə düzgün deyil!';
		}
		else{        
			if($_POST["profi_nepasvor"] != ""){
				if(strlen($_POST["profi_nepasvor"]) < 7 || strlen($_POST["profi_nepasvor"]) > 12){
					$error[]='7-12 simvol aralığı yeni şifrəni daxil edin!';
	            }
				else{
					$newpass = md5(defend_input($_POST["profi_nepasvor"]));					
					$newpass = md5(mysqli_real_escape_string($connect_link,$_POST["profi_nepasvor"]));	
					$newpass = strrev($newpass);
					$newpass = "3vg2nh3q".$newpass."3mo5a";
					$newpassquery = "passw='".$newpass."',";
                }
			}	
	
	if(!$plivadres){$error[] = "Yaşadığınız ünvanı qeyd edin!";}
    if(!filter_var($pclmails, FILTER_VALIDATE_EMAIL)){$error[] = "Düzgün email ünvan daxil edin!";}
    if(!$pphonenum){$error[] = "Telefon nömrələrini qeyd edin!";}
	if(!$pmincap){$error[] = "Aztəminatlı olub-olmadığınızı qeyd edin!";}
	if(!$pinval){$error[] = "Əlil olub-olmadığınızı qeyd edin!";}
		}    
		if(count($error)){
			$_SESSION['msg'] = "<p id='form-error'>".implode('<br>',$error)."</p>";
		}
		else{
        	$_SESSION['msg'] = "<p id='form-success'>Dəyişikliklər uğurla yaddaşa verildi!</p>";
			$dataquery = $newpassquery."liv_address='$plivadres', phone='$pphonenum', email='$pclmails', debtor='$pborro', guarantor='$pguaran', mortgagor='$pmortg', minicapital='$pmincap', invalidity='$pinval', customer_notes='$pcnotes'";
			
			$update = mysqli_query($connect_link,"UPDATE cstmr_data SET $dataquery WHERE login = '{$_SESSION['auth_login']}'");
			
			if($newpass){ $_SESSION['auth_pass'] = $newpass; }        
		}        
	}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="css/mystyles.css">
<title>T.O.M. CCS - profilim</title>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
<script src="jscript/myscripts.js"></script>
</head>

<body>
	<div class="container">
		<?php include("myblocks/navblock.php")?>
		<button type="button" class="btn btn-danger w-100" data-toggle="collapse" data-target="#openclose">PROFİLƏ GİRİŞ görüntüsünü aç/bağla</button>
		<div id="openclose" class="collapse">
			<div class="container">
				<?php include("myblocks/headblock.php")?>
			</div>
		</div>
		<div class="container">
			<?php include("myblocks/profinotesblock.php")?>
		</div>
		<div class="container">
			<?php include("myblocks/profiblock.php")?>
		</div>
		<div class="container">
			<?php include("myblocks/authorblock.php")?>
		</div>
	</div>
</body>
</html>
<?php 
}
else{
	header("Location: index");
} 
?>