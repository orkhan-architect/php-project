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
	
	$importantdata_result = mysqli_query($connect_link,"SELECT * FROM cre_orders WHERE id='$id'");
	if(mysqli_num_rows($importantdata_result)>0){
		$importantdata_row = mysqli_fetch_assoc($importantdata_result);
		$getclient_result = mysqli_query($connect_link,"SELECT client FROM cstmr_data WHERE login='{$importantdata_row["client"]}'");
		if(mysqli_num_rows($getclient_result)>0){
			$getclient_row = mysqli_fetch_assoc($getclient_result);
		}
		$credproduct = $importantdata_row["product_name"];
		$credamount = $importantdata_row["cre_amount"];
		$credcurrency = $importantdata_row["cre_currency"];
		$credperiod = $importantdata_row["cre_period"];
		$clientid = $getclient_row["client"];
	}
	
	if($_SESSION['auth_admin_login'] == $importantdata_row["cho_creditor"] || $_SESSION['bank_department'] == "system"){
	if($_POST["guarant_submit"]){
		$guarantquery = mysqli_real_escape_string($connect_link,defend_input($_POST['guaquery']));
		$error = array();
		if(!$guarantquery){$error[] = "Zaminin İD-ni (FİN kod və ya VÖEN) mütləq qeyd edin!";}
		if(count($error)){
			$_SESSION['msg'] = "<p id='form-error'>".implode('<br>',$error)."</p>";
		}
		else{
			$_SESSION['msg'] = "<p id='form-success'>Zaminə sorğu uğurla göndərildi!</p>";			
			$getguarant = "creditor_guarquery='".$guarantquery."',toguarant=NOW()";
			$getcode = '<form method="post"><input type="submit" name="agree_submit" id="form_submit" value="Qərar ver"><br><select name="decision_select" id="decsel"><option value="" selected disabled>rəyinizi bildirin</option><option value="imtina">imtina</option><option value="təsdiq">təsdiq</option></select><input type="hidden" id="orderid" name="credorder" value="'.$id.'"></form>';
			$guarantupdate = mysqli_query($connect_link, "UPDATE cre_orders SET $getguarant WHERE id='$id'");
			$notesender = $_SESSION['auth_admin_login'];
			$res_notverifier = mysqli_query($connect_link,"SELECT compliance FROM users WHERE login='$notesender'");
			$row_notverifier = mysqli_fetch_assoc($res_notverifier);
			$noteverifier = $row_notverifier['compliance'];
			mysqli_query($connect_link, "INSERT INTO notification_data(client, note_type, note_text, htmlcoding, note_date, bank, verifingbos) VALUES(
				'".$guarantquery."',
				'bildiriş',
				'Sizi ".$clientid." adlı müştərimiz zamin kimi göstərmişdir. Müştəri ".$credamount." ".$credcurrency." məbləğində ".$credperiod." ay müddətinə ".$credproduct." məhsulu üzrə Bankımıza kredit sifariş vermişdir. Qeyd edək ki, zaminliyə razı olduğunuz halda kredit əməkdaşları tərəfindən sizin AKB-dən kredit tarixçəniz və hökumət portalından elektron arayışınızın əldə edilməsinə razı olmuş olacaqsınız və unutmayın ki, kredit ödənişində Siz müştəriylə eyni hüquqa malik olacaqsınız. O krediti ödəmədiyi halda ödəniş sizə (məvacibinizə) yönəldiləcək. Aşağıda rəyinizi bildirin.',
				'".$getcode."',
				NOW(),
				'".$notesender."',
				'".$noteverifier."'
			)");
		}
	}
	if($_POST["saving_submit"]){
		$userdecision = mysqli_real_escape_string($connect_link,defend_input($_POST['userstat_select']));
		$userspecnotes = mysqli_real_escape_string($connect_link,defend_input($_POST['usernotes']));
		$error = array();
		if(!$userdecision){$error[] = "Sifarişə mütləq rəy bildirməlisiniz!";}
		if(!$userspecnotes){$error[] = "Rəyinizin səbəbini qeyd edin!";}
		
		if($_POST['userstat_select'] == 'təsdiq'){
		$apamount = mysqli_real_escape_string($connect_link,defend_input($_POST['offer_amount']));
		$apperiod = mysqli_real_escape_string($connect_link,defend_input($_POST['offer_period']));
		$apcurrency = mysqli_real_escape_string($connect_link,defend_input($_POST['offer_currency']));
		$error = array();
		if(!$apamount){$error[] = "Təklif edəcəyiniz məbləği qeyd edin!";}
		if(!$apperiod){$error[] = "Təklif edəcəyiniz müddəti qeyd edin!";}
		if(!$apcurrency){$error[] = "Təklif edəcəyiniz valyutanı qeyd edin!";}
		$applied = "creditor_aplyamount='".$apamount."', creditor_aplycurrency='".$apcurrency."', creditor_aplyperiod='".$apperiod."',";
		}	
		
		if(count($error)){
			$_SESSION['msg'] = "<p id='form-error'>".implode('<br>',$error)."</p>";
		}
		else{
			$_SESSION['msg'] = "<p id='form-success'>Əməliyyat uğurla sona yetirildi!</p>";			
			$creditors = "".$applied." creditor_decision='".$userdecision."', creditor_note='".$userspecnotes."', creditor_decisiontime=NOW()";			
			$creditorsupdate = mysqli_query($connect_link, "UPDATE cre_orders SET $creditors WHERE id='$id'");
		}
	}	
	if($_POST["finish_submit"]){
		$ordfindec = mysqli_real_escape_string($connect_link,defend_input($_POST['orderstat_select']));
		$userfinnotes = mysqli_real_escape_string($connect_link,defend_input($_POST['finishnotes']));
		$error = array();
		if(!$ordfindec){$error[] = "Sifarişə mütləq yekun rəy bildirməlisiniz!";}
		if(!$userfinnotes){$error[] = "Yekun rəyinizin səbəbini qeyd edin!";}		
		if(count($error)){
			$_SESSION['msg'] = "<p id='form-error'>".implode('<br>',$error)."</p>";
		}
		else{
			$_SESSION['msg'] = "<p id='form-success'>Kreditə yekun rəy bildirildi!</p>";			
			$lastdeci = "order_status='".$ordfindec."', ldecisionote='".$userfinnotes."', ldecisiontime=NOW()";
			$lastdecupdate = mysqli_query($connect_link, "UPDATE cre_orders SET $lastdeci WHERE id='$id'");
		}
	  }
	}
	
	if($_SESSION['auth_admin_login'] == $importantdata_row["cho_manager"] || $_SESSION['bank_department'] == "system"){
	if($_POST["confirming_submit"]){
		$mandecision = mysqli_real_escape_string($connect_link,defend_input($_POST['manstat_select']));
		$manspecnotes = mysqli_real_escape_string($connect_link,defend_input($_POST['managernotes']));
		$error = array();
		if(!$mandecision){$error[] = "Sifarişə mütləq rəy bildirməlisiniz!";}
		if(!$manspecnotes){$error[] = "Rəyinizin səbəbini qeyd edin!";}
		
		if($_POST['manstat_select'] == 'təsdiq'){
		$decamount = mysqli_real_escape_string($connect_link,defend_input($_POST['mandec_amount']));
		$decperiod = mysqli_real_escape_string($connect_link,defend_input($_POST['mandec_period']));
		$deccurrency = mysqli_real_escape_string($connect_link,defend_input($_POST['mandec_currency']));
		$error = array();
		if(!$decamount){$error[] = "Təklif edəcəyiniz məbləği qeyd edin!";}
		if(!$decperiod){$error[] = "Təklif edəcəyiniz müddəti qeyd edin!";}
		if(!$deccurrency){$error[] = "Təklif edəcəyiniz valyutanı qeyd edin!";}
		$decided = "man_verifiedamount='".$decamount."', man_verifiedcurrency='".$deccurrency."', man_verifiedperiod='".$decperiod."',";
		}	
		
		if(count($error)){
			$_SESSION['msg'] = "<p id='form-error'>".implode('<br>',$error)."</p>";
		}
		else{
			$_SESSION['msg'] = "<p id='form-success'>Əməliyyat uğurla sona yetirildi!</p>";			
			$managers = "".$decided." man_decision='".$mandecision."', man_note='".$manspecnotes."', man_checktime=NOW()";			
			$managersupdate = mysqli_query($connect_link, "UPDATE cre_orders SET $managers WHERE id='$id'");
		}
	  }
	}
	
	if($_SESSION['auth_admin_login'] == $importantdata_row["cho_verifier"] || $_SESSION['bank_department'] == "system"){
	if($_POST["operating_submit"]){
		$ordverifdec = mysqli_real_escape_string($connect_link,defend_input($_POST['verstat_select']));
		$ordverifnotes = mysqli_real_escape_string($connect_link,defend_input($_POST['verifnotes']));
		$error = array();
		if(!$ordverifdec){$error[] = "Mütləq icra və ya ləğv rəyinizi bildirməlisiniz!";}
		if(!$ordverifnotes){$error[] = "Rəyinizin səbəbini qeyd edin!";}		
		if(count($error)){
			$_SESSION['msg'] = "<p id='form-error'>".implode('<br>',$error)."</p>";
		}
		else{
			$_SESSION['msg'] = "<p id='form-success'>Sifarişin icra və ya ləğvi barədə rəyiniz bildirildi!</p>";			
			$verifierdeci = "verifier_operation='".$ordverifdec."', verifier_notes='".$ordverifnotes."', operation_date=NOW()";
			$verifdecupdate = mysqli_query($connect_link, "UPDATE cre_orders SET $verifierdeci WHERE id='$id'");
		}
	  }
	}
	
	if($_SESSION['users_role'] == 'admin'){
	if(isset($_POST['filesubmit'])){
    	if(count($_FILES['upload']['name']) > 0){
        	for($i=0; $i<count($_FILES['upload']['name']); $i++) {
            	$tmpFilePath = $_FILES['upload']['tmp_name'][$i];
            	if($tmpFilePath != ""){
                	$shortname = $_FILES['upload']['name'][$i];
                	$filePath = "upload_orders/" . date('d-m-Y-H-i-s').'-'.$_FILES['upload']['name'][$i];
					$picfordb = date('d-m-Y-H-i-s').'-'.$_FILES['upload']['name'][$i];
                	if(move_uploaded_file($tmpFilePath, $filePath)) {
						$files[] = $shortname;
						mysqli_query($connect_link, "INSERT INTO upload_ord (order_id, order_images) VALUES ('$id', '$picfordb')");}
					}
              	}
        	}
			$_SESSION['msg'] = "<h1>Fayllar bütünlüklə yükləndi</h1>";
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
<title>Kredit sifarişə bax</title>
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
		<?php include("inc_blocks/vordblok.php")?>
	</div>
</div>
<script>
var slideIndex = 1;
showSlides(slideIndex);

function plusSlides(n) {
  showSlides(slideIndex += n);
}

function currentSlide(n) {
  showSlides(slideIndex = n);
}

function showSlides(n) {
  var i;
  var slides = document.getElementsByClassName("mySlides");
  var dots = document.getElementsByClassName("dot");
  if (n > slides.length) {slideIndex = 1}    
  if (n < 1) {slideIndex = slides.length}
  for (i = 0; i < slides.length; i++) {
      slides[i].style.display = "none";  
  }
  for (i = 0; i < dots.length; i++) {
      dots[i].className = dots[i].className.replace(" active", "");
  }
  slides[slideIndex-1].style.display = "block";  
  dots[slideIndex-1].className += " active";
}
</script>
</body>
</html>
<?php 
}
else{
	header("Location: login");
}
?>