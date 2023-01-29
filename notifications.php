<?php 
define('mcsystem', true);
session_start();
if($_SESSION['auth'] == 'yes_auth' && $_SESSION['auth_status'] == 'baxıldı'){
include("myblocks/db_connect.php");
include("myblocks/defend.php");
if($_POST["agree_submit"]){
	$agreequery = mysqli_real_escape_string($connect_link,defend_input($_POST['decision_select']));
	$id = mysqli_real_escape_string($connect_link,defend_input($_POST['credorder']));
	
	$decexist = mysqli_query($connect_link, "SELECT guarant_agree FROM cre_orders WHERE id='$id'");
	$rowsdecexist = mysqli_fetch_assoc($decexist);
	if(!isset($rowsdecexist['guarant_agree'])){
	$error = array();
	if(!$agreequery){$error[] = "Zaminlikdən imtina və ya təsdiq rəyinizi bildirin!";}
	if(count($error)){
		$_SESSION['msg'] = "<p id='form-error'>".implode('<br>',$error)."</p>";
	}
	else{
		$_SESSION['msg'] = "<p id='form-success'>Zaminliyə seçdiyiniz uyğun rəyiniz göndərildi!</p>";
		$serip = $_SERVER['REMOTE_ADDR'];
		$agreedecision = "guarant_agree='".$agreequery."',fromguarant=NOW(),guaripadr='".$serip."'";
		$agreeupdate = mysqli_query($connect_link, "UPDATE cre_orders SET $agreedecision WHERE id='$id'");
	}
	}
	else{
		echo 'siz artıq bu kreditlə bağlı qərar vermisiniz';
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
<title>Bildirişlər</title>
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
			<?php include("myblocks/mynotesblock.php")?>
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