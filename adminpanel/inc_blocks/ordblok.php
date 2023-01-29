<?php 
defined('mcsystem') or die('Cəhdin yaxşı idi, sərf etdiyin vaxtı başqa şeyə sərf et!');

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

if($_SESSION['order_view'] == "1" || $_SESSION['bank_department'] == "sales" || $_SESSION['bank_department'] == "assembler"){
$order_result = mysqli_query($connect_link,"SELECT * FROM cre_orders WHERE verifier_operation='icra' $forcredtitors $formanagers $forofficers $forverifiers ORDER BY operation_date ASC");
if(mysqli_num_rows($order_result)>0){
	$order_row = mysqli_fetch_assoc($order_result);
	
	echo '
<div id="midblock">
	<p>Kreditləşmiş sifarişlər</p>
	<div class="basliqxanalar" id="clientid">Müştəri ID</div>
	<div class="basliqxanalar" id="verifydate">Təsdiq</div>
	<div class="basliqxanalar" id="applydate">Qərar</div>
	<div class="basliqxanalar" id="verifiedorder">Məbləğ valyuta</div>
	<div class="basliqxanalar" id="clientype">Müştəri tipi</div>
	<div class="basliqxanalar" id="clientnsp">Müştərinin adı</div>
	<br>';	
	do{
	$client_result = mysqli_query($connect_link,"SELECT person_type, client FROM cstmr_data WHERE login='{$order_row["client"]}'");
	$client_row = mysqli_fetch_assoc($client_result);
		echo '
	<br>
	<div id="clientid" title="müştərinin FİN kodu və ya VÖENi"><a href="view_orders?id='.$order_row["id"].'">'.$order_row["client"].'</a></div>
	<div id="verifydate" title="sifarişin yekun təsdiqləndiyi tarix">'.date_format(date_create($order_row["ldecisiontime"]),"d-m-Y").'</div>
	<div id="applydate" title="inzibatçı rəhbərin qərar tarixi">'.date_format(date_create($order_row["operation_date"]),"d-m-Y").'</div>
	<div id="verifiedorder" title="təsdiq olunmuş kredit məbləği - valyutası">'.$order_row["man_verifiedamount"].' '.$order_row["man_verifiedcurrency"].'</div>
	<div id="clientype" title="müştəri tipi">'.$client_row["person_type"].'</div>
	<div id="clientnsp" title="müştərinin ASA və ya firmanın adı">'.$client_row["client"].'</div>
	<br>';
	}
	while($order_row = mysqli_fetch_assoc($order_result));
	echo '</div>';}
}