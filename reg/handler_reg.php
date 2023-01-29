<?php 
if($_SERVER["REQUEST_METHOD"] == "POST"){
	define('mcsystem', true);
	session_start();
	include("../myblocks/db_connect.php");
	include("../myblocks/defend.php");
		
	$error = array();
	
	if($_POST['form_persontype'] == "Hüquqi şəxs"){
	
	$bostype = mysqli_real_escape_string($connect_link,defend_input($_POST['form_bosstype']));	
	$bosini = mysqli_real_escape_string($connect_link,defend_input($_POST['form_bossinit']));	
	$sholders = mysqli_real_escape_string($connect_link,defend_input($_POST['form_sharhol']));	
	$sportions = mysqli_real_escape_string($connect_link,defend_input($_POST['form_sharport']));
	$busiprof = mysqli_real_escape_string($connect_link,defend_input($_POST['form_business']));
		
	if(strlen($bostype) < 4 or strlen($bostype) > 30){$error[] = "4-30 simvol aralığı şirkətin idarəedicisinin vəzifəsini daxil edin!";}
    if(strlen($bosini) < 3 or strlen($bosini) > 40){$error[] = "3-40 simvol arası şirkətin idarəedicisinin A.S.A. daxil edin!";}
	if(strlen($sholders) < 5 or strlen($sholders) > 255){$error[] = "5-255 simvol arası vergül qoymaqla təsisçilərin A.S.A. daxil edin!";}
	if(strlen($sportions) < 3 or strlen($sportions) > 50){$error[] = "3-50 simvol arası vergül qoymaqla təsisçilərin paylarını daxil edin!";}
	if(strlen($busiprof) < 3 or strlen($busiprof) > 30){$error[] = "3-30 simvol arası fəaliyyət sferasını daxil edin!";}
		
	$legbase = "ceo_post,ceo_init,shareholders,sh_portion,business_sphere,";
	$legdata = "'".$bostype."','".$bosini."','".$sholders."','".$sportions."','".$busiprof."',";
	}
	
	if($_POST['form_persontype'] == "Fiziki şəxs / Fərdi sahibkar"){
	
	$sernumb = mysqli_real_escape_string($connect_link,defend_input($_POST['form_docserinum']));	
	$govnam = mysqli_real_escape_string($connect_link,defend_input($_POST['form_docgovername']));
	$dregdate = mysqli_real_escape_string($connect_link,defend_input($_POST['form_docredate']));
	$indtaxid = mysqli_real_escape_string($connect_link,defend_input($_POST['form_individ']));
		
	if(strlen($sernumb) < 9 or strlen($sernumb) > 11){$error[] = "9-11 simvol arası seriya və kodu daxil edin!";}
	if(strlen($govnam) < 4 or strlen($govnam) > 20){$error[] = "4-20 simvol arası sənədi qeydə alan dövlət orqanını daxil edin!";}
	if(!$dregdate){$error[] = "Vəsiqənizin qeydiyyat tarixini qeyd edin!";}
	if(strlen($indtaxid) < 6 or strlen($indtaxid) > 10){$error[] = "sahibkarsınızsa,VÖENi daxil edin, əks halda yoxdur qeyd edin!";}
		
	$individbase = "doc_sernum,doc_govname,doc_regdate,ind_taxesid,";
	$individdata = "'".$sernumb."','".$govnam."','".$dregdate."','".$indtaxid."',";
	}	
	
	$login = mysqli_real_escape_string($connect_link,defend_input($_POST['form_login']));	
	$pass = mysqli_real_escape_string($connect_link,defend_input($_POST['form_pasvor']));	
	$ptype = mysqli_real_escape_string($connect_link,defend_input($_POST['form_persontype']));	
	$client = mysqli_real_escape_string($connect_link,defend_input($_POST['form_client']));	
	$livadres = mysqli_real_escape_string($connect_link,defend_input($_POST['form_ladres']));	
	$phonenum = mysqli_real_escape_string($connect_link,defend_input($_POST['form_phonumb']));	
	$verificatornum = mysqli_real_escape_string($connect_link,defend_input($_POST['form_verificatornum']));
	$clmails = strtolower(mysqli_real_escape_string($connect_link,defend_input($_POST['form_email'])));
	$borndat = mysqli_real_escape_string($connect_link,defend_input($_POST['form_bodate']));	
	$branchname = mysqli_real_escape_string($connect_link,defend_input($_POST['form_branch']));
	$minicap = mysqli_real_escape_string($connect_link,defend_input($_POST['form_lesscap']));
	$invalid = mysqli_real_escape_string($connect_link,defend_input($_POST['form_invalid']));
	$regadres = mysqli_real_escape_string($connect_link,defend_input($_POST['form_radres']));	
	$borro = mysqli_real_escape_string($connect_link,defend_input($_POST['borrower']));	
	$guaran = mysqli_real_escape_string($connect_link,defend_input($_POST['guarant']));	
	$mortg = mysqli_real_escape_string($connect_link,defend_input($_POST['coll']));	
	$cnotes = mysqli_real_escape_string($connect_link,defend_input($_POST['form_clientnotes']));
	
    if(strlen($login) < 7 or strlen($login) > 10){
		$error[] = "Login 7-10 simvol arası olmalıdır!"; 
    }
    else{
		$resultreploguser = mysqli_query($connect_link,"SELECT login FROM cstmr_data WHERE login = '$login'");
    	if(mysqli_num_rows($resultreploguser) > 0){
			$error[] = "Bu login mövcuddur!";
		}
    }
    if(strlen($pass) < 7 or strlen($pass) > 12){$error[] = "7-12 simvol aralığı şifrə daxil edin!";}
	if(!$ptype){$error[] = "Qeydiyyatdan vətəndaş və ya şirkət kimi keçəcəyinizi bildirin!";}
    if(strlen($client) < 3 or strlen($client) > 40){$error[] = "3-40 simvol aralığı A.S.A. daxil edin!";}
	if(!$livadres){$error[] = "Yaşadığınız ünvanı qeyd edin!";}
	if(!$regadres){$error[] = "Qeydiyyat ünvanınızı qeyd edin!";}
    if(!filter_var($clmails, FILTER_VALIDATE_EMAIL)){$error[] = "Düzgün email ünvan daxil edin!";}
    if(!$phonenum){$error[] = "Telefon nömrələrini qeyd edin!";}
	if(!$verificatornum){$error[] = "Təsdiqləyici mobil nömrənizi qeyd edin!";}
	if(!$borndat){$error[] = "Doğum tarixini və ya şirkətin yaranma tarixini qeyd edin!";}
	if(!$branchname){$error[] = "Qeydiyyat üçün filiallardan birini seçin!";}
	if(!$minicap){$error[] = "Aztəminatlı olub-olmadığınızı mütləq bildirin!";}
	if(!$invalid){$error[] = "Əlil olub-olmadığınızı mütləq bildirin!";}
    if($_SESSION['captcha_code'] != strtolower($_POST['captcha_code'])){$error[] = "Şəkildəki şifrə ilə uyğunluq yoxdur!";}
    unset($_SESSION['captcha_code']);
	
	if(count($error)){    
		echo implode('<br>',$error);     
	}
	else{	
		$pass = md5($pass);
		$pass = strrev($pass);
		$pass = "3vg2nh3q".$pass."3mo5a";
        $serip = $_SERVER['REMOTE_ADDR'];
		$serport = $_SERVER['REMOTE_PORT'];
		$serhost = $_SERVER['REMOTE_HOST'];
		$serauth = $_SERVER['REMOTE_USER'];
		
		mysqli_query($connect_link,"INSERT INTO cstmr_data($legbase $individbase login,branch_code,minicapital,invalidity,passw,person_type,client,reg_address,liv_address,phone,myphone,email,born_date,reg_datetime,reg_ipaddr,reg_portaddr,reg_hostname,reg_authuser,debtor,guarantor,mortgagor,customer_notes)
						VALUES(
							$legdata $individdata
							'".$login."',
							'".$branchname."',
							'".$minicap."',
							'".$invalid."',
							'".$pass."',
							'".$ptype."',
							'".$client."',
							'".$regadres."',
                            '".$livadres."',
                            '".$phonenum."',
							'".$verificatornum."',
							'".$clmails."',
							'".$borndat."',
							NOW(),
                            '".$serip."',
							'".$serport."',
                            '".$serhost."',
                            '".$serauth."',
							'".$borro."',
							'".$guaran."',
							'".$mortg."',
							'".$cnotes."'
						)");
		echo 'true';
	}
}
?>