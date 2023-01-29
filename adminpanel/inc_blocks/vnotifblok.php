<?php 
defined('mcsystem') or die('Cəhdin yaxşı idi, sərf etdiyin vaxtı başqa şeyə sərf et!');

if($_SESSION['users_role'] == 'user' || $_SESSION['users_role'] == 'officer'){
	$forspecusers = "AND bank='{$_SESSION["auth_admin_login"]}'";
}
if($_SESSION['users_role'] == 'verifier' || $_SESSION['users_role'] == 'manager'){
	$forspecboss = "AND verifingbos='{$_SESSION["auth_admin_login"]}'";
}

$note_res = mysqli_query($connect_link,"SELECT * FROM notification_data WHERE id='$id' $forspecusers $forspecboss");
if(mysqli_num_rows($note_res)>0){
	$note_row = mysqli_fetch_assoc($note_res);
	
if($_SESSION['notif_edit'] == '1'){echo '
<form method="post">
	<div id="yigilma_sahesi">';
									
	if($_SESSION['bank_department'] == "system"){
	echo '
	<p>Sistem nəzarətçisinin RESETi</p>
	<div>
		<input type="submit" name="notifreset_submit" id="form_submit" value="RESET">
	</div>';}
	
	if($_SESSION['users_role'] == 'verifier' || $_SESSION['users_role'] == 'manager' || $_SESSION['bank_department'] == "system"){
		if(!$note_row["verifydate"]){echo '
	<p>Bildirişin təsdiqi</p>
	<div>
		<input type="submit" name="noteconfirm_submit" id="form_submit" value="Təsdiqlə">
	</div>';}
	}
									
	if($_SESSION['users_role'] == 'officer' || $_SESSION['users_role'] == 'user' || $_SESSION['bank_department'] == "system"){
		if(!$note_row["note_date"]){echo '
	<p>Bildirişin redaktəsi</p>
	<div>
		<input type="submit" name="notifedit_submit" id="form_submit" value="Dəyiş">
	</div>
	<div>
		<select name="clientid_select">
			<option value="" selected disabled>müştərini seç</option>';
$customer_result = mysqli_query($connect_link,"SELECT login, client FROM cstmr_data $forofficers $foragents");
if(mysqli_num_rows($customer_result)>0){
	$customer_row = mysqli_fetch_assoc($customer_result);
	do{ echo '
		<option value="'.$customer_row['login'].'">ID-'.$customer_row['login'].' - '.$customer_row['client'].'</option>';}
	while($customer_row = mysqli_fetch_assoc($customer_result));
}
		echo '</select>
	</div>
	<div>
		<select name="note_select">
			<option value="" selected disabled>qeyd növünü seç</option>
			<option value="bildiriş">Məlumat ver</option>
			<option value="xəbərdarlıq">Xəbərdar et</option>
		</select>
	</div>
	<div>
		<textarea rows="1" cols="30" name="form_note" placeholder="müştəriyə bildiriş yaz" style="vertical-align: sub;">'.$note_row["note_text"].'</textarea>
	</div>';}
	}
									
echo '
	</div>
</form>';}
	
	if($_SESSION['notif_view'] == '1' || $_SESSION['bank_department'] == 'sales' || $_SESSION['bank_department'] == 'assembler'){
	
	$clientname_res = mysqli_query($connect_link,"SELECT client FROM cstmr_data WHERE login='{$note_row["client"]}'");
	$clientname_row = mysqli_fetch_assoc($clientname_res);

		echo '
<div id="midblock">
	<p>Bildiriş barədə</p>
	<div title="müştəri ID">'.$note_row["client"].'</div>
	<div title="müştərinin inisialı">'.$clientname_row["client"].'</div>
	<div title="müştəriyə göndərilən ismarıcın növü">'.$note_row["note_type"].'</div><br><br>
	<div title="müştəriyə göndərilən qeyd">'.$note_row["note_text"].'</div>
	<p>Bildirişi yaradan və təsdiq edənlər barədə</p>
	<div title="təsdiqlənibmi">'.$note_row["verified"].'</div>
	<div title="müştəriyə qeydi göndərmiş istifadəçi">'.$note_row["bank"].'</div>
	<div title="qeydi təsdiq etmiş rəhbər">'.$note_row["verifingbos"].'</div>';
	if(isset($note_row["note_date"])){echo '<div title="bildirişin daxil edildiyi tarix">'.date_format(date_create($note_row["note_date"]),"d-m-Y H:i:s").'</div>';}
	if(isset($note_row["verifydate"])){echo '<div title="bildirişin təsdiq edildiyi tarix">'.date_format(date_create($note_row["verifydate"]),"d-m-Y H:i:s").'</div>';}
echo '</div>';}
}
?>