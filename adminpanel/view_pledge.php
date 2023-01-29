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
	
	if($_SESSION['bank_department'] == "system"){
		if($_POST["pledgereset_submit"]){
		$_SESSION['msg'] = "<p id='form-success'>Girov redaktə üçün geri qaytarıldı!</p>";
		
		$bospledgereset = "manager_decision='emal edilməkdədir', doc_sernum=null, doc_govname=null, doc_regdate=null, ceo_post=null, ceo_init=null, brand=null, model=null, vehicle_colour=null, vehicle_type=null, property_year=null, ownership=null, portion=null, appointment=null, appraiser=null, evaluation_date=null, insurance_comp=null, ins_begindate=null, ins_endindate=null, ins_cost=null, agent_chdate=null, manager_chdate=null";
		
		$pledgeresetupdate = mysqli_query($connect_link, "UPDATE pledge_data SET $bospledgereset WHERE id='$id'");}
	}
	
	if($_SESSION['users_role'] == 'manager' || $_SESSION['bank_department'] == "system"){
		if($_POST["pledgeconfirm_submit"]){
		$managernote = mysqli_real_escape_string($connect_link,defend_input($_POST['form_managernote']));
		$credmanager = $_SESSION['auth_admin_login'];
		$_SESSION['msg'] = "<p id='form-success'>Girov uğurla təsdiqləndi!</p>";
		$bospledgeconfirm = "manager_decision='təsdiq', manager_chdate=NOW(), manager='".$credmanager."', manager_notes='".$managernote."'";
		$pledgeconfirmupdate = mysqli_query($connect_link, "UPDATE pledge_data SET $bospledgeconfirm WHERE id='$id'");}
	}
	
	if($_SESSION['users_role'] == 'user' || $_SESSION['bank_department'] == "system"){
		if($_POST["updpledge_submit"]){
			
	$persontype = mysqli_real_escape_string($connect_link,defend_input($_POST['persontype_select']));
	$pledger = mysqli_real_escape_string($connect_link,defend_input($_POST['form_pledger']));
	$pledocid = mysqli_real_escape_string($connect_link,defend_input($_POST['form_pledocid']));
	$phonumber = mysqli_real_escape_string($connect_link,defend_input($_POST['form_phonumber']));
	$mail = mysqli_real_escape_string($connect_link,defend_input($_POST['form_mail']));
	$regadres = mysqli_real_escape_string($connect_link,defend_input($_POST['form_regadres']));
	$pledges = mysqli_real_escape_string($connect_link,defend_input($_POST['pledge_select']));
	$markvalue = mysqli_real_escape_string($connect_link,defend_input($_POST['form_markvalue']));
	$liqvalue = mysqli_real_escape_string($connect_link,defend_input($_POST['form_liqvalue']));
	$plcurrency = mysqli_real_escape_string($connect_link,defend_input($_POST['plcurrency_select']));
	$description = mysqli_real_escape_string($connect_link,defend_input($_POST['form_description']));
	$sitadres = mysqli_real_escape_string($connect_link,defend_input($_POST['form_sitadres']));
	$regid = mysqli_real_escape_string($connect_link,defend_input($_POST['form_regid']));
	$agentnote = mysqli_real_escape_string($connect_link,defend_input($_POST['form_agentnote']));
	
	$error = array();
			
	if(!$persontype){$error[] = "girovqoyan şəxsin tipini seçin!";}
	if(!$pledger){$error[] = "girovqoyanın inisialını tam yazın!";}
	if(!$pledocid){$error[] = "girovqoyanın ya VÖEN kodunu, ya da Fin kodunu yazın!";}
	if(!$phonumber){$error[] = "girovqoyanın minimal iki telefon nömrəsini yazın!";}
	if(!$mail){$error[] = "girovqoyanın email ünvanını yazın!";}
	if(!$regadres){$error[] = "girovqoyanın sənəd üzrə ünvanını tam yazın!";}
	if(!$pledges){$error[] = "girov qoyulan əmlakın tipini seçin!";}
	if(!$markvalue){$error[] = "girovun real dəyərini yazın!";}
	if(!$liqvalue){$error[] = "girovun likvid dəyərini yazın!";}
	if(!$plcurrency){$error[] = "girovun dəyərinin vlayutasını yazın!";}
	if(!$description){$error[] = "girov barədə ətraflı yazın!";}
	if(!$sitadres){$error[] = "girovun yerləşdiyi ünvanı tam yazın!";}
	if(!$regid){$error[] = "girovun sənəd (Reyestr/Ban/Şassi/Hesab) nömrəsini yazın!";}	
			
			if($_POST["persontype_select"] == "Fiziki şəxs"){
	$docsernum = mysqli_real_escape_string($connect_link,defend_input($_POST['form_docsernum']));
	$docgovename = mysqli_real_escape_string($connect_link,defend_input($_POST['form_docgovename']));
	$docregdate = mysqli_real_escape_string($connect_link,defend_input($_POST['form_docregdate']));
	$error = array();		
	if(!$docsernum){$error[] = "şəxsiyyət vəsiqəsinin seriya və kodunu yazın!";}
	if(!$docgovename){$error[] = "şəxsiyyət vəsiqəsini verən orqanı yazın!";}
	if(!$docregdate){$error[] = "şəxsiyyət vəsiqəsinin verilmə tarixini yazın!";}
	$personbase = "doc_sernum='".$docsernum."', doc_govname='".$docgovename."', doc_regdate='".$docregdate."',";
			}
			else{
	$dirtype = mysqli_real_escape_string($connect_link,defend_input($_POST['form_dirtype']));
	$dirinit = mysqli_real_escape_string($connect_link,defend_input($_POST['form_dirinit']));
	$error = array();		
	if(!$dirtype){$error[] = "səlahiyyətli şəxsin vəzifəsini yazın!";}
	if(!$dirinit){$error[] = "səlahiyyətli şəxsin inisiallarını yazın!";}
	$personbase = "ceo_post='".$dirtype."', ceo_init='".$dirinit."',";
			}
			if($_POST["pledge_select"] == "minik avtomobili" || $_POST["pledge_select"] == "yük avtomobili" || $_POST["pledge_select"] == "kənd təsərrüfatı texnikası" || $_POST["pledge_select"] == "tikinti sektoru texnikası"){
	$brand = mysqli_real_escape_string($connect_link,defend_input($_POST['form_brand']));
	$model = mysqli_real_escape_string($connect_link,defend_input($_POST['form_model']));
	$colour = mysqli_real_escape_string($connect_link,defend_input($_POST['form_colour']));
	$vehtype = mysqli_real_escape_string($connect_link,defend_input($_POST['form_vehtype']));
	$proyear = mysqli_real_escape_string($connect_link,defend_input($_POST['form_proyear']));
	$aprais = mysqli_real_escape_string($connect_link,defend_input($_POST['form_aprais']));
	$evaldate = mysqli_real_escape_string($connect_link,defend_input($_POST['form_evaldate']));
	$insurance = mysqli_real_escape_string($connect_link,defend_input($_POST['form_insurance']));
	$cost = mysqli_real_escape_string($connect_link,defend_input($_POST['form_cost']));
	$insbegdate = mysqli_real_escape_string($connect_link,defend_input($_POST['form_insbegdate']));
	$insendate = mysqli_real_escape_string($connect_link,defend_input($_POST['form_insendate']));
	$error = array();		
	if(!$brand){$error[] = "nəqliyyat vasitəsinin markasını yazın!";}
	if(!$model){$error[] = "nəqliyyat vasitəsinin modelini yazın!";}
	if(!$colour){$error[] = "nəqliyyat vasitəsinin rəngini yazın!";}
	if(!$vehtype){$error[] = "nəqliyyat vasitəsinin ban tipini yazın!";}
	if(!$proyear){$error[] = "nəqliyyat vasitəsinin buraxılış ilini yazın!";}
	if(!$aprais){$error[] = "əmlaka qiymət qoyan şirkəti yazın!";}
	if(!$evaldate){$error[] = "əmlaka qiymətqoyma tarixini yazın!";}
	if(!$insurance){$error[] = "əmlakı sığorta edən şirkəti yazın!";}
	if(!$cost){$error[] = "əmlakın sığorta edilən dəyərini yazın!";}
	if(!$insbegdate){$error[] = "sığortanın başlama tarixini yazın!";}
	if(!$insendate){$error[] = "sığortanın bitmə tarixini yazın!";}
	$pledgesbase = "brand='".$brand."', model='".$model."', vehicle_colour='".$colour."', vehicle_type='".$vehtype."', property_year='".$proyear."', appraiser='".$aprais."', evaluation_date='".$evaldate."', insurance_comp='".$insurance."', ins_begindate='".$insbegdate."', ins_endindate='".$insendate."', ins_cost='".$cost."',";
			}
			if($_POST["pledge_select"] == "torpaq sahəsi" || $_POST["pledge_select"] == "əmlak kompleksi" || $_POST["pledge_select"] == "qeyri-yaşayış sahəsi" || $_POST["pledge_select"] == "fərdi yaşayış evi" || $_POST["pledge_select"] == "bağ evi" || $_POST["pledge_select"] == "mənzil"){
	$ownship = mysqli_real_escape_string($connect_link,defend_input($_POST['ownship_select']));
	$part = mysqli_real_escape_string($connect_link,defend_input($_POST['part_select']));
	$appoint = mysqli_real_escape_string($connect_link,defend_input($_POST['form_appoint']));
	$aprais = mysqli_real_escape_string($connect_link,defend_input($_POST['form_aprais']));
	$evaldate = mysqli_real_escape_string($connect_link,defend_input($_POST['form_evaldate']));
	$insurance = mysqli_real_escape_string($connect_link,defend_input($_POST['form_insurance']));
	$cost = mysqli_real_escape_string($connect_link,defend_input($_POST['form_cost']));
	$insbegdate = mysqli_real_escape_string($connect_link,defend_input($_POST['form_insbegdate']));
	$insendate = mysqli_real_escape_string($connect_link,defend_input($_POST['form_insendate']));
	$error = array();
	if(!$ownship){$error[] = "xüsusi və ya dövlət mülkiyyəti olduğunu yazın!";}
	if(!$part){$error[] = "paylı və ya tam mülkiyyət olduğunu yazın!";}
	if(!$appoint){$error[] = "əmlakın sənəd üzrə təyinatını yazın!";}
	if(!$aprais){$error[] = "əmlaka qiymət qoyan şirkəti yazın!";}
	if(!$evaldate){$error[] = "əmlaka qiymətqoyma tarixini yazın!";}
	$pledgesbase = "ownership='".$ownship."', portion='".$part."', appointment='".$appoint."', appraiser='".$aprais."', evaluation_date='".$evaldate."', insurance_comp='".$insurance."', ins_begindate='".$insbegdate."', ins_endindate='".$insendate."', ins_cost='".$cost."',";
			}
			if(count($error)){
				$_SESSION['msg'] = "<p id='form-error'>".implode('<br>',$error)."</p>";
			}
			else{
				$_SESSION['msg'] = "<p id='form-success'>Girov redaktə edildi!</p>";
				
				$pledgedit = "$personbase $pledgesbase person_type='".$persontype."', mortgagor='".$pledger."', reg_address='".$regadres."', fincode_taxes='".$pledocid."', phone_numbers='".$phonumber."', email_addr='".$mail."', pledge_name='".$pledges."', pledge_description='".$description."', pledge_address='".$sitadres."', pledge_cost='".$markvalue."', liquid_cost='".$liqvalue."', pledge_currency='".$plcurrency."', register_id='".$regid."', agent_chdate=NOW(),  agent_notes='".$agentnote."'";
				
				$pledgupdate = mysqli_query($connect_link, "UPDATE pledge_data SET $pledgedit WHERE id='$id'");
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
                	$filePath = "upload_pledges/" . date('d-m-Y-H-i-s').'-'.$_FILES['upload']['name'][$i];
					$picfordb = date('d-m-Y-H-i-s').'-'.$_FILES['upload']['name'][$i];
                	if(move_uploaded_file($tmpFilePath, $filePath)) {
						$files[] = $shortname;
						mysqli_query($connect_link, "INSERT INTO upload_collimg (pledge_id, pledge_images) VALUES ('$id', '$picfordb')");}
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
<title>Girova bax</title>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="javascripts/scriptlerim.js"></script>
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
		<?php include("inc_blocks/vpleblok.php")?>
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