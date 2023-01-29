<?php 
defined('mcsystem') or die('Cəhdin yaxşı idi, sərf etdiyin vaxtı başqa şeyə sərf et!');

$order_result = mysqli_query($connect_link,"SELECT * FROM cre_orders WHERE order_status='imtina' OR verifier_operation='ləğv' ORDER BY ldecisiontime ASC");
if(mysqli_num_rows($order_result)>0){
	$order_row = mysqli_fetch_assoc($order_result);
	
	$client_result = mysqli_query($connect_link,"SELECT person_type, client FROM cstmr_data WHERE login='{$order_row["client"]}'");
	$client_row = mysqli_fetch_assoc($client_result);
	echo '
<div id="midblock">
	<p>İmtina və ya ləğv edilmiş kredit sifarişlər</p>
	<div class="basliqxanalar" id="clientid">Müştəri ID</div>
	<div class="basliqxanalar" id="verifydate">İmtina</div>
	<div class="basliqxanalar" id="verifiedorder">Məbləğ valyuta</div>
	<div class="basliqxanalar" id="clientype">Müştəri tipi</div>
	<div class="basliqxanalar" id="clientnsp">Müştərinin adı</div>
	<div class="basliqxanalar" id="applydate">Ləğv</div>
	<br>';	
	do{ echo '
	<br>
	<div id="clientid" title="müştərinin FİN kodu və ya VÖENi"><a href="view_orders?id='.$order_row["id"].'">'.$order_row["client"].'</a></div>
	<div id="verifydate" title="sifarişin yekun imtina olunduğu tarix">'.date_format(date_create($order_row["ldecisiontime"]),"d-m-Y").'</div>
	<div id="verifiedorder" title="imtina olunmuş kredit məbləği - valyutası">'.$order_row["cre_amount"].' '.$order_row["cre_currency"].'</div>
	<div id="clientype" title="müştəri tipi">'.$client_row["person_type"].'</div>
	<div id="clientnsp" title="müştərinin ASA və ya firmanın adı">'.$client_row["client"].'</div>';
	if(isset($order_row["operation_date"])){ echo '
	<div id="applydate" title="kredit sifarişin ləğv edildiyi tarix">'.date_format(date_create($order_row["operation_date"]),"d-m-Y").'</div>';}
	echo '<br>';
	}
	while($order_row = mysqli_fetch_assoc($order_result));
echo '</div>';
}