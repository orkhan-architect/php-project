<?php 
defined('mcsystem') or die('Cəhdin yaxşı idi, sərf etdiyin vaxtı başqa şeyə sərf et!');
?>
<div id="midblock">
<?php 
if($_SESSION['users_role'] == 'officer' || $_SESSION['bank_department'] == "system"){echo '<a href="pledgcon"><p style="background-color: yellow; ">Girov birləşdir</p></a>';}
	
$res_concat = mysqli_query($connect_link,"SELECT * FROM pledge_concat WHERE verify_date IS NOT NULL ORDER BY id DESC");
if(mysqli_num_rows($res_concat)>0){
	$row_concat = mysqli_fetch_assoc($res_concat);
	echo '
	<p>Mövcud birləşmələr</p>
	<div id="concatcred" class="basliqxanalar">Birləşmə ID-si</div>
	<div id="concatcont" class="basliqxanalar">Müqavilə</div>
	<div id="applydate" class="basliqxanalar">Yığılma</div>
	<div id="applydate" class="basliqxanalar">Təsdiq</div>
	<div id="applydate" class="basliqxanalar">Daxiloma</div>
	<div id="applydate" class="basliqxanalar">Azadolma</div>
	<br>
	';
	do{ echo '
	<br>
	<div id="concatcred" title="birləşmə"><a href="view_concat?id='.$row_concat["id"].'">Birləşmə - '.$row_concat["id"].'</a></div>
	<div id="concatcont" title="girovun müqaviləsi">'.$row_concat["contract_type"].'</div>
	<div id="applydate" title="bərkidilmə tarixi">'.date_format(date_create($row_concat["enter_date"]),"d-m-Y").'</div>
	<div id="applydate" title="təsdiqləmə tarixi">'.date_format(date_create($row_concat["verify_date"]),"d-m-Y").'</div>
	<div id="applydate" title="rəsmiləşmə tarixi">'.date_format(date_create($row_concat["start_date"]),"d-m-Y").'</div>';
	if(!isset($row_concat["end_date"]) || $row_concat["end_date"] == ''){echo '';}
	else{ echo '
	<div id="applydate" title="azadolma tarixi">'.date_format(date_create($row_concat["end_date"]),"d-m-Y").'</div>';}
	echo '<br>';
	}
	while($row_concat = mysqli_fetch_assoc($res_concat));}
?>
</div>