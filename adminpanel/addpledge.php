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
	if($_SESSION['users_role'] == 'user' || $_SESSION['bank_department'] == "system"){
		if($_POST["pledge_submit"]){
			
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
	$credagent = $_SESSION['auth_admin_login'];
	$man_res = mysqli_query($connect_link,"SELECT compliance FROM users WHERE login='{$_SESSION['auth_admin_login']}'");
		$man_row = mysqli_fetch_assoc($man_res);
		$credmanager = $man_row['compliance'];
	
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
	$personbase = "doc_sernum, doc_govname, doc_regdate,";
	$persondata = "'".$docsernum."','".$docgovename."','".$docregdate."',";
			}
			else{
	$dirtype = mysqli_real_escape_string($connect_link,defend_input($_POST['form_dirtype']));
	$dirinit = mysqli_real_escape_string($connect_link,defend_input($_POST['form_dirinit']));
	$error = array();		
	if(!$dirtype){$error[] = "səlahiyyətli şəxsin vəzifəsini yazın!";}
	if(!$dirinit){$error[] = "səlahiyyətli şəxsin inisiallarını yazın!";}
	$personbase = "ceo_post, ceo_init,";
	$persondata = "'".$dirtype."','".$dirinit."',";
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
	$pledgesbase = "brand, model, vehicle_colour, vehicle_type, property_year, appraiser, evaluation_date, insurance_comp, ins_begindate, ins_endindate, ins_cost,";
	$pledgesdata = "'".$brand."', '".$model."', '".$colour."', '".$vehtype."', '".$proyear."', '".$aprais."', '".$evaldate."', '".$insurance."', '".$insbegdate."', '".$insendate."', '".$cost."',";
			}
			if($_POST["pledge_select"] == "torpaq sahəsi" || $_POST["pledge_select"] == "əmlak kompleksi" || $_POST["pledge_select"] == "qeyri-yaşayış sahəsi" || $_POST["pledge_select"] == "fərdi yaşayış evi" || $_POST["pledge_select"] == "bağ evi" || $_POST["pledge_select"] == "mənzil"){
	$ownship = mysqli_real_escape_string($connect_link,defend_input($_POST['ownship_select']));
	$part = mysqli_real_escape_string($connect_link,defend_input($_POST['part_select']));
	$appoint = mysqli_real_escape_string($connect_link,defend_input($_POST['form_appoint']));
	$aprais = mysqli_real_escape_string($connect_link,defend_input($_POST['form_aprais']));
	$evaldate = mysqli_real_escape_string($connect_link,defend_input($_POST['form_evaldate']));
	if($_POST["pledge_select"] != "torpaq sahəsi"){
	$insurance = mysqli_real_escape_string($connect_link,defend_input($_POST['form_insurance']));
	$cost = mysqli_real_escape_string($connect_link,defend_input($_POST['form_cost']));
	$insbegdate = mysqli_real_escape_string($connect_link,defend_input($_POST['form_insbegdate']));
	$insendate = mysqli_real_escape_string($connect_link,defend_input($_POST['form_insendate']));
	$nolandbase = "insurance_comp, ins_begindate, ins_endindate, ins_cost,";
	$nolandchan = "'".$insurance."', '".$insbegdate."', '".$insendate."', '".$cost."',";
	}
	$error = array();
	if(!$ownship){$error[] = "xüsusi və ya dövlət mülkiyyəti olduğunu yazın!";}
	if(!$part){$error[] = "paylı və ya tam mülkiyyət olduğunu yazın!";}
	if(!$appoint){$error[] = "əmlakın sənəd üzrə təyinatını yazın!";}
	if(!$aprais){$error[] = "əmlaka qiymət qoyan şirkəti yazın!";}
	if(!$evaldate){$error[] = "əmlaka qiymətqoyma tarixini yazın!";}
	
	$pledgesbase = "ownership, portion, appointment, appraiser, evaluation_date, $nolandbase";
	$pledgesdata = "'".$ownship."', '".$part."', '".$appoint."', '".$aprais."', '".$evaldate."', $nolandchan";
			}
			if(count($error)){
				$_SESSION['msg'] = "<p id='form-error'>".implode('<br>',$error)."</p>";
			}
			else{
				$_SESSION['msg'] = "<p id='form-success'>Girov uğurla yaddaşa verildi!</p>";
				mysqli_query($connect_link,"INSERT INTO pledge_data($personbase $pledgesbase person_type, mortgagor, reg_address, fincode_taxes, phone_numbers, email_addr, pledge_name, pledge_description, pledge_address, pledge_cost, liquid_cost, pledge_currency, register_id, agent_chdate, agent_notes, agent, manager)
						VALUES(
							$persondata $pledgesdata
							'".$persontype."',
							'".$pledger."',
							'".$regadres."',
							'".$pledocid."',
							'".$phonumber."',
							'".$mail."',
                            '".$pledges."',
                            '".$description."',
							'".$sitadres."',
							'".$markvalue."',
							'".$liqvalue."',
                            '".$plcurrency."',
							'".$regid."',
							NOW(),
							'".$agentnote."',
							'".$credagent."',
							'".$credmanager."'
						)");
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
<title>Girov əlavə et</title>
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
		<?php include("inc_blocks/apblok.php")?>
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