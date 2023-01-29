<?php defined('mcsystem') or die('Cəhdin yaxşı idi, sərf etdiyin vaxtı başqa şeyə sərf et!');

echo '
<div id="midblock">';
if($_SESSION['users_role'] == 'admin'){echo '
	<p>Girov bazası yüklə</p>';
	echo $message;
	echo '
	<form id="import_excel_form" method="post" enctype="multipart/form-data">
		<p id="message"></p>
		<input id="leftmarg" type="file" name="import_excel">
		<input type="submit" name="import" id="import" value="Yüklə">
	</form>';}
if($_SESSION['bank_department'] == "system"){echo '
	<p>Girov bazası ixrac et</p>
	<form method="post" action="exportcol.php">	
		<select name="file_type" id="leftmarg">
    		<option value="Xlsx">Xlsx</option>
            <option value="Xls">Xls</option>
            <option value="Csv">Csv</option>
        </select>
		<input id="form_submit" type="submit" name="export" value="İxrac et">
	</form>';}
echo '<p>AXTARIŞ sistemi</p>
	<form method="GET" action="searchple?q=">
		<input type="text" autocomplete="off" id="input_search" name="q" placeholder="3-25 simvol arası">
		<select name="search_place">
			<option value="" selected disabled>kriteriya seç</option>
			<option value="mortgagor">girovqoyan</option>
			<option value="pledge_name">girov tipi</option>
			<option value="register_id">reyestr/ban/şassi/hesab</option>
		</select>
        <input type="submit" id="form_submit" value="Axtar">
	</form>';
	
if($_SESSION['users_role'] == 'user' || $_SESSION['bank_department'] == "system"){echo '<a href="addpledge"><p style="background-color: yellow; ">Girov əlavə et</p></a>';}
	
$res_pledge = mysqli_query($connect_link,"SELECT * FROM pledge_data WHERE manager_decision='təsdiq' ORDER BY manager_chdate DESC");
if(mysqli_num_rows($res_pledge)>0){
	$row_pledge = mysqli_fetch_assoc($res_pledge);
	echo '
	<p>Mövcud girovlar</p>
	<div id="typledge" class="basliqxanalar">Girovun növü</div>
	<div id="applydate" class="basliqxanalar">Yığılma</div>
	<div id="applydate" class="basliqxanalar">Təsdiq</div>
	<div id="personalid" class="basliqxanalar">Girovqoyan ID</div>
	<div id="clientnsp" class="basliqxanalar">Girovqoyan</div>
	<div id="pledamount" class="basliqxanalar">Məbləği</div>
	<div id="pledcurrency" class="basliqxanalar">Val</div>
	<br>
	';
	do{ echo '
	<br>
	<div id="typledge" title="girovun növü"><a href="view_pledge?id='.$row_pledge["id"].'">'.$row_pledge["pledge_name"].'</a></div>
	<div id="applydate" title="yığılma tarixi">'.date_format(date_create($row_pledge["agent_chdate"]),"d-m-Y").'</div>
	<div id="applydate" title="təsdiqlənmə tarixi">'.date_format(date_create($row_pledge["manager_chdate"]),"d-m-Y").'</div>
	<div id="personalid" title="FİNKOD (VÖEN)">'.$row_pledge["fincode_taxes"].'</div>
	<div id="clientnsp" title="Girovqoyan ASA (Şirkətin adı)">'.$row_pledge["mortgagor"].'</div>
	<div id="pledamount" title="giorvun məbləği">'.$row_pledge["pledge_cost"].'</div>
	<div id="pledcurrency" title="girovun valyutası">'.$row_pledge["pledge_currency"].'</div>
	<br>';
	}
	while($row_pledge = mysqli_fetch_assoc($res_pledge));}
?>
</div>