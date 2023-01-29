<?php 
defined('mcsystem') or die('Cəhdin yaxşı idi, sərf etdiyin vaxtı başqa şeyə sərf et!');
if($_SESSION['users_role'] == 'officer' || $_SESSION['bank_department'] == "system"){
?>
<form method="post">
<div id="yigilma_sahesi">
	<?php 
	if($_SESSION['msg']){
		echo $_SESSION['msg'];
		unset($_SESSION['msg']);
	}
	?>
	<p>Girov kredit birləşməsi</p>
	<div>
		<select name="credit_select">
			<option value="" selected disabled>krediti seç</option>
<?php 
$credit_result = mysqli_query($connect_link,"SELECT id, unical_credid FROM cre_data WHERE credit_status='aktiv' ORDER BY id DESC");
if(mysqli_num_rows($credit_result)>0){
	$credit_row = mysqli_fetch_assoc($credit_result);
	do{ echo '
		<option value="'.$credit_row['id'].'"> '.$credit_row['unical_credid'].'</option>';}
	while($credit_row = mysqli_fetch_assoc($credit_result));
}
?>
		</select>
	</div>
	<div>
		<select name="pledge_select">
			<option value="" selected disabled>girovu seç</option>
<?php 
$pledge_result = mysqli_query($connect_link,"SELECT id, pledge_name, pledge_cost, pledge_currency, register_id FROM pledge_data WHERE manager_decision='təsdiq'");
if(mysqli_num_rows($pledge_result)>0){
	$pledge_row = mysqli_fetch_assoc($pledge_result);
	do{ echo '
		<option value="'.$pledge_row['id'].'" title="'.$pledge_row['pledge_cost'].' '.$pledge_row['pledge_currency'].'">'.$pledge_row['pledge_name'].' - '.$pledge_row['register_id'].'</option>';}
	while($pledge_row = mysqli_fetch_assoc($pledge_result));
}
?>
		</select>
	</div>
	<div>
		<select name="contract_select">
			<option value="" selected disabled>müqavilə növü seç</option>
			<option value="İlkin">İlkin girovasalma</option>
			<option value="Sonrakı">Sonrakı girovasalma</option>
		</select>
	</div>
	<div>
		<input name="form_contractdate" type="date" title="girovasalma tarixi">
	</div>
	<div>
		<input type="submit" name="concatenate_submit" id="form_submit" value="Girov birləşdir">
	</div>
</div>
</form>
<?php 
}
else{
	echo 'Hörmətli istifadəçi. Sənə aid olmayan səhifələrə cəhd edib girmə!';
};
?>