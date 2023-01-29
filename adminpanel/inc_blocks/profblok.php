<?php 
defined('mcsystem') or die('Cəhdin yaxşı idi, sərf etdiyin vaxtı başqa şeyə sərf et!');

if($_SESSION['users_role'] == 'officer'){
	$forofficers = "AND profile_officer='{$_SESSION['auth_admin_login']}'";
}

if($_SESSION['users_role'] == 'verifier'){
	$forverifiers = "AND branch_code='{$_SESSION['user_branch']}'";
}

if($_SESSION['customer_view'] == '1' || $_SESSION['bank_department'] == 'assembler'){
$customer_result = mysqli_query($connect_link,"SELECT * FROM cstmr_data WHERE verified='yes' $forofficers $forverifiers ORDER BY reg_datetime ASC");
if(mysqli_num_rows($customer_result)>0){
	$customer_row = mysqli_fetch_assoc($customer_result);
	echo '
<div id="midblock">
	<p>Təsdiqlənmiş profillər</p>
	<div class="basliqxanalar" id="clientid">Müştəri ID</div>
	<div class="basliqxanalar" id="applydate">Müraciət</div>
	<div class="basliqxanalar" id="verifydate">Təsdiq</div>
	<div class="basliqxanalar" id="applybranch">Filial kodu</div>
	<div class="basliqxanalar" id="clientype">Müştəri tipi</div>
	<div class="basliqxanalar" id="clientnsp">Müştərinin adı</div>
	<br>';	
	do{
		echo '
	<br>
	<div id="clientid" title="müştərinin FİN kodu və ya VÖENi"><a href="view_customer?id='.$customer_row["id"].'">'.$customer_row["login"].'</a></div>
	<div id="applydate" title="müştərinin müraciət tarixi">'.date_format(date_create($customer_row["reg_datetime"]),"d-m-Y").'</div>
	<div id="verifydate" title="inzibatçı-rəhbərin təsdiq tarixi">'.date_format(date_create($customer_row["boss_verifydate"]),"d-m-Y").'</div>
	<div id="applybranch" title="müştərinin aid olduğu filial">FILIAL - '.$customer_row["branch_code"].'</div>
	<div id="clientype" title="müştəri tipi">'.$customer_row["person_type"].'</div>
	<div id="clientnsp" title="müştərinin ASA və ya firmanın adı">'.$customer_row["client"].'</div>
	<br>';
	}
	while($customer_row = mysqli_fetch_assoc($customer_result));
	echo '
</div>';}
};