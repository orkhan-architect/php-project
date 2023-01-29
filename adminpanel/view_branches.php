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
	
	if($_SESSION['users_role'] == 'admin'){		
		if($_POST["branchedit_submit"]){
			
		$branchname = mysqli_real_escape_string($connect_link,defend_input($_POST['form_branchname']));
		$branchcity = mysqli_real_escape_string($connect_link,defend_input($_POST['form_branchcity']));
		$branchcode = mysqli_real_escape_string($connect_link,defend_input($_POST['form_branchcode']));
		$bosspost = mysqli_real_escape_string($connect_link,defend_input($_POST['form_bosspost']));
		$branchboss = mysqli_real_escape_string($connect_link,defend_input($_POST['form_branchboss']));
		$address = mysqli_real_escape_string($connect_link,defend_input($_POST['form_address']));
		$brdata = mysqli_real_escape_string($connect_link,defend_input($_POST['form_brdata']));
		
		$error = array();
		
		if(!$branchname){$error[] = "filialı qeyd edin!";}
		if(!$branchcity){$error[] = "filialın yerləşdiyi şəhəri və ya rayonu qeyd edin!";}
		if(!$branchcode){$error[] = "filialın kodunu qeyd edin!";}
		if(!$bosspost){$error[] = "filialın rəhbər vəzifəsini qeyd edin!";}
		if(!$branchboss){$error[] = "filial rəhbərininin ASA qeyd edin!";}
		if(!$address){$error[] = "filialın ünvanını tam qeyd edin!";}
		if(!$brdata){$error[] = "filialın rekvizitlərini tam qeyd edin!";}
		
		if(count($error)){
			$_SESSION['msg'] = "<p id='form-error'>".implode('<br>',$error)."</p>";
		}
		else{
			$_SESSION['msg'] = "<p id='form-success'>Filial uğurla dəyişdi!</p>";
			
			$branchedit = "branch_code='".$branchcode."', full_name='".$branchname."', region='".$branchcity."', address='".$address."', boss_post='".$bosspost."', branch_boss='".$branchboss."', branch_properties='".$brdata."'";
				
			$branchupdate = mysqli_query($connect_link, "UPDATE branches SET $branchedit WHERE id='$id'");
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
		<?php include("inc_blocks/vbranchblok.php")?>
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