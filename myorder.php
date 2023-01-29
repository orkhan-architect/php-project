<?php 
define('mcsystem', true);
session_start();
if($_SESSION['auth'] == 'yes_auth' && $_SESSION['bosverify_status'] == 'yes'){
include("myblocks/db_connect.php");
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="css/mystyles.css">
<title>Kredit sifariş et</title>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
<script src="jscript/myscripts.js"></script>
<script src="jscript/jquery.form.js"></script>
<script src="jscript/jquery.validate.js"></script>
<script src="jscript/orderuser.js"></script>
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
			<?php include("myblocks/verorderblock.php")?>
		</div>
		<div class="container">
			<?php include("myblocks/curorderblock.php")?>
		</div>
		<div class="container">
			<?php include("myblocks/orderblock.php")?>
		</div>
		<button style="font-size: 19px;" type="button" class="btn btn-success w-100 mt-2 font-weight-bold" data-toggle="collapse" data-target="#openclosehm">Sifarişə yardımçı məlumatları göstər/gizlət</button>
		<div id="openclosehm" class="collapse">
			<div class="container">
				<?php include("myblocks/ordernotesblock.php")?>
			</div>
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