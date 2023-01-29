<?php 
defined('mcsystem') or die('Cəhdin yaxşı idi, sərf etdiyin vaxtı başqa şeyə sərf et!');

if($_SESSION['users_role'] == 'verifier'){
	$branchforverifier = "AND branch_code='{$_SESSION['user_branch']}'";
	$forverifiers = "AND cho_verifier='{$_SESSION['auth_admin_login']}'";
	$forcredverif = "AND credit_verifier='{$_SESSION['auth_admin_login']}'";
	$forconcverif = "AND verifier='{$_SESSION['auth_admin_login']}'";
}

if($_SESSION['users_role'] == 'officer'){
	$ofcerexist = "AND profile_officer='{$_SESSION['auth_admin_login']}'";
	$forcredoffic = "AND credit_officer='{$_SESSION['auth_admin_login']}'";
	$forconcoffic = "AND officer='{$_SESSION['auth_admin_login']}'";
}

if($_SESSION['users_role'] == 'user'){
	$forcreditors = "AND cho_creditor='{$_SESSION['auth_admin_login']}'";
	$foragents = "AND agent='{$_SESSION['auth_admin_login']}'";
}

if($_SESSION['users_role'] == 'manager'){
	$formanagers = "AND cho_manager='{$_SESSION['auth_admin_login']}'";
	$formans = "AND manager='{$_SESSION['auth_admin_login']}'";
}

if($_SESSION['users_role'] == "verifier" || $_SESSION['bank_department'] == "audit" || $_SESSION['bank_department'] == "system"){
	$customer_result = mysqli_query($connect_link,"SELECT * FROM cstmr_data WHERE status='aktiv' $branchforverifier ORDER BY reg_datetime ASC");
	if(mysqli_num_rows($customer_result)>0){
		$customer_row = mysqli_fetch_assoc($customer_result);
		echo '
<div id="midblock">
	<p>İnzibat rəhbərinin təyinatını gözləyən profillər</p>
	<div class="basliqxanalar" id="clientid">Müştəri ID</div>
	<div class="basliqxanalar" id="applydate">Müraciət</div>
	<div class="basliqxanalar" id="applyform">Müraciət tipi</div>
	<div class="basliqxanalar" id="clientype">Müştəri tipi</div>
	<div class="basliqxanalar" id="clientnsp">Müştərinin adı</div>
	<br>';	
	do{ echo '
	<br>
	<div id="clientid" title="müştərinin FİN kodu və ya VÖENi">
		<a href="view_customer?id='.$customer_row["id"].'">'.$customer_row["login"].'</a>
	</div>
	<div id="applydate" title="müraciət tarixi">'.date_format(date_create($customer_row["reg_datetime"]),"d-m-Y").'</div>
	<div id="applyform" title="müraciət tipi">'.$customer_row["debtor"].' '.$customer_row["guarantor"].' '.$customer_row["mortgagor"].'</div>
	<div id="clientype" title="müştəri tipi">'.$customer_row["person_type"].'</div>
	<div id="clientnsp" title="müştərinin ASA və ya firmanın adı">'.$customer_row["client"].'</div>
	<br>';
	}
	while($customer_row = mysqli_fetch_assoc($customer_result));
	echo '
</div>';}
}

if($_SESSION['bank_department'] == "assembler" || $_SESSION['bank_department'] == "system" || $_SESSION['bank_department'] == "account_controllers" || $_SESSION['bank_department'] == "audit"){
	$check_result = mysqli_query($connect_link,"SELECT * FROM cstmr_data WHERE profile_officer IS NOT NULL AND status != 'deaktiv' AND verified IS NULL $branchforverifier $ofcerexist ORDER BY reg_datetime ASC");
	if(mysqli_num_rows($check_result)>0){
		$check_row = mysqli_fetch_assoc($check_result);
		echo '
<div id="midblock">
	<p>İnzibat şöbəsinin emalında olan profillər</p>
	<div class="basliqxanalar" id="clientid">Müştəri ID</div>
	<div class="basliqxanalar" id="applydate">Müraciət</div>
	<div class="basliqxanalar" id="clientnsp">Müştərinin adı</div>
	<div class="basliqxanalar" id="ofcerlogin">Əməliyyatçı</div>
	<div class="basliqxanalar" id="appointdate">Təyinat</div>
	<div class="basliqxanalar" id="checkdate">Baxıldı</div>
	<div class="basliqxanalar" id="ofverdate">Təsdiq</div>
	<br>';
		do{ echo '
	<br>
	<div id="clientid" title="müştərinin FİN kodu və ya VÖENi">
		<a href="view_customer?id='.$check_row["id"].'">'.$check_row["login"].'</a>
	</div>
	<div id="applydate" title="müraciət tarixi">'.date_format(date_create($check_row["reg_datetime"]),"d-m-Y").'</div>
	<div id="clientnsp" title="müştərinin ASA və ya firmanın adı">'.$check_row["client"].'</div>
	<div id="ofcerlogin" title="müştəriyə xidmət edən inzibatçı-əməliyyatçı">'.$check_row["profile_officer"].'</div>';
	if(isset($check_row["appointment_date"])){ echo '
	<div id="appointdate" title="inzibatçı rəhbərin əməliyyatçı təyinatı tarixi">'.date_format(date_create($check_row["appointment_date"]),"d-m-Y").'</div>';}
	if(isset($check_row["ofcer_checkdate"])){ echo '
	<div id="checkdate" title="inzibatçı-əməliyyatçının ilkin yoxlama tarixi">'.date_format(date_create($check_row["ofcer_checkdate"]),"d-m-Y").'</div>';}
	if(isset($check_row["ofcer_verifydate"])){ echo '
	<div id="ofverdate" title="inzibatçı-əməliyyatçının təsdiq tarixi">'.date_format(date_create($check_row["ofcer_verifydate"]),"d-m-Y").'</div>';}
		echo '<br>';
		}
		while($check_row = mysqli_fetch_assoc($check_result));
		echo '
</div>';}
}

if($_SESSION['bank_department'] == "sales" || $_SESSION['bank_department'] == "system" || $_SESSION['bank_department'] == "audit" || $_SESSION['users_role'] == "verifier"){
	$crorders_result = mysqli_query($connect_link,"SELECT * FROM cre_orders WHERE verifier_operation IS NULL AND order_status != 'imtina' $forcreditors $formanagers $forverifiers ORDER BY verify_datetime ASC");
	if(mysqli_num_rows($crorders_result)>0){
		$crorders_row = mysqli_fetch_assoc($crorders_result);
		echo '
<div id="midblock">
	<p>Satış şöbəsinin emalında olan kredit sifarişlər</p>
	<div class="basliqxanalar" id="clientid">Müştəri ID</div>
	<div class="basliqxanalar" id="applydate">Təsdiq</div>
	<div class="basliqxanalar" id="proname">Məhsul</div>
	<div class="basliqxanalar" id="credamount">Məbləğ</div>
	<div class="basliqxanalar" id="credcurre">Valyuta</div>
	<div class="basliqxanalar" id="applydate">Təklif</div>
	<div class="basliqxanalar" id="credamount">Məbləğ</div>
	<div class="basliqxanalar" id="credcurre">Valyuta</div>
	<div class="basliqxanalar" id="applydate">Qərar</div>
	<div class="basliqxanalar" id="credamount">Məbləğ</div>
	<div class="basliqxanalar" id="credcurre">Valyuta</div>
	<br>';	
	do{ echo '
	<br>
	<div id="clientid" title="müştərinin FİN kodu və ya VÖENi">
		<a href="view_orders?id='.$crorders_row["id"].'">'.$crorders_row["client"].'</a>
	</div>
	<div id="applydate" title="müraciətin təsdiq tarixi">'.date_format(date_create($crorders_row["verify_datetime"]),"d-m-Y").'</div>
	<div id="proname" title="kredit məhsulunun adı">'.$crorders_row["product_name"].'</div>
	<div id="credamount" title="sifariş edilmiş kredit məbləği">'.$crorders_row["cre_amount"].'</div>
	<div id="credcurre" title="sifariş edilmiş kreditin valyutası">'.$crorders_row["cre_currency"].'</div>';
	if(isset($crorders_row["creditor_decisiontime"])){ echo'
	<div id="applydate" title="agentin təklifi tarixi">'.date_format(date_create($crorders_row["creditor_decisiontime"]),"d-m-Y").'</div>
	<div id="credamount" title="təklif edilmiş kredit məbləği">'.$crorders_row["creditor_aplyamount"].'</div>
	<div id="credcurre" title="təklif edilmiş kreditin valyutası">'.$crorders_row["creditor_aplycurrency"].'</div>';}
	if(isset($crorders_row["man_checktime"])){ echo'
	<div id="applydate" title="menecerin qərar tarixi">'.date_format(date_create($crorders_row["man_checktime"]),"d-m-Y").'</div>
	<div id="credamount" title="menecerin təklif etdiyi kredit məbləği">'.$crorders_row["man_verifiedamount"].'</div>
	<div id="credcurre" title="menecerin təklif etdiyi kreditin valyutası">'.$crorders_row["man_verifiedcurrency"].'</div>';}
	echo '<br>';
	}
	while($crorders_row = mysqli_fetch_assoc($crorders_result));
	echo '
</div>';}
}

if($_SESSION['bank_department'] == "sales" || $_SESSION['bank_department'] == "system" || $_SESSION['bank_department'] == "audit"){
	$credit_result = mysqli_query($connect_link,"SELECT * FROM cre_data WHERE verified IS NULL $forcredverif $forcredoffic ORDER BY ofcer_docdate ASC");
	if(mysqli_num_rows($credit_result)>0){
		$credit_row = mysqli_fetch_assoc($credit_result);
		echo '
<div id="midblock">
	<p>Satış şöbəsinin emalında olan kreditlər</p>
	<div class="basliqxanalar" id="clientid">Müştəri ID</div>
	<div class="basliqxanalar" id="credit_mains">Kredit</div>
	<div class="basliqxanalar" id="credit_percentage">Faiz</div>
	<div class="basliqxanalar" id="credit_period">Müddət</div>
	<div class="basliqxanalar" id="applydate">Başlama</div>
	<div class="basliqxanalar" id="verifydate">Bitmə</div>
	<div class="basliqxanalar" id="credit_production">Kredit məhsulu</div>
	<div class="basliqxanalar" id="applydate">Yığılma</div>
	<br>';
	do{ echo '
	<br>
	<div id="clientid" title="müştərinin FİN kodu və ya VÖENi"><a href="view_credit?id='.$credit_row["id"].'">'.$credit_row["client"].'</a></div>
	<div id="credit_mains" title="rəsmiləşmiş kredit">'.$credit_row["credit_amount"].' '.$credit_row["credit_currency"].'</div>
	<div id="credit_percentage" title="illik faiz dərəcəsi">'.$credit_row["credit_percentage"].' %</div>
	<div id="credit_period" title="ilkin təyin edilmiş müddət">'.$credit_row["credit_period"].' ay</div>
	<div id="applydate" title="kreditin qüvvəyə mindiyi tarix">'.date_format(date_create($credit_row["credit_startdate"]),"d-m-Y").'</div>
	<div id="verifydate" title="kreditin plan üzrə bitmə tarixi">'.date_format(date_create($credit_row["credit_enddate"]),"d-m-Y").'</div>
	<div id="credit_production" title="verilmiş kredit məhsulu">'.$credit_row["credit_product"].'</div> ';
	if(isset($credit_row["ofcer_docdate"])){echo '<div id="applydate" title="əməliyyatçının sistemə yığdığı tarix">'.date_format(date_create($credit_row["ofcer_docdate"]),"d-m-Y").'</div>';}
	echo '<br>';
	}
	while($credit_row = mysqli_fetch_assoc($credit_result));
echo '</div>';}
}

if($_SESSION['bank_department'] == "sales" || $_SESSION['bank_department'] == "system" || $_SESSION['bank_department'] == "audit"){
$res_pledge = mysqli_query($connect_link,"SELECT * FROM pledge_data WHERE manager_decision='emal edilməkdədir' $foragents $formans ORDER BY agent_chdate DESC");
if(mysqli_num_rows($res_pledge)>0){
	$row_pledge = mysqli_fetch_assoc($res_pledge);	
	echo '
<div id="midblock">
	<p>Satış şöbəsinin emalında olan girovlar</p>
	<div id="typledge" class="basliqxanalar">Girovun növü</div>
	<div id="personalid" class="basliqxanalar">Girovqoyan ID</div>
	<div id="clientnsp" class="basliqxanalar">Girovqoyan</div>
	<div id="pledamount" class="basliqxanalar">Məbləği</div>
	<div id="pledcurrency" class="basliqxanalar">Val</div>
	<div id="applydate" class="basliqxanalar">Yığılma</div>
	<br>
	';
	do{ echo '
	<br>
	<div id="typledge" title="girovun növü"><a href="view_pledge?id='.$row_pledge["id"].'">'.$row_pledge["pledge_name"].'</a></div>
	<div id="personalid" title="FİNKOD (VÖEN)">'.$row_pledge["fincode_taxes"].'</div>
	<div id="clientnsp" title="Girovqoyan ASA (Şirkətin adı)">'.$row_pledge["mortgagor"].'</div>
	<div id="pledamount" title="giorvun məbləği">'.$row_pledge["pledge_cost"].'</div>
	<div id="pledcurrency" title="girovun valyutası">'.$row_pledge["pledge_currency"].'</div> ';
	if(isset($row_pledge["agent_chdate"])){echo '<div id="applydate" title="yığılma tarixi">'.date_format(date_create($row_pledge["agent_chdate"]),"d-m-Y").'</div>';}
	echo '<br>';
	}
	while($row_pledge = mysqli_fetch_assoc($res_pledge));
echo '</div>';}
}

if($_SESSION['bank_department'] == "assembler" || $_SESSION['bank_department'] == "system" || $_SESSION['bank_department'] == "audit"){
	$res_concat = mysqli_query($connect_link,"SELECT * FROM pledge_concat WHERE verified IS NULL $forconcverif $forconcoffic ORDER BY enter_date DESC");
	if(mysqli_num_rows($res_concat)>0){
	$row_concat = mysqli_fetch_assoc($res_concat);
	echo '
<div id="midblock">
	<p>İnzibat şöbəsinin emalında olan kredit-girov birləşmələri</p>
	<div id="concatcred" class="basliqxanalar">Birləşmə ID-si</div>
	<div id="applydate" class="basliqxanalar">Birləşdi</div>
	<div id="concatcont" class="basliqxanalar">Müqavilə</div>
	<div id="applydate" class="basliqxanalar">Yığılma</div>
	<br>
	';
	do{ echo '
	<br>
	<div id="concatcred" title="birləşmə"><a href="view_concat?id='.$row_concat["id"].'">Birləşmə - '.$row_concat["id"].'</a></div>
	<div id="applydate" title="rəsmiləşmə tarixi">'.date_format(date_create($row_concat["start_date"]),"d-m-Y").'</div>
	<div id="concatcont" title="girovun müqaviləsi">'.$row_concat["contract_type"].'</div> ';
	if(isset($row_concat["enter_date"])){echo '<div id="applydate" title="bərkidilmə tarixi">'.date_format(date_create($row_concat["enter_date"]),"d-m-Y").'</div>';}
	echo '<br>';
	}
	while($row_concat = mysqli_fetch_assoc($res_concat));
echo '</div>';}
}

if($_SESSION['bank_department'] == 'sales' || $_SESSION['bank_department'] == 'assembler' || $_SESSION['bank_department'] == "system" || $_SESSION['bank_department'] == "audit"){
	
	if($_SESSION['users_role'] == 'user' || $_SESSION['users_role'] == 'officer'){
	$forspecusers = "AND bank='{$_SESSION["auth_admin_login"]}'";
	}
	if($_SESSION['users_role'] == 'verifier' || $_SESSION['users_role'] == 'manager'){
	$forspecboss = "AND verifingbos='{$_SESSION["auth_admin_login"]}'";
	}
	
	$res_notifs = mysqli_query($connect_link,"SELECT * FROM notification_data WHERE verified IS NULL $forspecusers $forspecboss");
	if(mysqli_num_rows($res_notifs)>0){
	$row_notifs = mysqli_fetch_assoc($res_notifs);
	echo '
<div id="midblock">
	<p>Təsdiqdə olan bildirişlər</p>
	<div id="concatcred" class="basliqxanalar">Bildiriş</div>
	<div id="clientid" class="basliqxanalar">Müştəri ID</div>
	<div id="clientid" class="basliqxanalar">Qeyd</div>
	<div id="ofcerlogin" class="basliqxanalar">İstifadəçi</div>
	<div id="applydate" class="basliqxanalar">Daxiloma</div>
	<br>';
	do{ echo '
	<br>
	<div id="concatcred" title="bildirişin nömrəsi"><a href="view_notifs?id='.$row_notifs["id"].'">Bildiriş - '.$row_notifs["id"].'</a></div>
	<div id="clientid" title="müştərinin FİN kodu və ya VÖEN">'.$row_notifs["client"].'</div>
	<div id="clientid" title="qeydin tipi">'.$row_notifs["note_type"].'</div>
	<div id="ofcerlogin" title="əlavə edən istifadəçi">'.$row_notifs["bank"].'</div> ';
	if(isset($row_notifs["note_date"])){echo '<div id="applydate" title="bildirişin daxil edildiyi tarix">'.date_format(date_create($row_notifs["note_date"]),"d-m-Y").'</div>';}
	echo '<br>';
	}
	while($row_notifs = mysqli_fetch_assoc($res_notifs));
echo '</div>';}
}
?>