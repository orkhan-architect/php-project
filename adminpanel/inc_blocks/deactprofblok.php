<?php 
defined('mcsystem') or die('Cəhdin yaxşı idi, sərf etdiyin vaxtı başqa şeyə sərf et!');

$rejected_result = mysqli_query($connect_link,"SELECT * FROM cstmr_data WHERE status='deaktiv' ORDER BY reg_datetime ASC");
if(mysqli_num_rows($rejected_result)>0){
	$rejected_row = mysqli_fetch_assoc($rejected_result);
	echo '
<div id="midblock">
	<p>DEAKTİV edilmiş profillər</p>
	<div class="basliqxanalar" id="clientid">Müştəri ID</div>
	<div class="basliqxanalar" id="applydate">Müraciət</div>
	<div class="basliqxanalar" id="applyform">Müraciət tipi</div>
	<div class="basliqxanalar" id="clientype">Müştəri tipi</div>
	<div class="basliqxanalar" id="clientnsp">Müştərinin adı</div>
	<br>';	
	do{
		echo '
	<br>
	<div id="clientid" title="müştərinin FİN kodu və ya VÖENi"><a href="view_customer?id='.$rejected_row["id"].'">'.$rejected_row["login"].'</a></div>
	<div id="applydate" title="müraciət tarixi">'.date_format(date_create($rejected_row["reg_datetime"]),"d-m-Y").'</div>
	<div id="applyform" title="müraciət tipi">'.$rejected_row["debtor"].' '.$rejected_row["guarantor"].' '.$rejected_row["mortgagor"].'</div>
	<div id="clientype" title="müştəri tipi">'.$rejected_row["person_type"].'</div>
	<div id="clientnsp" title="müştərinin ASA və ya firmanın adı">'.$rejected_row["client"].'</div>
	<br>';
	}
	while($rejected_row = mysqli_fetch_assoc($rejected_result));
	echo '
</div>';
}
?>