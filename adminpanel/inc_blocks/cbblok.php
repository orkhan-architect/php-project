<?php defined('mcsystem') or die('Cəhdin yaxşı idi, sərf etdiyin vaxtı başqa şeyə sərf et!'); 

echo '
<div id="midblock">';
if($_SESSION['users_role'] == 'admin'){echo '
	<p>Kredit bazanı yüklə</p>';
	echo $message;
	echo '
	<form id="import_excel_form" method="post" enctype="multipart/form-data">
		<p id="message"></p>
		<input id="leftmarg" type="file" name="import_excel">
		<input type="submit" name="import" id="import" value="Yüklə">
	</form>';}
if($_SESSION['bank_department'] == "system"){echo '
	<p>Kredit bazanı ixrac et</p>
	<form method="post" action="export.php">	
		<select name="file_type" id="leftmarg">
    		<option value="Xlsx">Xlsx</option>
            <option value="Xls">Xls</option>
            <option value="Csv">Csv</option>
        </select>
		<input id="form_submit" type="submit" name="export" value="İxrac et">
	</form>';}
	echo '<p>AXTARIŞ sistemi</p>
	<form method="GET" action="searchcre.php?q=">
		<input type="text" autocomplete="off" id="input_search" name="q" placeholder="3-25 simvol arası">
		<select name="search_place">
			<option value="" selected disabled>kriteriya seç</option>
			<option value="unical_credid">unikal ID</option>
			<option value="client">müştəri ID</option>
			<option value="credit_product">məhsul</option>
		</select>
        <input type="submit" id="form_submit" value="Axtar">
	</form>';


if($_SESSION['users_role'] == 'user' || $_SESSION['bank_department'] == "system"){echo '<a href="addcredit"><p style="background-color: yellow; ">Kredit əlavə et</p></a>';}
	
$credit_result = mysqli_query($connect_link,"SELECT * FROM cre_data WHERE verified='yes' AND credit_status='aktiv' ORDER BY credit_startdate DESC");
if(mysqli_num_rows($credit_result)>0){
	$credit_row = mysqli_fetch_assoc($credit_result);
	echo '
	<p>Aktiv kreditlər</p>
	<div class="basliqxanalar" id="clientid">Müştəri ID</div>
	<div class="basliqxanalar" id="applydate">Yığılma</div>
	<div class="basliqxanalar" id="verifydate">Təsdiq</div>
	<div class="basliqxanalar" id="credit_mains">Kredit</div>
	<div class="basliqxanalar" id="credit_percentage">Faiz</div>
	<div class="basliqxanalar" id="credit_period">Müddət</div>
	<div class="basliqxanalar" id="applydate">Başlama</div>
	<div class="basliqxanalar" id="verifydate">Bitmə</div>
	<div class="basliqxanalar" id="credit_production">Kredit məhsulu</div>
	<br>';	
	do{	echo '
	<br>
	<div id="clientid" title="müştərinin FİN kodu və ya VÖENi"><a href="view_credit?id='.$credit_row["id"].'">'.$credit_row["client"].'</a></div>
	<div id="applydate" title="əməliyyatçının sistemə yığdığı tarix">'.date_format(date_create($credit_row["ofcer_docdate"]),"d-m-Y").'</div>
	<div id="verifydate" title="inzibatçı-rəhbərin təsdiq tarixi">'.date_format(date_create($credit_row["verif_docdate"]),"d-m-Y").'</div>
	<div id="credit_mains" title="rəsmiləşmiş kredit">'.$credit_row["credit_amount"].' '.$credit_row["credit_currency"].'</div>
	<div id="credit_percentage" title="illik faiz dərəcəsi">'.$credit_row["credit_percentage"].' %</div>
	<div id="credit_period" title="ilkin təyin edilmiş müddət">'.$credit_row["credit_period"].' ay</div>
	<div id="applydate" title="kreditin qüvvəyə mindiyi tarix">'.date_format(date_create($credit_row["credit_startdate"]),"d-m-Y").'</div>
	<div id="verifydate" title="kreditin plan üzrə bitmə tarixi">'.date_format(date_create($credit_row["credit_enddate"]),"d-m-Y").'</div>
	<div id="credit_production" title="verilmiş kredit məhsulu">'.$credit_row["credit_product"].'</div>
	<br>';
	}
	while($credit_row = mysqli_fetch_assoc($credit_result));
}
echo '</div>';
?>