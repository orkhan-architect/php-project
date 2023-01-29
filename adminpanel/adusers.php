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
	
	if($_SESSION['users_role'] == 'admin'){		
		if($_POST["user_submit"]){
			
		$usernsp = mysqli_real_escape_string($connect_link,defend_input($_POST['form_nsp']));
		$usermail = mysqli_real_escape_string($connect_link,defend_input($_POST['form_usermail']));
		$userphone = mysqli_real_escape_string($connect_link,defend_input($_POST['form_userphone']));
		$userbrcode = mysqli_real_escape_string($connect_link,defend_input($_POST['branchcode_select']));
		$userbrname = mysqli_real_escape_string($connect_link,defend_input($_POST['branchname_select']));
		$userdepart = mysqli_real_escape_string($connect_link,defend_input($_POST['department_select']));
		$userrole = mysqli_real_escape_string($connect_link,defend_input($_POST['role_select']));
		$usercompli = mysqli_real_escape_string($connect_link,defend_input($_POST['compliance_select']));
		$usermsh = mysqli_real_escape_string($connect_link,defend_input($_POST['msh']));
		$userih = mysqli_real_escape_string($connect_link,defend_input($_POST['ih']));
		$userkk = mysqli_real_escape_string($connect_link,defend_input($_POST['kk']));
		$userkkk = mysqli_real_escape_string($connect_link,defend_input($_POST['kkk']));
		$uservcus = mysqli_real_escape_string($connect_link,defend_input($_POST['view_customer']));
		$userecus = mysqli_real_escape_string($connect_link,defend_input($_POST['edit_customer']));
		$uservord = mysqli_real_escape_string($connect_link,defend_input($_POST['view_order']));
		$usereord = mysqli_real_escape_string($connect_link,defend_input($_POST['edit_order']));
		$uservcre = mysqli_real_escape_string($connect_link,defend_input($_POST['view_credit']));
		$userecre = mysqli_real_escape_string($connect_link,defend_input($_POST['edit_credit']));
		$uservple = mysqli_real_escape_string($connect_link,defend_input($_POST['view_pledge']));
		$usereple = mysqli_real_escape_string($connect_link,defend_input($_POST['edit_pledge']));
		$uservcon = mysqli_real_escape_string($connect_link,defend_input($_POST['view_concat']));
		$userecon = mysqli_real_escape_string($connect_link,defend_input($_POST['edit_concat']));
		$uservnot = mysqli_real_escape_string($connect_link,defend_input($_POST['view_notif']));
		$userenot = mysqli_real_escape_string($connect_link,defend_input($_POST['edit_notif']));
			
		$error = array();
			
		if(!$usernsp){$error[] = "istifadəçi ASA qeyd edin!";}
		if(!filter_var($usermail, FILTER_VALIDATE_EMAIL)){$error[] = "Düzgün email ünvan daxil edin!";}
		if(!$userphone){$error[] = "istifadəçi telefonunu qeyd edin!";}
		if(!$userbrcode){$error[] = "istifadəçinin filial kodunu qeyd edin!";}
		if(!$userbrname){$error[] = "istifadəçinin filial adını qeyd edin!";}
		if(!$userdepart){$error[] = "istifadəçinin departamentini qeyd edin!";}
		if(!$userrole){$error[] = "istifadəçinin vəzifəsini qeyd edin!";}
		if(!$usercompli){$error[] = "istifadəçinin asılılığını qeyd edin!";}
			
		if($_POST["form_login"]){
        	$login = mysqli_real_escape_string($connect_link,defend_input($_POST['form_login']));
        	$query = mysqli_query($connect_link,"SELECT login FROM users WHERE login='$login'"); 
     		if(mysqli_num_rows($query) > 0){$error[] = "Login mövcuddur!";}
		}
		else{
        	$error[] = "Logini göstərin!";
    	}
		
		if(count($error)){
			$_SESSION['msg'] = "<p id='form-error'>".implode('<br>',$error)."</p>";
		}
		else{
			$_SESSION['msg'] = "<p id='form-success'>İstifadəçi uğurla əlavə edildi!</p>";
			
			$pass = md5(defend_input($_POST["form_passv"]));
    		$pass = strrev($pass);
    		$pass = strtolower("mb03foo33".$pass."qj2jjd55");
			
			mysqli_query($connect_link,"INSERT INTO users(login, pass, nsp, branch, branch_fullname, department, role, compliance, email, phone, msh, ih, kk, kkk, view_customer, edit_customer, view_order, edit_order, view_credit, edit_credit, view_pledge, edit_pledge, view_concat, edit_concat, view_notif, edit_notif)
						VALUES(
							'".$login."',
							'".$pass."',
							'".$usernsp."',
							'".$userbrcode."',
							'".$userbrname."',
							'".$userdepart."',
							'".$userrole."',
							'".$usercompli."',
							'".$usermail."',
							'".$userphone."',
							'".$usermsh."',
							'".$userih."',
							'".$userkk."',
							'".$userkkk."',
							'".$uservcus."',
							'".$userecus."',
							'".$uservord."',
							'".$usereord."',
							'".$uservcre."',
							'".$userecre."',
							'".$uservple."',
							'".$usereple."',
							'".$uservcon."',
							'".$userecon."',
							'".$uservnot."',
							'".$userenot."'
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
<title>İstifadəçi əlavə et</title>
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
		<?php include("inc_blocks/useradblok.php")?>
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