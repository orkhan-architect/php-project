<?php 
define('mcsystem', true);
include("myblocks/db_connect.php");
session_start();
include("myblocks/auth_cookie.php");
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
<title>Filiallar və əməkdaşlarımız</title>
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
			<?php include("myblocks/branchblock.php")?>
		</div>
		<div class="container">
			<?php include("myblocks/authorblock.php")?>
		</div>
	</div>
</body>
</html>