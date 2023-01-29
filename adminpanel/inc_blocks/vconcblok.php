<?php 
defined('mcsystem') or die('Cəhdin yaxşı idi, sərf etdiyin vaxtı başqa şeyə sərf et!');

if($_SESSION['msg']){
		echo $_SESSION['msg'];
		unset($_SESSION['msg']);
}

if($_SESSION['users_role'] == 'verifier'){
	$verfier = $_SESSION['auth_admin_login'];
	$forverifier = "AND verifier='$verfier'";
}

if($_SESSION['users_role'] == 'officer'){
	$oficer = $_SESSION['auth_admin_login'];
	$forofficer = "AND officer='$oficer'";
}

$pledge_conc = mysqli_query($connect_link,"SELECT * FROM pledge_concat WHERE id='$id' $forverifier $forofficer");
if(mysqli_num_rows($pledge_conc)>0){
	$plconc_row = mysqli_fetch_assoc($pledge_conc);
	
if($_SESSION['concat_edit'] == '1'){echo '
<form method="post">
	<div id="yigilma_sahesi">';
									
	if($_SESSION['bank_department'] == "system"){
	echo '
	<p>Sistem nəzarətçisinin RESETi</p>
	<div>
		<input type="submit" name="concatreset_submit" id="form_submit" value="RESET">
	</div>';}
									
	if($_SESSION['bank_department'] == "system" || $_SESSION['users_role'] == 'officer'){ 
		if(!isset($plconc_row["enter_date"])){ echo '
	<p>Girov kredit birləşməsi</p>
	<div>
		<select name="credit_select">
			<option value="" selected disabled>krediti seç</option>';
$credit_result = mysqli_query($connect_link,"SELECT id, unical_credid FROM cre_data WHERE credit_status='aktiv' ORDER BY id DESC");
if(mysqli_num_rows($credit_result)>0){
	$credit_row = mysqli_fetch_assoc($credit_result);
	do{ echo '
		<option value="'.$credit_row['id'].'"> '.$credit_row['unical_credid'].'</option>';}
	while($credit_row = mysqli_fetch_assoc($credit_result));
}
		echo '</select>
	</div>
	<div>
		<select name="pledge_select">
			<option value="" selected disabled>girovu seç</option>';
$pledge_result = mysqli_query($connect_link,"SELECT id, pledge_name, pledge_cost, pledge_currency, register_id FROM pledge_data WHERE manager_decision='təsdiq'");
if(mysqli_num_rows($pledge_result)>0){
	$pledge_row = mysqli_fetch_assoc($pledge_result);
	do{ echo '
		<option value="'.$pledge_row['id'].'" title="'.$pledge_row['pledge_cost'].' '.$pledge_row['pledge_currency'].'">'.$pledge_row['pledge_name'].' - '.$pledge_row['register_id'].'</option>';}
	while($pledge_row = mysqli_fetch_assoc($pledge_result));
}
		echo '</select>
	</div>
	<div>
		<select name="contract_select">
			<option value="" selected disabled>müqavilə növü seç</option>
			<option value="İlkin">İlkin girovasalma</option>
			<option value="Sonrakı">Sonrakı girovasalma</option>
		</select>
	</div>
	<div>
		<input name="form_contractdate" type="date" title="girovasalma tarixi" value="'.$plconc_row["start_date"].'">
	</div>
	<div>
		<input name="form_endate" type="date" title="girovdan azad tarixi" value="'.$plconc_row["end_date"].'">
	</div>
	<div>
		<input type="submit" name="updconc_submit" id="form_submit" value="Redaktə et">
	</div><br><br>';}
	}
	
	if($_SESSION['bank_department'] == "system" || $_SESSION['users_role'] == "verifier"){
		if(!isset($plconc_row["verify_date"])){echo '
	<p>Rəhbərin təsdiqi</p>
	<div>
		<input type="submit" name="concatconfirm_submit" id="form_submit" value="Təsdiqlə">
	</div>';}
	}
echo '
	</div>
</form>';}
	
	if($_SESSION['concat_view'] == '1' || $_SESSION['auth_admin_login'] == $plconc_row["verifier"] || $_SESSION['auth_admin_login'] == $plconc_row["officer"]){
		if(isset($plconc_row["enter_date"])){
			
	$res_cred = mysqli_query($connect_link,"SELECT unical_credid FROM cre_data WHERE id='{$plconc_row["credit_id"]}'");
	$cre_row = mysqli_fetch_assoc($res_cred);
			
	$res_pled = mysqli_query($connect_link,"SELECT register_id, pledge_name FROM pledge_data WHERE id='{$plconc_row["pledge_id"]}'");
	$ple_row = mysqli_fetch_assoc($res_pled);
	
echo '
<div id="midblock">
	<p>Birləşmə barədə</p>
	<div title="birləşən kredit">'.$cre_row["unical_credid"].'</div>
	<div title="birləşən girov">'.$ple_row["pledge_name"].' - '.$ple_row["register_id"].'</div>
	<div title="girovun müqavilə növü">'.$plconc_row["contract_type"].'</div>
	<div title="girovun rəsmiləşmə tarixi">'.date_format(date_create($plconc_row["start_date"]),"d-m-Y").'</div>';
	if(isset($plconc_row["end_date"])){ echo '
	<div title="girovdan azadolma tarixi">'.date_format(date_create($plconc_row["end_date"]),"d-m-Y").'</div>';}
	echo '<p>Birləşdirmədə iştirak edənlər</p>
	<div title="təsdiqlənibmi">'.$plconc_row["verified"].'</div>
	<div title="yığan əməliyyatçı">'.$plconc_row["officer"].'</div>
	<div title="təsdiqləyən rəhbər">'.$plconc_row["verifier"].'</div>';
	if(isset($plconc_row["enter_date"])){ echo '
	<div title="əməliyyatçının sistemə yığdığı tarix">'.date_format(date_create($plconc_row["enter_date"]),"d-m-Y H:i:s").'</div>';}
	if(isset($plconc_row["verify_date"])){ echo '
	<div title="əməliyyatçının sistemdə təsdiq etdiyi tarix">'.date_format(date_create($plconc_row["verify_date"]),"d-m-Y H:i:s").'</div>';}
echo '</div>';}
	};
}
?>