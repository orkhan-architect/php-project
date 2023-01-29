<?php 
if($_SERVER["REQUEST_METHOD"] == "POST"){
	define('mcsystem', true);
	session_start();
	include("../myblocks/db_connect.php");
	include("../myblocks/defend.php");
	$active_orders = mysqli_query($connect_link,"SELECT id FROM cre_orders WHERE client='{$_SESSION['auth_login']}' AND order_status='aktiv'");
	if(mysqli_num_rows($active_orders) < 3){
		
	$error = array();
	
	if($_SESSION['auth_ptype'] == "Fiziki şəxs / Fərdi sahibkar"){
		
	$famstatus = mysqli_real_escape_string($connect_link,defend_input($_POST['form_famstatus']));	
	$membercount = mysqli_real_escape_string($connect_link,defend_input($_POST['form_membercount']));
	$collabcount = mysqli_real_escape_string($connect_link,defend_input($_POST['form_collabcount']));	
	$allprofit = mysqli_real_escape_string($connect_link,defend_input($_POST['form_allprofit']));
	$allexpense = mysqli_real_escape_string($connect_link,defend_input($_POST['form_allexpense']));
	$cooperation = mysqli_real_escape_string($connect_link,defend_input($_POST['form_cooperation']));
	$jobagrem = mysqli_real_escape_string($connect_link,defend_input($_POST['jobdoc']));
	
	if(strlen($cooperation) < 4 or strlen($cooperation) > 30){$error[] = "4-30 simvol arası iş yerinizinin tam dolğun adını daxil edin!";}
	if(!$allprofit){$error[] = "Ailənizin siz daxil ümumi aylıq gəlirini qeyd edin!";}
	if(!$allexpense){$error[] = "Ailənizin siz daxil ümumi aylıq xərcini qeyd edin!";}
	if(!$collabcount){$error[] = "Ailədə siz daxil işləyənlərin sayını qeyd edin!";}
	if(!$membercount){$error[] = "Siz daxil ailə üzvlərinizin sayını qeyd edin!";}
	if(!$famstatus){$error[] = "Evli və ya subay olmağınızı qeyd edin!";}
	if(!$jobagrem){$error[] = "İş arayışınızın əldə edilməsinə mütləq razılıq verməlisiniz!";}
	
	$individbase = "fam_status, fam_members, fam_workers, oth_profit, oth_expense, last_job, agrjob, ";
	$individdata = "'".$famstatus."', '".$membercount."', '".$collabcount."', '".$allprofit."', '".$allexpense."', '".$cooperation."', '".$jobagrem."', ";
	}
	
	if($_POST['form_exst'] == "bəli"){
	
	$pledgetype = mysqli_real_escape_string($connect_link,defend_input($_POST['form_pledgetype']));	
	$pledvalue = mysqli_real_escape_string($connect_link,defend_input($_POST['form_pledvalue']));	
	$pledcur = mysqli_real_escape_string($connect_link,defend_input($_POST['form_pledcur']));
	$pledinfo = mysqli_real_escape_string($connect_link,defend_input($_POST['form_pledinfo']));
		
	if(!$pledgetype){$error[] = "Təklif edəcəyiniz girov tipini seçin!";}
	if(!$pledvalue){$error[] = "Girovun hazırki bazar dəyərini qeyd edin!";}
	if(!$pledcur){$error[] = "Təklif edəcəyiniz girovun valyutasını qeyd edin!";}
	if(!$pledinfo){$error[] = "Girovunuzu ətraflı xarakterizə edin!";}
		
	$pledbase = "ple_type, ple_value, ple_currency, ple_information, ";
	$pleddata = "'".$pledgetype."', '".$pledvalue."', '".$pledcur."', '".$pledinfo."',";
	}
	
	$client_login = $_SESSION['auth_login'];
	$experience = mysqli_real_escape_string($connect_link,defend_input($_POST['form_experience']));	
	$myprofit = mysqli_real_escape_string($connect_link,defend_input($_POST['form_myprofit']));	
	$recommend = mysqli_real_escape_string($connect_link,defend_input($_POST['form_recommend']));
	$finance = mysqli_real_escape_string($connect_link,defend_input($_POST['form_finance']));
	$otherfin = mysqli_real_escape_string($connect_link,defend_input($_POST['form_otherfin']));
	$credaim = mysqli_real_escape_string($connect_link,defend_input($_POST['form_credaim']));
	$credproduct = mysqli_real_escape_string($connect_link,defend_input($_POST['form_creproduct']));
	$amount = mysqli_real_escape_string($connect_link,defend_input($_POST['form_amount']));
	$credcur = mysqli_real_escape_string($connect_link,defend_input($_POST['form_credcur']));	
	$period = mysqli_real_escape_string($connect_link,defend_input($_POST['form_period']));
	$discount = mysqli_real_escape_string($connect_link,defend_input($_POST['form_discount']));
	$acbagrem = mysqli_real_escape_string($connect_link,defend_input($_POST['acbagr']));
	$cruser = mysqli_real_escape_string($connect_link,defend_input($_POST['form_cruser']));
	$sel_manager = mysqli_query($connect_link,"SELECT compliance FROM users WHERE login='$cruser'");
	if(mysqli_num_rows($sel_manager)>0){
		$manager_row = mysqli_fetch_assoc($sel_manager);
		$manuser = $manager_row["compliance"];
	}
	$sel_officer = mysqli_query($connect_link,"SELECT profile_officer FROM cstmr_data WHERE login='$client_login'");
	if(mysqli_num_rows($sel_officer)>0){
		$officer_row = mysqli_fetch_assoc($sel_officer);
		$officer = $officer_row["profile_officer"];
	}
	$sel_verifier = mysqli_query($connect_link,"SELECT compliance FROM users WHERE login='$officer'");
	if(mysqli_num_rows($sel_verifier)>0){
		$verifier_row = mysqli_fetch_assoc($sel_verifier);
		$verifier = $verifier_row["compliance"];
	}
	
    if(strlen($recommend) < 3 or strlen($recommend) > 30){$error[] = "3-30 simvol aralığı Bizi məsləhət bilən şəxsi və ya nəyisə daxil edin!";}
    if(strlen($credaim) < 6 or strlen($credaim) > 30){$error[] = "6-30 simvol aralığı alacağınız kreditin məqsədini daxil edin!";}
	if(!$amount){$error[] = "Məhsula uyğun kredit məbləğini qeyd edin!";}
	if(!$credcur){$error[] = "Məhsula uyğun kreditinizin valyutasını qeyd edin!";}
	if(!$period){$error[] = "Məhsula uyğun kreditin müddətini təyin edin!";}
    if(!$experience){$error[] = "İş (fəaliyyət) təcrübənizi aylarla qeyd edin!";}	
	if(!$myprofit){$error[] = "Orta aylıq qazancınızı, mənfəətinizi qeyd edin!";}
	if(!$finance){$error[] = "Yükləyəcəyiniz əsas arayış növünü qeyd edin!";}
	if(!$credproduct){$error[] = "Seçdiyiniz kredit məhsulunu qeyd edin!";}
	if(!$acbagrem){$error[] = "AKB-dən kredit tarixçənizin əldə edilməsinə razılıq verməlisiniz!";}
	if(!$otherfin){$error[] = "Yükləyəcəyiniz digər sənədləri qeyd edin!";}
	if(!$cruser){$error[] = "Filial üzrə seçdiyiniz kredit əməkdaşımızı qeyd edin!";}
    if($_SESSION['captcha_code'] != strtolower($_POST['captcha_code'])){$error[] = "Şəkildəki şifrə ilə uyğunluq yoxdur!";}
    unset($_SESSION['captcha_code']);
	
	if(count($error)){    
		echo implode('<br>',$error);     
	}
	else{
		$serip = $_SERVER['REMOTE_ADDR'];
		mysqli_query($connect_link,"INSERT INTO cre_orders($individbase $pledbase client, j_experience, aver_profit, recommended, send_findoc, send_finothdoc, cre_aim, product_name, cre_amount, cre_currency, cre_period, cre_concession, app_datetime, app_ipaddress, cho_creditor, cho_manager, cho_officer, cho_verifier, agracb)
						VALUES(
							$individdata $pleddata
							'".$client_login."',
							'".$experience."',
							'".$myprofit."',
							'".$recommend."',
							'".$finance."',
                            '".$otherfin."',
                            '".$credaim."',
							'".$credproduct."',
							'".$amount."',
							'".$credcur."',
							'".$period."',
							'".$discount."',
							NOW(),
                            '".$serip."',
                            '".$cruser."',
							'".$manuser."',
							'".$officer."',
							'".$verifier."',
							'".$acbagrem."'
						)");
		echo 'true';
	}
}
}
?>