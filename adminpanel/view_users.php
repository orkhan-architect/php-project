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
		if($_POST["useredit_submit"]){
			
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
			
		if(!$usernsp){$error[] = "istifad????i ASA qeyd edin!";}
		if(!filter_var($usermail, FILTER_VALIDATE_EMAIL)){$error[] = "D??zg??n email ??nvan daxil edin!";}
		if(!$userphone){$error[] = "istifad????i telefonunu qeyd edin!";}
		if(!$userbrcode){$error[] = "istifad????inin filial kodunu qeyd edin!";}
		if(!$userbrname){$error[] = "istifad????inin filial ad??n?? qeyd edin!";}
		if(!$userdepart){$error[] = "istifad????inin departamentini qeyd edin!";}
		if(!$userrole){$error[] = "istifad????inin v??zif??sini qeyd edin!";}
		if(!$usercompli){$error[] = "istifad????inin as??l??l??????n?? qeyd edin!";}
			
		if($_POST["form_login"]){
        	$login = mysqli_real_escape_string($connect_link,defend_input($_POST['form_login']));
        	$query = mysqli_query($connect_link,"SELECT login FROM users WHERE login='$login'"); 
     		if(mysqli_num_rows($query) > 0){$error[] = "Login m??vcuddur!";}
		}
		else{
        	$error[] = "Logini g??st??rin!";
    	}
			
		if($_POST["form_passv"]){
    			$pass = md5(defend_input($_POST["form_passv"]));
    			$pass = strrev($pass);
    			$pass = "pass='".strtolower("mb03foo33".$pass."qj2jjd55")."'";      
    	}
		
		if(count($error)){
			$_SESSION['msg'] = "<p id='form-error'>".implode('<br>',$error)."</p>";
		}
		else{
			$_SESSION['msg'] = "<p id='form-success'>??stifad????i u??urla d??yi??di!</p>";
			
			$useredit = "login='".$login."', $pass, nsp='".$usernsp."', branch='".$userbrcode."', branch_fullname='".$userbrname."', department='".$userdepart."', role='".$userrole."', compliance='".$usercompli."', email='".$usermail."', phone='".$userphone."', msh='".$usermsh."', ih='".$userih."', kk='".$userkk."', kkk='".$userkkk."', view_customer='".$uservcus."', edit_customer='".$userecus."', view_order='".$uservord."', edit_order='".$usereord."', view_credit='".$uservcre."', edit_credit='".$userecre."', view_pledge='".$uservple."', edit_pledge='".$usereple."', view_concat='".$uservcon."', edit_concat='".$userecon."', view_notif='".$uservnot."', edit_notif='".$userenot."'";
				
			$userupdate = mysqli_query($connect_link, "UPDATE users SET $useredit WHERE id='$id'");
			}
		}
	}	
	else{	
		if($_POST["useredit_submit"]){		
			
			if($_POST["form_passv"]){
    			$pass = md5(defend_input($_POST["form_passv"]));
    			$pass = strrev($pass);
    			$pass = "pass='".strtolower("mb03foo33".$pass."qj2jjd55")."'";      
    		}
		
		if(count($error)){
			$_SESSION['msg'] = "<p id='form-error'>".implode('<br>',$error)."</p>";
		}
		else{
			$_SESSION['msg'] = "<p id='form-success'>??ifr?? u??urla d??yi??di!</p>";
			
			$useredit = "$pass";
				
			$userupdate = mysqli_query($connect_link, "UPDATE users SET $useredit WHERE id='$id'");
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
<title>??stifad????i profilin?? bax</title>
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
		<?php include("inc_blocks/vuserblok.php")?>
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