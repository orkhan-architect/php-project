<?php 
defined('mcsystem') or die('Cəhdin yaxşı idi, sərf etdiyin vaxtı başqa şeyə sərf et!');

if($_SESSION['msg']){
		echo $_SESSION['msg'];
		unset($_SESSION['msg']);
}

if($_SESSION['bank_department'] == "assembler"){
	$forassembs = "AND branch_code='{$_SESSION['user_branch']}'";
}

$customer_result = mysqli_query($connect_link,"SELECT * FROM cstmr_data WHERE id='$id' $forassembs");
if(mysqli_num_rows($customer_result)>0){
	$customer_row = mysqli_fetch_assoc($customer_result);
	$branchcode = $customer_row["branch_code"];
	$loginuser = $customer_row["login"];
	
if($_SESSION['customer_edit'] == '1'){ echo '
<form method="post" enctype="multipart/form-data">';
if($_SESSION['users_role'] == 'verifier' || $_SESSION['bank_department'] == "system"){
	if($customer_row["status"] == "aktiv"){ echo '
<div class="headerbox">İnzibatçı-rəhbərin təyinat və təsdiqi</div>
<div class="infobox">
	<div>
		<select name="officer_select" id="officersel">
			<option value="" selected disabled>əməliyatçını seçin</option>';
		$officer_result = mysqli_query($connect_link,"SELECT login, nsp FROM users WHERE branch='$branchcode' AND role='officer'"); 
		if(mysqli_num_rows($officer_result) > 0){
			$officer_row = mysqli_fetch_assoc($officer_result);
			do{
				echo '<option value="'.$officer_row["login"].'">'.$officer_row["nsp"].'</option>';
			}
			while($officer_row = mysqli_fetch_assoc($officer_result));
		}
	echo '</select>
	</div>
	<div><input type="submit" name="appoint_submit" id="form_submit" value="Təyin et"></div>
</div>';}
																					  
	if($customer_row["officer_verified"] == "yes" && $customer_row["verified"] != "yes" && $customer_row["police_verified"] == "yes"){ echo '

<div class="infobox">
	<div><input type="submit" name="bossverify_submit" id="form_submit" value="Təsdiq et"></div>
</div>';}
																					  
	if($customer_row["officer_verified"] == "yes"){ echo '
<div class="headerbox">İnzibatçı-rəhbərin təyinat və təsdiqi</div>
<div class="infobox">
	<div><input type="submit" name="reset_submit" id="form_submit" value="RESET"></div>
</div>';}
}
	
if($_SESSION['bank_department'] == 'account_controllers' || $_SESSION['bank_department'] == "system"){
	if(!isset($customer_row["policeverify_date"])){ echo '
<div class="headerbox">Problemli şəxslərlə bağlı idarəçilik</div>
<div class="infobox">
	<div>
		<select name="policeop_select" id="busisel">
			<option value="" selected disabled>Rəyinizi bildirin</option>
			<option value="no">imtina</option>
			<option value="yes">təsdiq</option>
		</select>
	</div>
	<div>
		<input type="text" id="policenotes" name="police_vernotes" autocomplete="off" title="müştəri yoxlayıcısının qeydi">
	</div>
	<div><input type="submit" name="normalclient_submit" id="form_submit" value="Təsdiqləmək"></div>
</div>';}
}
	
if($_SESSION['auth_admin_login'] == $customer_row["profile_officer"] || $_SESSION['bank_department'] == "system"){
	if($customer_row["verified"] != 'yes' && $customer_row["officer_verified"] != "yes" && !isset($customer_row["deactiv_date"])){
		$profilcode = fungenpass();
		echo '
<div class="headerbox">Əməliyyatçının idarəçiliyi</div>
<div class="infobox">
	<div><input type="submit" name="deactivate_submit" id="form_submit" value="Deaktivasiya"></div>';
	if($customer_row["status"] == "təyinat"){echo '
	<div>
		<input type="text" id="codegener" name="statuscodegen" title="müştərinin status kodu" value="'.$profilcode.'">
	</div>
	<div><input type="submit" name="checked_submit" id="form_submit" value="Yoxlanıldı"></div>';}
echo '</div>';}

	if($customer_row["police_verified"] == 'yes' && $customer_row["verified"] != 'yes' && $customer_row["officer_verified"] != "yes"){
		
		if($customer_row["bus_type"] == ""){$autosel = "selected";}
		if($customer_row["bus_type"] == "Maliyyə"){$finance = "selected";}
		if($customer_row["bus_type"] == "İstehsal"){$production = "selected";}
		if($customer_row["bus_type"] == "Ticarət"){$bazaar = "selected";}
		if($customer_row["bus_type"] == "Digər"){$otherentity = "selected";}
		
		echo'
<div class="headerbox">Müştəri barədə xüsusi qeydlər</div>
<div class="infobox">
	<div class="cheboxes">
		<input type="checkbox" id="belon" name="belon" value="checked" '.$customer_row["belong"].'>
		<label for="belon">Aidiyyatı şəxs</label>
	</div>
	<div class="cheboxes">
		<input type="checkbox" id="relate" name="relate" value="checked" '.$customer_row["related"].'>
		<label for="relate">Bankla əlaqəli şəxs</label>
	</div>
	<div class="cheboxes">
		<input type="checkbox" id="goventit" name="goventit" value="checked" '.$customer_row["gover_entity"].'>
		<label for="goventit">Dövlət müəssisəsi</label>
	</div>
	<div class="cheboxes">
		<input type="checkbox" id="adminceo" name="adminceo" value="checked" '.$customer_row["administration"].'>
		<label for="adminceo">İnzibatçı və yaxın qohumları</label>
	</div>
	<div class="cheboxes">
		<input type="checkbox" id="deparboss" name="deparboss" value="checked" '.$customer_row["depart_boss"].'>
		<label for="deparboss">Str. bölmə rəhbəri və yaxın qohumları</label>
	</div><br><br>
	<div>
		<select name="business_select" id="busisel">
			<option value="" disabled '.$autosel.'>ticarət sektorunu seçin</option>
			<option value="Maliyyə" '.$finance.'>Maliyyə sektoru</option>
			<option value="İstehsal" '.$production.'>İstehsal sektoru</option>
			<option value="Ticarət" '.$bazaar.'>Ticarət sektoru</option>
			<option value="Digər" '.$otherentity.'>Digər sektor</option>
		</select>
	</div>
	<div>
		<input type="text" id="thirdperson" name="checker_thperson" autocomplete="off" title="hal-hazırda profili idarə edən şəxs (max.40 simvol)"  value="'.$customer_row["profile_controlling"].'">
	</div>
	<div>
		<input type="text" id="officerpnotes" name="checker_opnotes" autocomplete="off" title="inzibatçı-əməliyyatçının qeydi"  value="'.$customer_row["personal_notes"].'">
	</div>';
	
	if($customer_row["status"] == "baxıldı" && $customer_row["officer_verified"] != "yes" && $customer_row["police_verified"] == "yes"){ echo '
	<div><input type="submit" name="ofcerverify_submit" id="form_submit" value="Təsdiq et"></div>';}
	echo '
</div>

<div class="infobox">
	<div style="display: none;">
		<input type="text" id="ptype" name="checker_ptype" title="müştəri tipi (Bu xanaya TOXUNMAYIN)"  value="'.$customer_row["person_type"].'">
	</div>
</div>';
		
if($customer_row["person_type"] == "Hüquqi şəxs"){echo '
<div class="headerbox">Şirkətin dövlət qeydiyyatı barədə qısa məlumat</div>
<div class="infobox">
	<div>
		<input type="text" id="combostype" name="checker_bosstype" autocomplete="off" title="idarəedən şəxsin vəzifəsi" onkeyup="this.value = this.value.toUpperCase();" value="'.$customer_row["ceo_post"].'">
	</div>
	<div>
		<input type="text" id="combosname" name="checker_bossname" autocomplete="off" title="vəzifəli şəxsin ASA" onkeyup="this.value = this.value.toUpperCase();" value="'.$customer_row["ceo_init"].'">
	</div>
	<div>
		<input type="text" id="combusisphere" name="checker_sphere" autocomplete="off" title="fəaliyyət sahəsi" value="'.$customer_row["business_sphere"].'">
	</div>
	<div>
		<input type="text" id="comportion" name="checker_portions" autocomplete="off" title="təsisçilərin payı" value="'.$customer_row["sh_portion"].'">
	</div>
	<div>
		<input type="text" id="comshaholder" name="checker_holders" autocomplete="off" title="təsisçilərin ASA" onkeyup="this.value = this.value.toUpperCase();" value="'.$customer_row["shareholders"].'">
	</div>
</div>';}
		
if($customer_row["person_type"] == "Fiziki şəxs / Fərdi sahibkar"){echo '
<div class="headerbox">Vətəndaşlıq sənədi barədə qısa məlumat</div>
<div class="infobox">
	<div>
		<input type="text" id="docnumber" name="checker_sernumber" autocomplete="off" title="vəsiqənin seriya və kodu" onkeyup="this.value = this.value.toUpperCase();" value="'.$customer_row["doc_sernum"].'">
	</div>
	<div>
		<input type="text" id="docname" name="checker_govername" autocomplete="off" title="vəsiqəni verən orqan" onkeyup="this.value = this.value.toUpperCase();" value="'.$customer_row["doc_govname"].'">
	</div>
	<div>
		<input type="date" id="docdate" name="checker_docrdate" autocomplete="off" title="vəsiqənin verilmə tarixi (tarix formatı - ay/gün/il)" value="'.$customer_row["doc_regdate"].'">
	</div>
	<div>
		<input type="text" id="indtaxid" name="checker_itaxid" autocomplete="off" title="sahibkar VÖENi" value="'.$customer_row["ind_taxesid"].'">
	</div>
</div>';}
		
echo '
<div class="headerbox">Müştəri ilə əlaqə məlumatları</div>
<div class="infobox">
	<div>
		<input type="text" id="cusradres" name="checker_radres" autocomplete="off" title="müştərinin qeydiyyatda olduğu ünvan" value="'.$customer_row["reg_address"].'">
	</div>
</div>

<div class="headerbox">Müştəri haqqında qısa məlumat</div>
<div class="infobox">
	<div>
		<input type="date" id="bodate" name="checker_bdate" title="vətəndaşın doğum və ya şirkətin vergi qeydiyyatı tarixi (tarix formatı - ay/gün/il)"  value="'.$customer_row["born_date"].'">
	</div>
	<div>
		<input type="text" id="concode" name="checker_contrycode" title="müştərinin doğulduğu və ya şirkətin mənsub olduğu ölkə kodu" onkeyup="this.value = this.value.toUpperCase()"  value="'.$customer_row["born_contrycode"].'">
	</div>
	<div>
		<input type="text" id="contname" name="checker_contryname" title="müştərinin doğulduğu və ya şirkətin yarandığı yer" onkeyup="this.value = this.value.toUpperCase()"  value="'.$customer_row["born_place"].'">
	</div>
	<div>
		<input type="text" id="cusresidency" name="checker_residency" title="müştərinin rezidentliyi" value="'.$customer_row["nationality"].'">
	</div>
</div>';}
}
									  
if($_SESSION['bank_department'] == 'system' && $customer_row["verified"] != 'yes' && $customer_row["officer_verified"] != "yes" && !isset($customer_row["deactiv_date"])){ echo '
<div class="headerbox">Xüsusi icazəli xanalar</div>
<div class="infobox">
	<div>
		<input type="text" id="clientbx" name="checker_clientnsp" autocomplete="off" title="müştərinin inisialı" onkeyup="this.value = this.value.toUpperCase();" value="'.$customer_row["client"].'">
	</div>
	<div>
		<input type="text" id="idbx" name="checker_specid" autocomplete="off" title="müştərinin fin kodu / VÖEN" onkeyup="this.value = this.value.toUpperCase();" value="'.$customer_row["login"].'">
	</div>
	<div>
		<input type="text" id="vernumbx" name="checker_vernum" autocomplete="off" title="təsdiqləyici mobil" onkeyup="this.value = this.value.toUpperCase();" value="'.$customer_row["myphone"].'">
	</div>
	<div><input type="submit" name="specialsubmit" id="form_submit" value="Dəyiş"></div>
</div>';}
									  
if($_SESSION['users_role'] == 'admin' && !isset($customer_row["deactiv_date"])){ echo '
<div class="headerbox">Şəkil əlavə etmə funksiyası</div>
<div class="infobox">
	<div>
		<input type="file" name="upload[]" id="upload" multiple>
	</div>
	<div><input type="submit" name="filesubmit" id="form_submit" value="Yüklə"></div>
</div>';}
echo '</form><br>';}
	
$chosenloaneresult = mysqli_query($connect_link, "SELECT cho_creditor, cho_manager FROM cre_orders WHERE client='$loginuser'");
$chosenloaner_row = mysqli_fetch_assoc($chosenloaneresult);
	
if($_SESSION['customer_view'] == '1' || $_SESSION['auth_admin_login'] == $customer_row["profile_officer"] || $_SESSION['auth_admin_login'] == $customer_row["profile_verifier"] || $_SESSION['auth_admin_login'] == $chosenloaner_row["cho_creditor"] || $_SESSION['auth_admin_login'] == $chosenloaner_row["cho_manager"]){
	
echo '<div id="midblock">
	<p>Müştəri barədə</p>
	<div title="müştəri tipi">'.$customer_row["person_type"].'</div>
	<div title="müştəri FIN kodu/VÖEN">'.$customer_row["login"].'</div>	
	<div title="müştəri inisialı">'.$customer_row["client"].'</div>
	<div title="müştərinin doğum/yaranma tarixi">'.date_format(date_create($customer_row["born_date"]),"d-m-Y").'</div>';
	if($customer_row["person_type"] == 'Fiziki şəxs / Fərdi sahibkar'){echo '
	<div title="müştərinin sahibkar VÖENi">'.$customer_row["ind_taxesid"].'</div><br><br>
	<div title="müştərinin sənəd nömrəsi">'.$customer_row["doc_sernum"].'</div>
	<div title="müştəri vəsiqəsinin qeydiyyat orqanı">'.$customer_row["doc_govname"].'</div>
	<div title="müştəri vəsiqəsinin qeydiyyat tarixi">'.date_format(date_create($customer_row["doc_regdate"]),"d-m-Y").'</div>
	';}
	else{echo '
	<div title="şirkəti idarəedənin vəzifəsi">'.$customer_row["ceo_post"].'</div>
	<div title="şirkəti idarəedənin inisialı">'.$customer_row["ceo_init"].'</div><br><br>
	<div title="şirkətin təsisçiləri">'.$customer_row["shareholders"].'</div>
	<div title="şirkətdə pay bölgüsü">'.$customer_row["sh_portion"].'</div>
	<div title="şirkətin fəaliyyət sahəsi">'.$customer_row["business_sphere"].'</div>
	';}
echo '
	<p>Müştəri ilə əlaqə</p>
	<div title="müştərinin əsas qeydiyyat telefon nömrəsi">'.$customer_row["myphone"].'</div>
	<div title="müştəri ilə əlaqə üçün digər telefon nömrələri">'.$customer_row["phone"].'</div>
	<div title="müştərinin email ünvanı">'.$customer_row["email"].'</div><br><br>
	<div title="müştərinin qeydiyyat ünvanı">'.$customer_row["reg_address"].'</div><br><br>
	<div title="müştərinin yaşadığı/fəaliyyət ünvanı">'.$customer_row["liv_address"].'</div>';
	
	if(isset($customer_row["nationality"])){echo '
	<p>Əməliyyatçıya aid xanalar</p>';
	if(isset($customer_row["ofcer_checkdate"])){echo '<div title="profili ilk yoxladığı tarix">'.date_format(date_create($customer_row["ofcer_checkdate"]),"d-m-Y H:i:s").'</div>';}
	if(isset($customer_row["ofcer_verifydate"])){echo '<div title="profili təsdiqlədiyi tarix">'.date_format(date_create($customer_row["ofcer_verifydate"]),"d-m-Y H:i:s").'</div>';}
	if(isset($customer_row["policeverify_date"])){echo '<div title="profili təsdiqlədiyi tarix">'.date_format(date_create($customer_row["policeverify_date"]),"d-m-Y H:i:s").'</div>';}
	if(isset($customer_row["deactiv_date"])){echo '<div title="profilin deaktiv edildiyi tarix">'.date_format(date_create($customer_row["deactiv_date"]),"d-m-Y H:i:s").'</div>';}
	echo '
	<div title="əməliyyatçı">'.$customer_row["profile_officer"].'</div>
	<div title="əməliyyatçının qərarı">'.$customer_row["officer_verified"].'</div>
	<div title="müştərinin vətəndaşı olduğu ölkə kodu">'.$customer_row["born_contrycode"].'</div>
	<div title="müştərinin doğulduğu yer">'.$customer_row["born_place"].'</div>
	<div title="müştərinin yerli və ya xarici olması">'.$customer_row["nationality"].'</div><br><br>';
	if($customer_row["belong"] == "checked"){echo '<div>Aidiyyatı şəxs</div>';}
	if($customer_row["related"] == "checked"){echo '<div>Bankla əlaqəli şəxs</div>';}
	if($customer_row["gover_entity"] == "checked"){echo '<div>Dövlət müəssisəsi</div>';}
	if($customer_row["administration"] == "checked"){echo '<div>İnzibatçı və yaxın qohumları</div>';}
	if($customer_row["depart_boss"] == "checked"){echo '<div>Str. bölmə rəhbəri və yaxın qohumları</div>';}
	echo '<br><br>
	<div title="müştərinin biznes xarakteristikası">'.$customer_row["bus_type"].'</div>
	<div title="müştərinin profilini kim idarə edir">'.$customer_row["profile_controlling"].'</div>
	<div title="əməliyyatçının xüsusi qeydləri">'.$customer_row["personal_notes"].'</div>
	';}
	echo '
	<p>Müştərinin etdiyi seçimlər</p>
	<div title="müştərinin qeydiyyatdan keçdiyi vaxt">'.date_format(date_create($customer_row["reg_datetime"]),"d-m-Y H:i:s").'</div>
	<div title="müştərinin seçdiyi filial">'.$customer_row["branch_code"].'</div>
	<div title="müştəri aztəminatlıdırmı">'.$customer_row["minicapital"].'</div>
	<div title="müştərinin əlilliyi varmı">'.$customer_row["invalidity"].'</div>
	<div title="müştəri necə qeydiyyatdan keçib">'.$customer_row["debtor"].'</div>
	<div title="müştəri necə qeydiyyatdan keçib">'.$customer_row["guarantor"].'</div>
	<div title="müştəri necə qeydiyyatdan keçib">'.$customer_row["mortgagor"].'</div>
	<div title="müştərinin xüsusi qeydləri">'.$customer_row["customer_notes"].'</div>
	
	<p>İnzibatçı rəhbərə aid xanalar</p>';
	if(isset($customer_row["appointment_date"])){echo '<div title="rəhbərin əməliyyatçı təyin etdiyi tarix">'.date_format(date_create($customer_row["appointment_date"]),"d-m-Y H:i:s").'</div>';}
	if(isset($customer_row["boss_verifydate"])){echo '<div title="rəhbərin rəy tarixi">'.date_format(date_create($customer_row["boss_verifydate"]),"d-m-Y H:i:s").'</div>';}
	echo '<div title="rəhbərin qərarı">'.$customer_row["verified"].'</div>
	<div title="rəhbər">'.$customer_row["profile_verifier"].'</div>
	
	<p>Hesab nəzarətçisinə aid xanalar</p>';
	if(isset($customer_row["policeverify_date"])){echo '<div title="hesab nəzarətçisinin rəy tarixi">'.date_format(date_create($customer_row["policeverify_date"]),"d-m-Y H:i:s").'</div>';}
	echo '<div title="hesab nəzarətçisi">'.$customer_row["profile_police"].'</div>
	<div title="hesab nəzarətçisinin rəyi">'.$customer_row["police_verified"].'</div>
	<div title="hesab nəzarətçisinin qeydləri">'.$customer_row["police_notes"].'</div>';
	if($_SESSION['bank_department'] == "system"){ echo '
	<p>Sistem nəzarətçilərinə aid xanalar</p>
	<div title="müştəri profilinin statusu">'.$customer_row["status"].'</div>
	<div title="müştərinin təsdiq status kodu">'.$customer_row["statuscode"].'</div>
	<div title="müştərinin qeydiyyatdan keçdiyi IP ünvan">'.$customer_row["reg_ipaddr"].'</div>
	<div title="müştərinin qeydiyyatdan keçdiyi IP portu">'.$customer_row["reg_portaddr"].'</div>
	<div title="müştərinin qeydiyyatdan keçdiyi server">'.$customer_row["reg_hostname"].'</div>
	<div title="müştərinin qeydiyyatdan keçdiyi müəllif adı">'.$customer_row["reg_authuser"].'</div>';}

	echo '</div><br>

<div class="slideshow-container">';

$pics = mysqli_query($connect_link,"SELECT images FROM upload_img WHERE client_id='$id'"); 
if(mysqli_num_rows($pics) > 0){
	$pics_row = mysqli_fetch_assoc($pics);
	do{ echo '
	<div class="mySlides fade">
		<img src="./upload_images/'.$pics_row["images"].'" style="width:100%">
	</div>';}
	while($pics_row = mysqli_fetch_assoc($pics));}
echo '
<a class="prev" onclick="plusSlides(-1)">&#10094;</a>
<a class="next" onclick="plusSlides(1)">&#10095;</a>

</div>
<br>

<div style="text-align:center">
  <span class="dot" onclick="currentSlide(1)"></span> 
  <span class="dot" onclick="currentSlide(2)"></span> 
  <span class="dot" onclick="currentSlide(3)"></span> 
</div>';}
}
?>