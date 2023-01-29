<?php 
defined('mcsystem') or die('Cəhdin yaxşı idi, sərf etdiyin vaxtı başqa şeyə sərf et!');
?>
<div id="midblock">
<?php 
if($_SESSION['users_role'] == 'officer' || $_SESSION['users_role'] == 'user' || $_SESSION['bank_department'] == "system"){ echo '<a href="addnote"><p style="background-color: yellow; ">Bildiriş əlavə et</p></a>';}
	
if($_SESSION['users_role'] == 'officer' || $_SESSION['users_role'] == 'user'){
	$forspecusers = "AND bank='{$_SESSION["auth_admin_login"]}'";
}
	
if($_SESSION['users_role'] == 'verifier' || $_SESSION['users_role'] == 'manager'){
	$forspecboss = "AND verifingbos='{$_SESSION["auth_admin_login"]}'";
}

if($_SESSION['bank_department'] == 'assembler' || $_SESSION['bank_department'] == 'sales' || $_SESSION['notif_view'] == '1'){	
	$res_notifs = mysqli_query($connect_link,"SELECT * FROM notification_data WHERE verified='yes' $forspecusers $forspecboss");
	if(mysqli_num_rows($res_notifs)>0){
	$row_notifs = mysqli_fetch_assoc($res_notifs);
	echo '
	<p>Mövcud bildirişlər</p>
	<div id="concatcred" class="basliqxanalar">Bildiriş</div>
	<div id="applydate" class="basliqxanalar">Daxilolma</div>
	<div id="applydate" class="basliqxanalar">Təsdiq</div>
	<div id="clientid" class="basliqxanalar">Müştəri ID</div>
	<div id="clientid" class="basliqxanalar">Qeyd</div>
	<div id="ofcerlogin" class="basliqxanalar">İstifadəçi</div>
	<div id="ofcerlogin" class="basliqxanalar">Rəhbər</div>
	<br>
	';
	do{ echo '
	<br>
	<div id="concatcred" title="bildirişin nömrəsi"><a href="view_notifs?id='.$row_notifs["id"].'">Bildiriş - '.$row_notifs["id"].'</a></div>
	<div id="applydate" title="bildirişin daxil edildiyi tarix">'.date_format(date_create($row_notifs["note_date"]),"d-m-Y").'</div>
	<div id="applydate" title="bildirişin təsdiq edildiyi tarix">'.date_format(date_create($row_notifs["verifydate"]),"d-m-Y").'</div>
	<div id="clientid" title="müştərinin FİN kodu və ya VÖEN">'.$row_notifs["client"].'</div>
	<div id="clientid" title="qeydin tipi">'.$row_notifs["note_type"].'</div>
	<div id="ofcerlogin" title="əlavə edən istifadəçi">'.$row_notifs["bank"].'</div>
	<div id="ofcerlogin" title="təsdiq edən rəhbər">'.$row_notifs["verifingbos"].'</div>
	<br>';
	}
	while($row_notifs = mysqli_fetch_assoc($res_notifs));}
}
?>
</div>