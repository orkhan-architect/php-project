<?php 
defined('mcsystem') or die('Cəhdin yaxşı idi, sərf etdiyin vaxtı başqa şeyə sərf et!');

if($_SESSION['users_role'] == 'officer' || $_SESSION['users_role'] == 'user' || $_SESSION['bank_department'] == "system"){
	
	if($_SESSION['users_role'] == 'officer'){
	$forofficers = "WHERE cho_officer='{$_SESSION["auth_admin_login"]}'";
	}
	
	if($_SESSION['users_role'] == 'user'){
	$foragents = "WHERE cho_creditor='{$_SESSION["auth_admin_login"]}'";
	}
?>
<form method="post">
<div id="yigilma_sahesi">
	<?php 
	if($_SESSION['msg']){
		echo $_SESSION['msg'];
		unset($_SESSION['msg']);
	}
	?>
	<p>Bildirişin daxil edilməsi</p>
	<div>
		<input type="submit" name="notif_submit" id="form_submit" value="Göndər">
	</div>
	<div>
		<select name="clientid_select">
			<option value="" selected disabled>müştərini seç</option>
<?php 
$customer_result = mysqli_query($connect_link,"SELECT DISTINCT client FROM cre_orders $forofficers $foragents");
if(mysqli_num_rows($customer_result)>0){
	$customer_row = mysqli_fetch_assoc($customer_result);
	do{ echo '
		<option value="'.$customer_row['client'].'">'.$customer_row['client'].'</option>';}
	while($customer_row = mysqli_fetch_assoc($customer_result));
}
?>
		</select>
	</div>
	<div>
		<select name="note_select">
			<option value="" selected disabled>qeyd növünü seç</option>
			<option value="bildiriş">Məlumat ver</option>
			<option value="xəbərdarlıq">Xəbərdar et</option>
		</select>
	</div>
	<div>
		<textarea rows="1" cols="30" name="form_note" placeholder="müştəriyə bildiriş yaz" style="vertical-align: sub;"></textarea>
	</div>
</div>
</form>
<?php 
}
else{
	echo 'Hörmətli istifadəçi. Sənə aid olmayan səhifələrə cəhd edib girmə!';
};
?>