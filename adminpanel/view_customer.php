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
	
	if($_SESSION['users_role'] == 'verifier' || $_SESSION['bank_department'] == "system"){
	if($_POST["appoint_submit"]){
		$cusverifier = $_SESSION['auth_admin_login'];
		$brofcersel = mysqli_real_escape_string($connect_link,defend_input($_POST['officer_select']));
		$error = array();
		if(!$brofcersel){$error[] = "Təyin edəcəyiniz inzibatçı-əməliyyatçını seçin!";}
		if(count($error)){
			$_SESSION['msg'] = "<p id='form-error'>".implode('<br>',$error)."</p>";
		}
		else{
			$_SESSION['msg'] = "<p id='form-success'>Təyinat uğurla yaddaşa verildi!</p>";
			$appointquery = "profile_officer='".$brofcersel."',status='təyinat',appointment_date=NOW(), profile_verifier='".$cusverifier."'";
			$appointupdate = mysqli_query($connect_link, "UPDATE cstmr_data SET $appointquery WHERE id='$id'");}
		}
		
	if($_POST["bossverify_submit"]){
		$_SESSION['msg'] = "<p id='form-success'>Profil tam şəkildə uğurla yaddaşa verildi!</p>";
		$bosverifyquery = "verified='yes', boss_verifydate=NOW()";
		$bosverifyupdate = mysqli_query($connect_link, "UPDATE cstmr_data SET $bosverifyquery WHERE id='$id'");}
		
	if($_POST["reset_submit"]){
		$_SESSION['msg'] = "<p id='form-success'>Profil redaktə üçün geri qaytarıldı!</p>";
		$bosresetquery = "officer_verified=null, ofcer_verifydate=null, verified=null, boss_verifydate=null";
		$bosresetupdate = mysqli_query($connect_link, "UPDATE cstmr_data SET $bosresetquery WHERE id='$id'");}
	}
	
	if($_SESSION['users_role'] == 'officer' || $_SESSION['bank_department'] == "system"){
	if($_POST["checked_submit"]){
		$custatuscode = mysqli_real_escape_string($connect_link,defend_input($_POST['statuscodegen']));
		$error = array();
		if(!$custatuscode){$error[] = "Şifrəni silməyin!";}
		if(count($error)){
			$_SESSION['msg'] = "<p id='form-error'>".implode('<br>',$error)."</p>";
		}
		else{
		$_SESSION['msg'] = "<p id='form-success'>Profil uğurla nəzərdən keçirildi!</p>";
		$checkquery = "statuscode='".$custatuscode."', ofcer_checkdate=NOW(),status='baxıldı'";
		$checkupdate = mysqli_query($connect_link, "UPDATE cstmr_data SET $checkquery WHERE id='$id'");}
		}
	
	if($_POST["ofcerverify_submit"]){
		$cusbelong = mysqli_real_escape_string($connect_link,defend_input($_POST['belon']));
		$cusrelated = mysqli_real_escape_string($connect_link,defend_input($_POST['relate']));
		$cusgovernment = mysqli_real_escape_string($connect_link,defend_input($_POST['goventit']));
		$cusadminboss = mysqli_real_escape_string($connect_link,defend_input($_POST['adminceo']));
		$cusdepboss = mysqli_real_escape_string($connect_link,defend_input($_POST['deparboss']));
		$cusbusiness = mysqli_real_escape_string($connect_link,defend_input($_POST['business_select']));
		$custhirdpers = mysqli_real_escape_string($connect_link,defend_input($_POST['checker_thperson']));
		$cusofficernote = mysqli_real_escape_string($connect_link,defend_input($_POST['checker_opnotes']));
		$cusbostype = mysqli_real_escape_string($connect_link,defend_input($_POST['checker_bosstype']));
		$cusbosname = mysqli_real_escape_string($connect_link,defend_input($_POST['checker_bossname']));
		$cussphere = mysqli_real_escape_string($connect_link,defend_input($_POST['checker_sphere']));
		$cusportion = mysqli_real_escape_string($connect_link,defend_input($_POST['checker_portions']));
		$cusholder = mysqli_real_escape_string($connect_link,defend_input($_POST['checker_holders']));
		$cuserialnum = mysqli_real_escape_string($connect_link,defend_input($_POST['checker_sernumber']));
		$cusgovname = mysqli_real_escape_string($connect_link,defend_input($_POST['checker_govername']));
		$cusdocrdate = mysqli_real_escape_string($connect_link,defend_input($_POST['checker_docrdate']));
		$cusindivtaxes = mysqli_real_escape_string($connect_link,defend_input($_POST['checker_itaxid']));
		$cusregadress = mysqli_real_escape_string($connect_link,defend_input($_POST['checker_radres']));
		$cusbirthday = mysqli_real_escape_string($connect_link,defend_input($_POST['checker_bdate']));
		$cusconcode = mysqli_real_escape_string($connect_link,defend_input($_POST['checker_contrycode']));
		$cusconame = mysqli_real_escape_string($connect_link,defend_input($_POST['checker_contryname']));
		$cusresident = mysqli_real_escape_string($connect_link,defend_input($_POST['checker_residency']));
		
		$error = array();
		
		if(!$cusresident){$error[] = "rezident və ya qeyri-rezident olmasını qeyd edin!";}
		if(!$cusconcode){$error[] = "Qeydiyyatda olduğu ölkə kodunu qeyd edin(AZE,GEO,GER və s.)!";}
		if(!$cusconame){$error[] = "Doğulduğu yeri vəsiqəsində olduğu kimi qeyd edin!";}
		
		if(count($error)){
			$_SESSION['msg'] = "<p id='form-error'>".implode('<br>',$error)."</p>";
		}
		else{
			$_SESSION['msg'] = "<p id='form-success'>Uyğun dəyişikliklər uğurla yaddaşa verildi!</p>";
			
			if($_POST['checker_ptype'] == 'Fiziki şəxs / Fərdi sahibkar'){
				$persontypesel = "doc_sernum='".$cuserialnum."', doc_govname='".$cusgovname."', doc_regdate='".$cusdocrdate."', ind_taxesid='".$cusindivtaxes."', ";
			}
			else{
				$persontypesel = "ceo_post='".$cusbostype."', ceo_init='".$cusbosname."', business_sphere='".$cussphere."', sh_portion='".$cusportion."', shareholders='".$cusholder."', ";
			}
			
			$ofcerverifyquery = $persontypesel."belong='".$cusbelong."', related='".$cusrelated."', gover_entity='".$cusgovernment."', administration='".$cusadminboss."', depart_boss='".$cusdepboss."', bus_type='".$cusbusiness."', profile_controlling='".$custhirdpers."', personal_notes='".$cusofficernote."', reg_address='".$cusregadress."', born_date='".$cusbirthday."', born_contrycode='".$cusconcode."', born_place='".$cusconame."', nationality='".$cusresident."', officer_verified='yes', ofcer_verifydate=NOW()";
			
			$ofcerverifyupdate = mysqli_query($connect_link, "UPDATE cstmr_data SET $ofcerverifyquery WHERE id='$id'");
			
			$cust_res = mysqli_query($connect_link,"SELECT * FROM cstmr_data WHERE id='$id'");
			$cust_row = mysqli_fetch_assoc($cust_res);
			
			$custlog = $cust_row["login"];
			$custasa = $cust_row["client"];
			$custmail = $cust_row["email"];
			$custothph = $cust_row["phone"];
			$custladr = $cust_row["liv_address"];
			$custoffic = $cust_row["profile_officer"];
			$res_notverifier = mysqli_query($connect_link,"SELECT compliance FROM users WHERE login='$custoffic'");
			$row_notverifier = mysqli_fetch_assoc($res_notverifier);
			$noteverifier = $row_notverifier['compliance'];
			
			$notif = mysqli_query($connect_link,"INSERT INTO notification_data(client, note_type, note_text, note_date, bank, verifingbos)
						VALUES(
							'".$custlog."',
							'bildiriş',
							'Salam hörmətli istifadəçi. Siz sistemdə ".$custasa." kimi qeydiyyatdan keçmisiniz. Yaşadığınız ünvanı ".$custladr." qeyd etmisiniz. Sizlə əlaqə saxlamaq üçün ".$custothph." telefon nömrələrini və ".$custmail." mail ünvanınızı təqdim etmisiniz. Bu məlumatları istənilən vaxt dəyişə biləcəksiniz',
							NOW(),
							'".$custoffic."',
							'".$noteverifier."'
						)");}
		}
		
		if($_POST["deactivate_submit"]){		
		$cusofficernote = mysqli_real_escape_string($connect_link,defend_input($_POST['checker_opnotes']));
		$error = array();		
		if(!$cusofficernote){$error[] = "deaktivasiya səbəbinizi qeyd edin!";}
		
		if(count($error)){
			$_SESSION['msg'] = "<p id='form-error'>".implode('<br>',$error)."</p>";
		}
		else{		
		$_SESSION['msg'] = "<p id='form-success'>Profil imtina edilmişlər siyahısına əlavə edildi!</p>";
		$deactivatequery = "status='deaktiv', deactiv_date=NOW(), personal_notes='".$cusofficernote."'";
		$deactivateupdate = mysqli_query($connect_link, "UPDATE cstmr_data SET $deactivatequery WHERE id='$id'");}
		}
	}
	
	if($_SESSION['bank_department'] == 'account_controllers' || $_SESSION['bank_department'] == "system"){
	if($_POST["normalclient_submit"]){		
		$bankpolicenote = mysqli_real_escape_string($connect_link,defend_input($_POST['police_vernotes']));
		$bankpolicedeci = mysqli_real_escape_string($connect_link,defend_input($_POST['policeop_select']));
		$policeuser = $_SESSION['auth_admin_login'];
		$error = array();		
		if(!$bankpolicenote){$error[] = "təsdiq və ya imtina səbəbinizi qeyd edin!";}
		if(!$bankpolicedeci){$error[] = "müştərini təsdiq və ya imtina rəyinizi bildirin!";}
		
		if(count($error)){
			$_SESSION['msg'] = "<p id='form-error'>".implode('<br>',$error)."</p>";
		}
		else{		
		$_SESSION['msg'] = "<p id='form-success'>Müştəri barədə rəyiniz əlavə edildi!</p>";
		$policequery = "police_verified='".$bankpolicedeci."', policeverify_date=NOW(), profile_police='".$policeuser."', police_notes='".$bankpolicenote."'";
		$policeupdate = mysqli_query($connect_link, "UPDATE cstmr_data SET $policequery WHERE id='$id'");}
		}
	}
	
	if($_SESSION['bank_department'] == 'system'){
	if($_POST["specialsubmit"]){		
		$clientinit = mysqli_real_escape_string($connect_link,defend_input($_POST['checker_clientnsp']));
		$clientid = mysqli_real_escape_string($connect_link,defend_input($_POST['checker_specid']));
		$vernumber = mysqli_real_escape_string($connect_link,defend_input($_POST['checker_vernum']));
		$error = array();		
		if(!$clientinit){$error[] = "müştərinin düzgün inisiallarını qeyd edin!";}
		if(!$clientid){$error[] = "müştərinin fin kodu və ya VÖENini düzgün göstərin!";}
		if(!$vernumber){$error[] = "müştərinin əsas mobil nömrəsinə düzəliş edin!";}
		
		if(count($error)){
			$_SESSION['msg'] = "<p id='form-error'>".implode('<br>',$error)."</p>";
		}
		else{		
		$_SESSION['msg'] = "<p id='form-success'>Müştərinin xüsusi xanaları dəyişdi!</p>";
		$specquery = "client='".$clientinit."', login='".$clientid."', myphone='".$vernumber."'";
		$speceditupdate = mysqli_query($connect_link, "UPDATE cstmr_data SET $specquery WHERE id='$id'");}
		}
	}
	
	if($_SESSION['users_role'] == 'admin'){
	if(isset($_POST['filesubmit'])){
    	if(count($_FILES['upload']['name']) > 0){
        	for($i=0; $i<count($_FILES['upload']['name']); $i++) {
            	$tmpFilePath = $_FILES['upload']['tmp_name'][$i];
            	if($tmpFilePath != ""){
                	$shortname = $_FILES['upload']['name'][$i];
                	$filePath = "upload_images/" . date('d-m-Y-H-i-s').'-'.$_FILES['upload']['name'][$i];
					$picfordb = date('d-m-Y-H-i-s').'-'.$_FILES['upload']['name'][$i];
                	if(move_uploaded_file($tmpFilePath, $filePath)) {
						$files[] = $shortname;
						mysqli_query($connect_link, "INSERT INTO upload_img (client_id, images) VALUES ('$id', '$picfordb')");}
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
<title>Müştəri hesabına bax</title>
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
		<?php include("inc_blocks/vcusblok.php")?>
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