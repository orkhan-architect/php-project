<?php 
define('mcsystem', true);
session_start();
include("myblocks/db_connect.php");
if ($_SESSION['auth'] == 'yes_auth' && $_SESSION['auth_status'] == 'baxıldı'){
	header("Location: index");
}
else{
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="description" content="Azərbaycanda ilk geniş onlayn kredit sistemi">
<meta name="keywords" content="istehlak krediti, biznes krediti, daşınmaz əmlak krediti, onlayn müraciət, bildirişlər, geniş izah, bəsit qeydiyyat, bankdakı kredit tarixçəsini izləmə">
<meta name="author" content="OR-KHAN">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="css/mystyles.css">
<title>Qeydiyyat</title>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
<script src="jscript/myscripts.js"></script>
<script src="jscript/jquery.form.js"></script>
<script src="jscript/jquery.validate.js"></script>
<script src="jscript/regisuser.js"></script>
</head>

<body>
	<div class="container">
		<?php include("myblocks/navblock.php")?>
		<button style="font-size: 19px;" type="button" class="btn btn-danger w-100 font-weight-bold" data-toggle="collapse" data-target="#openclose">PROFİLƏ GİRİŞ görüntüsünü aç/bağla</button>
		<div id="openclose" class="collapse">
			<div class="container">
				<?php include("myblocks/headblock.php")?>
			</div>
		</div>
		<p id="reg_message"></p>
		<div class="container">
			<?php include("myblocks/regblock.php")?>
		</div>
		<button style="font-size: 19px;" type="button" class="btn btn-success w-100 mt-2 font-weight-bold" data-toggle="collapse" data-target="#openclosehm">Qeydiyyata yardımçı məlumatları göstər/gizlət</button>
		<div id="openclosehm" class="collapse">
			<div class="container">
				<?php include("myblocks/regnotesblock.php")?>
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
?>