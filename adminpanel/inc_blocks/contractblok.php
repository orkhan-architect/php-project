<?php 
defined('mcsystem') or die('Cəhdin yaxşı idi, sərf etdiyin vaxtı başqa şeyə sərf et!');
?>
<div id="midblock">
<?php 
if($_SESSION['bank_department'] == 'system' || $_SESSION['users_role'] == 'user'){echo '
	<a href="addcontract"><p style="background-color: yellow; ">Müqavilə əlavə et</p></a>';

	$res_contracts = mysqli_query($connect_link,"SELECT * FROM contract_data ORDER BY id DESC");
	if(mysqli_num_rows($res_contracts)>0){
		$row_contracts = mysqli_fetch_assoc($res_contracts);
		echo '
	<p>Çap edilmiş müqavilələr</p>
	<div id="concatcred" class="basliqxanalar">Çap</div>
	<div id="applydate" class="basliqxanalar">Tarix</div>
	<div id="ofcerlogin" class="basliqxanalar">İstifadəçi</div>
	<div id="clientid" class="basliqxanalar">Müştəri ID</div>
	<div id="clientid" class="basliqxanalar">Kredit ID</div>
	<div id="clientid" class="basliqxanalar">Girov ID</div>
	<div id="clientid" class="basliqxanalar">Forma</div>
	<br>
	';
	do{ echo '
	<br>
	<div id="concatcred" title="çapın nömrəsi">Çap - '.$row_contracts["id"].'</div>
	<div id="applydate" title="müqavilənin çap edildiyi tarix">'.date_format(date_create($row_contracts["print_date"]),"d-m-Y").'</div>
	<div id="ofcerlogin" title="çap edən istifadəçi">'.$row_contracts["printed_user"].'</div>
	<div id="clientid" title="müştərinin ID-si">'.$row_contracts["client_id"].'</div>
	<div id="clientid" title="kreditin ID-si">'.$row_contracts["credit_id"].'</div>';
	if(isset($row_contracts["pledge_id"])){echo '
	<div id="clientid" title="girovun ID-si">'.$row_contracts["pledge_id"].'</div>
	<div id="clientid" title="girov qoyulma forması">'.$row_contracts["pledge_form"].'</div>
	';}
	echo '<br>';
	}
	while($row_contracts = mysqli_fetch_assoc($res_contracts));}
}
?>
</div>