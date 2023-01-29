<?php 
defined('mcsystem') or die('Cəhdin yaxşı idi, sərf etdiyin vaxtı başqa şeyə sərf et!');

if($_SESSION['msg']){
		echo $_SESSION['msg'];
		unset($_SESSION['msg']);
}

if($_SESSION['users_role'] == 'user'){
	$forcredtitors = "AND cho_creditor='{$_SESSION['auth_admin_login']}'";
}

if($_SESSION['users_role'] == 'manager'){
	$formanagers = "AND cho_manager='{$_SESSION['auth_admin_login']}'";
}

if($_SESSION['users_role'] == 'officer'){
	$forofficers = "AND cho_officer='{$_SESSION['auth_admin_login']}'";
}

if($_SESSION['users_role'] == 'verifier'){
	$forverifiers = "AND cho_verifier='{$_SESSION['auth_admin_login']}'";
}

$order_result = mysqli_query($connect_link,"SELECT * FROM cre_orders WHERE id='$id' $forcredtitors $formanagers $forofficers $forverifiers");
if(mysqli_num_rows($order_result)>0){
	$order_row = mysqli_fetch_assoc($order_result);
	
	$custom_result = mysqli_query($connect_link,"SELECT id, person_type FROM cstmr_data WHERE login='{$order_row["client"]}'");
	$custom_row = mysqli_fetch_assoc($custom_result);
		
if($_SESSION['order_edit'] == '1'){echo '
<div id="midblock">
	<form method="post" enctype="multipart/form-data">';

if($_SESSION['users_role'] == 'admin'){ echo '
	<p>Şəkil əlavə etmə funksiyası</p>
	<input type="file" name="upload[]" id="upload" multiple>
	<input type="submit" name="filesubmit" id="form_submit" value="Yüklə">';}

if($_SESSION['auth_admin_login'] == $order_row["cho_creditor"] || $_SESSION['bank_department'] == "system"){
	if(isset($order_row["man_checktime"]) && !isset($order_row["ldecisiontime"])){ echo '
	<p>Satış mütəxəssisinin idarəçiliyi</p>
		<input type="submit" name="finish_submit" id="form_submit" value="Rəy bildir" style="margin-left: 2px;">
		<select name="orderstat_select" id="statusel">
			<option value="" selected disabled>sifarişin statusunu seçin</option>
			<option value="imtina">imtina</option>
			<option value="təsdiq">təsdiq</option>
		</select>
		<textarea name="finishnotes" title="yekun qərar qeydi"></textarea>';
	}
	if(!isset($order_row["creditor_decisiontime"])){ echo '
	<p>Satış mütəxəssisinin idarəçiliyi</p>
		<input type="submit" name="saving_submit" id="form_submit" value="Yaddaşa ver" style="margin-left: 2px;">
		<select name="userstat_select" id="statusel">
			<option value="" selected disabled>rəyinizi bildirin</option>
			<option value="imtina">imtina</option>
			<option value="təsdiq">təsdiq</option>
		</select>
		<input type="number" id="offerd_period" name="offer_period" title="agentin təklif etdiyi müddət (aylarla)">
		<input type="number" id="offerd_amount" name="offer_amount" title="agentin təklif etdiyi məbləğ">
		<select name="offer_currency" id="statusel">
			<option value="" selected disabled>kreditin valyutası</option>
			<option value="AZN">manat</option>
			<option value="USD">ABŞ dolları</option>
			<option value="EUR">avro</option>
		</select>
		<textarea name="usernotes" title="satış agentin qeydi"></textarea><br>';}
	if($order_row["ple_type"] == "zaminlik" && !isset($order_row["creditor_guarquery"])){echo'
		<p>Zaminə sorğu</p>
		<input type="submit" name="guarant_submit" id="form_submit" value="Zaminə sorğu" style="margin-left: 2px;">
		<input autocomplete="off" type="text" id="guarantquery" name="guaquery" title="zaminin FIN id və ya VÖEN nömrəsi yazılmalı" value="'.$order_row["creditor_guarquery"].'" style="margin-left: 2px;">';}
}
	
if($_SESSION['auth_admin_login'] == $order_row["cho_manager"] || $_SESSION['bank_department'] == "system"){
	if(!isset($order_row["man_checktime"])){ echo'
	<p>Satış menecerinin idarəçiliyi</p>
		<input type="submit" name="confirming_submit" id="form_submit" value="Qərar ver" style="margin-left: 2px;">	
		<select name="manstat_select" id="statusel">
			<option value="" selected disabled>rəyinizi bildirin</option>
			<option value="imtina">imtina</option>
			<option value="təsdiq">təsdiq</option>
		</select>
		<input type="number" id="offerd_period" name="mandec_period" title="agentin təklif etdiyi müddət (aylarla)">
		<input type="number" id="offerd_amount" name="mandec_amount" title="agentin təklif etdiyi məbləğ">
		<select name="mandec_currency" id="statusel">
			<option value="" selected disabled>kreditin valyutası</option>
			<option value="AZN">manat</option>
			<option value="USD">ABŞ dolları</option>
			<option value="EUR">avro</option>
		</select>
		<textarea name="managernotes" title="satış menecerinin qeydi"></textarea><br>';}
}

if($_SESSION['auth_admin_login'] == $order_row["cho_verifier"] || $_SESSION['bank_department'] == "system"){
	if(!isset($order_row["operation_date"])){ echo'
	<p>Hesab təsdiqləyicisinin idarəçiliyi</p>
		<input type="submit" name="operating_submit" id="form_submit" value="İcra/Ləğv et" style="margin-left: 2px;">
		<select name="verstat_select" id="statusel">
			<option value="" selected disabled>rəyinizi bildirin</option>
			<option value="icra">icra</option>
			<option value="ləğv">ləğv</option>
		</select>
		<textarea name="verifnotes" title="təsdiqləyicinin qeydi"></textarea><br>';}
}

echo '</form>
</div>';}
		
	if($_SESSION['order_view'] == "1" || $_SESSION['auth_admin_login'] == $order_row["cho_creditor"] || $_SESSION['auth_admin_login'] == $order_row["cho_manager"] || $_SESSION['auth_admin_login'] == $order_row["cho_officer"] || $_SESSION['auth_admin_login'] == $order_row["cho_verifier"]){ echo '
<div id="midblock">';

	if(isset($order_row["operation_date"])){echo '
	<p>İnzibatçı-rəhbərin qeydi</p>
	<div title="seçilmiş inzibatçı rəhbər">'.$order_row["cho_verifier"].'</div>
	<div title="qərarı">'.$order_row["verifier_operation"].'</div>';
	if(isset($order_row["operation_date"])){echo '
	<div title="qərar tarixi">'.date_format(date_create($order_row["operation_date"]),"d-m-Y H:i:s").'</div>';}
	echo '<div title="qeydləri">'.$order_row["verifier_notes"].'</div>';}
	
	if(isset($order_row["creditor_decisiontime"])){echo '
	<p>Satış agentinə aid xanalar</p>
	<div title="seçilmiş satış mütəxəssisi">'.$order_row["cho_creditor"].'</div>';
	if(isset($order_row["creditor_decisiontime"])){echo '
	<div title="qərar tarixi">'.date_format(date_create($order_row["creditor_decisiontime"]),"d-m-Y H:i:s").'</div>';}
	echo '<div title="qərarı">'.$order_row["creditor_decision"].'</div>
	<div title="təklif etdiyi məbləği valyutası">'.$order_row["creditor_aplyamount"].' '.$order_row["creditor_aplycurrency"].'</div>
	<div title="təklif etdiyi müddət">'.$order_row["creditor_aplyperiod"].' ay</div>
	<div title="qeydləri">'.$order_row["creditor_note"].'</div>';}
	
	if(isset($order_row["man_checktime"])){echo '
	<p>Satış menecerinə aid xanalar</p>
	<div title="seçilmiş satış meneceri">'.$order_row["cho_manager"].'</div>';
	if(isset($order_row["man_checktime"])){echo '
	<div title="qərar tarixi">'.date_format(date_create($order_row["man_checktime"]),"d-m-Y H:i:s").'</div>';}
	echo '<div title="qərarı">'.$order_row["man_decision"].'</div>
	<div title="təklif etdiyi məbləği valyutası">'.$order_row["man_verifiedamount"].' '.$order_row["man_verifiedcurrency"].'</div>
	<div title="təklif etdiyi müddət">'.$order_row["man_verifiedperiod"].' ay</div>
	<div title="qeydləri">'.$order_row["man_note"].'</div>';}
	
	if(isset($order_row["ldecisiontime"])){echo '
	<p>YEKUN QƏRAR barədə</p>
	<div title="sifarişin statusu">'.$order_row["order_status"].'</div>';
	if(isset($order_row["ldecisiontime"])){echo '
	<div title="yekun qərar tarixi">'.date_format(date_create($order_row["ldecisiontime"]),"d-m-Y H:i:s").'</div>';}
	echo '<div title="yekun qeydlər">'.$order_row["ldecisionote"].'</div>';}

	echo '<p>Müştəri haqqında qısa məlumat</p>
	<div title="müştəri İD (təfsilatı ssılkada)" style="background-color: yellow;"><a target="_blank" href="view_customer?id='.$custom_row["id"].'">'.$order_row["client"].'</a></div>
	<div title="müştərinin son iş yerindəki stajı"><span style="font-weight: bold;">Staj</span> - '.$order_row["j_experience"].' ay</div>
	<div title="müştərinin orta aylıq gəliri"><span style="font-weight: bold;">Aylıq gəlir</span> - '.$order_row["aver_profit"].'</div>
	<div title="müştəri Bankı tapdı"><span style="font-weight: bold;">Vasitəçi</span> - '.$order_row["recommended"].'</div>
	<div title="müştərinin yükləyəcəyi əsas maliyyə sənədi">'.$order_row["send_findoc"].'</div>
	<div title="müştərinin yükləyəcəyi digər maliyyə sənədi">'.$order_row["send_finothdoc"].'</div>
	<div title="müştərinin kredit sifarişə müraciət tarixi">'.date_format(date_create($order_row["app_datetime"]),"d-m-Y H:i:s").'</div><br>';
	
	if($custom_row["person_type"] == 'Fiziki şəxs / Fərdi sahibkar'){ echo'
	<p>Müştərinin ailə gəliri və idarəçiliyi</p>
	<div title="ailə vəziyyəti"><span style="font-weight: bold;">Ailə vəziyyəti</span>- '.$order_row["fam_status"].'</div>
	<div title="ailə üzvü sayı"><span style="font-weight: bold;">Üzvlər</span>- '.$order_row["fam_members"].' nəf</div>
	<div title="ailədə işləyən sayı"><span style="font-weight: bold;">İşləyənlər</span>- '.$order_row["fam_workers"].' nəf</div>
	<div title="ailənin orta aylıq gəliri"><span style="font-weight: bold;">Gəliri</span>- '.$order_row["oth_profit"].' AZN</div>
	<div title="ailənin orta aylıq xərci"><span style="font-weight: bold;">Xərci</span>- '.$order_row["oth_expense"].' AZN</div>
	<div title="hazırki iş yeri">'.$order_row["last_job"].'</div>
	<div title="İş arayışının alınmasına müştərinin rəyi">'.$order_row["agrjob"].'</div>';}
	
	echo '
	<p>Müştərinin kredit sifarişi</p>
	<div title="müştərinin sifarişi təsdiq tarixi"> '.date_format(date_create($order_row["verify_datetime"]),"d-m-Y H:i:s").' </div>
	<div title="müştərinin sifarişə rəyi">'.$order_row["client_decision"].'</div>
	<div title="kredit məhsulu">'.$order_row["product_name"].'</div>
	<div title="sifariş edilən kredit məbləği və valyutası">'.$order_row["cre_amount"].' '.$order_row["cre_currency"].'</div>
	<div title="sifariş edilən qüvvədəolma müddəti"><span style="font-weight: bold;">Müddət</span>- '.$order_row["cre_period"].' ay</div>
	<div title="kreditin istifadə məqsədi"><span style="font-weight: bold;">Məqsəd</span>- '.$order_row["cre_aim"].'</div>
	<div title="AKB razılığına müştərinin rəyi">'.$order_row["agracb"].'</div>';
	if($order_row["cre_concession"] != ''){echo '<div title="güzəşt istəyi"><span style="font-weight: bold;">Güzəşt</span>- '.$order_row["cre_concession"].'</div>';}
	else{echo '<div title="güzəşt istəyi"><span style="font-weight: bold;">Güzəşt</span>-istənilmir</div>';}
	
	if(isset($order_row["ple_type"])){ echo '
	<p>Müştərinin təklif etdiyi girov barədə</p>
	<div title="girovun tipi">'.$order_row["ple_type"].'</div>
	<div title="təklif edilən girov məbləği və valyutası">'.$order_row["ple_value"].' '.$order_row["ple_currency"].'</div>
	<div title="girovun xarakteristikası"><span style="font-weight: bold;">Təfsilatı</span>- '.$order_row["ple_information"].'</div>';}
	
	if($order_row["client_decision"] == "imtina"){ echo '
	<p>Müştərinin imtina qərarı</p>
	<div title="müştərinin imtina tarixi">'.date_format(date_create($order_row["reject_datetime"]),"d-m-Y H:i:s").'</div>
	<div title="imtinanın səbəbi"><span style="font-weight: bold;">Səbəb</span>- '.$order_row["reject_reason"].'</div>';}
	
	if($order_row["ple_type"] == 'zaminlik'){
	$guarid_result = mysqli_query($connect_link,"SELECT id FROM cstmr_data WHERE login='{$order_row["creditor_guarquery"]}'");
	$guarid_row = mysqli_fetch_assoc($guarid_result);
	echo '
	<p>Zaminə aid xanalar</p>
	<div title="zaminin ID-i" style="background-color: yellow;"><a target="_blank" href="view_customer?id='.$guarid_row["id"].'">'.$order_row["creditor_guarquery"].'</a></div>
	<div title="zaminin qərarı">'.$order_row["guarant_agree"].'</div>';
	if(isset($order_row["toguarant"])){echo '
	<div title="zaminə satış mütəxəssisinin müraciət tarixi">'.date_format(date_create($order_row["toguarant"]),"d-m-Y H:i:s").'</div>';}
	if(isset($order_row["fromguarant"])){echo '
	<div title="zaminin satış mütəxəssisinə cavab tarixi">'.date_format(date_create($order_row["fromguarant"]),"d-m-Y H:i:s").'</div>';}
	}
	
	if($_SESSION['bank_department'] == 'system'){ echo '
	<p>Sistem nəzarətçiləri üçün xanalar</p>
	<div title="müştərinin qeydiyyat İP-si">'.$order_row["app_ipaddress"].'</div>
	<div title="zaminin qeydiyyat İP-si">'.$order_row["guaripadr"].'</div>
	<div title="hesabı açmış əməliyyatçı">'.$order_row["cho_officer"].'</div>';}
echo '</div><br><br>';

echo '<div class="slideshow-container">';

$pics = mysqli_query($connect_link,"SELECT order_images FROM upload_ord WHERE order_id='$id'"); 
if(mysqli_num_rows($pics) > 0){
	$pics_row = mysqli_fetch_assoc($pics);
	do{ echo '
	<div class="mySlides fade">
		<img src="./upload_orders/'.$pics_row["order_images"].'" style="width:100%">
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