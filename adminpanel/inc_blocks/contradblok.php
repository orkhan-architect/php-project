<?php 
defined('mcsystem') or die('Cəhdin yaxşı idi, sərf etdiyin vaxtı başqa şeyə sərf et!');

if($_SESSION['users_role'] == 'user' || $_SESSION['bank_department'] == "system"){
?>
<form method="post">
<div id="yigilma_sahesi">
	<?php 
	if($_SESSION['msg']){
		echo $_SESSION['msg'];
		unset($_SESSION['msg']);
	}
	?>
	<p>Müqavilə çapı üçün seçim edilməsi</p>
	<div>
		<input type="submit" name="contract_submit" id="form_submit" value="Çap et">
	</div>
	<div>
		<input autocomplete="off" id="offerd_amount" name="cont_clientid" type="text" placeholder="PIN ya VÖEN" onkeyup="this.value = this.value.toUpperCase();">
	</div>
	<div>
		<select name="contrcreditid">
			<option value="" selected disabled>krediti seç</option>
<?php 
if($_SESSION['users_role'] == 'user'){
	$forcredagent = "AND credit_officer='{$_SESSION["auth_admin_login"]}'";
}
$credit_result = mysqli_query($connect_link,"SELECT id, unical_credid FROM cre_data WHERE verified='yes' $forcredagent");
if(mysqli_num_rows($credit_result)>0){
	$credit_row = mysqli_fetch_assoc($credit_result);
	do{ echo '
		<option value="'.$credit_row['id'].'">'.$credit_row['unical_credid'].'</option>';}
	while($credit_row = mysqli_fetch_assoc($credit_result));
}
?>
		</select>
	</div>
	<div>
		<select name="pledge" id="pledge_exist">
			<option value="" selected disabled>girovludurmu</option>
			<option value="girovlu">bəli</option>
			<option value="girovsuz">xeyr</option>
		</select>
	</div>
	<div>
		<select name="contrpledgeid" class="show-hide">
			<option value="" selected disabled>girovu seç</option>
<?php 
if($_SESSION['users_role'] == 'user'){
	$forpledagent = "AND agent='{$_SESSION["auth_admin_login"]}'";
}
$pledge_result = mysqli_query($connect_link,"SELECT id, pledge_name, register_id FROM pledge_data WHERE manager_decision='təsdiq' $forpledagent");
if(mysqli_num_rows($pledge_result)>0){
	$pledge_row = mysqli_fetch_assoc($pledge_result);
	do{ echo '
		<option value="'.$pledge_row['id'].'">'.$pledge_row['pledge_name'].' - '.$pledge_row['register_id'].'</option>';}
	while($pledge_row = mysqli_fetch_assoc($pledge_result));
}
?>
		</select>
	</div>
	<div>
		<select name="contrpleform" class="show-hide">
			<option value="" selected disabled>girovqoyma forması seç</option>
			<option value="ilkin">İlkin qeydiyyat</option>
			<option value="sonrakı">Sonrakı qeydiyyat</option>
			<option value="əlavə">Əlavə qeydiyyat</option>
		</select>
	</div>
</div>
</form>
<?php 
}
else{
	echo 'Hörmətli istifadəçi. Sənə aid olmayan səhifələrə cəhd edib girmə!';
};
?>