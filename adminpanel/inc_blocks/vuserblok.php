<?php 
defined('mcsystem') or die('Cəhdin yaxşı idi, sərf etdiyin vaxtı başqa şeyə sərf et!');

if($_SESSION['msg']){
		echo $_SESSION['msg'];
		unset($_SESSION['msg']);
}

if($_SESSION['users_role'] == 'admin'){
	$onlyread = '';
	$specuser = "";
}
else{
	$onlyread = 'disabled';
	$specuser = "AND login='{$_SESSION['auth_admin_login']}'";
}
	
	$user_res = mysqli_query($connect_link,"SELECT * FROM users WHERE id='$id' $specuser");
	if(mysqli_num_rows($user_res)>0){
		$user_row = mysqli_fetch_assoc($user_res);
		echo '
<form method="post">
	<div id="yigilma_sahesi">	
	<p>İstifadəçi profilində dəyişiklik</p>
	<div>
		<input type="submit" name="useredit_submit" id="form_submit" value="Redaktə et">
	</div>
	<div>
		<input autocomplete="off" id="userpassst" name="form_passv" type="password" placeholder="şifrə">
	</div>
	<div>
		<input '.$onlyread.' autocomplete="off" id="usernamest" name="form_login" type="text" title="istifadəçi adı" value="'.$user_row['login'].'">
	</div>
	<div>
		<input '.$onlyread.' autocomplete="off" id="usernspst" name="form_nsp" type="text" title="istifadəçinin ASA" value="'.$user_row['nsp'].'">
	</div>
	<div>
		<input '.$onlyread.' autocomplete="off" id="usermailst" name="form_usermail" type="text" title="Email ünvanı" value="'.$user_row['email'].'">
	</div>
	<div>
		<input '.$onlyread.' autocomplete="off" id="userphonest" name="form_userphone" type="text" title="Telefon nömrələri" value="'.$user_row['phone'].'">
	</div><br><br>
	<div>
		<select name="branchcode_select" '.$onlyread.'>
			<option value="" selected disabled>filial kodu seç</option>';
		
$brcode_result = mysqli_query($connect_link,"SELECT branch_code, full_name FROM branches");
if(mysqli_num_rows($brcode_result)>0){
	$brcode_row = mysqli_fetch_assoc($brcode_result);
	do{ echo '
		<option value="'.$brcode_row['branch_code'].'">'.$brcode_row['branch_code'].' - '.$brcode_row['full_name'].'</option>';}
	while($brcode_row = mysqli_fetch_assoc($brcode_result));
}
		echo '</select>
	</div>
	<div>
		<select name="branchname_select" '.$onlyread.'>
			<option value="" selected disabled>filial adını seç</option>';
$brname_result = mysqli_query($connect_link,"SELECT branch_code, full_name FROM branches");
if(mysqli_num_rows($brname_result)>0){
	$brname_row = mysqli_fetch_assoc($brname_result);
	do{ echo '
		<option value="'.$brname_row['full_name'].'">'.$brname_row['branch_code'].' - '.$brname_row['full_name'].'</option>';}
	while($brname_row = mysqli_fetch_assoc($brname_result));
}
		echo '</select>
	</div>
	<div>
		<select name="department_select" '.$onlyread.'>';
		if($user_row["department"] == "sales") $sales = "selected";
		if($user_row["department"] == "assembler") $assembler = "selected";
		if($user_row["department"] == "system") $system = "selected";
		if($user_row["department"] == "account_controllers") $account_controllers = "selected";
		if($user_row["department"] == "audit") $audit = "selected";
		if($user_row["department"] == "problemers") $problemers = "selected";
			echo'
			<option value="sales" '.$sales.'>satış</option>
			<option value="assembler" '.$assembler.'>inzibat</option>
			<option value="system" '.$system.'>sistem nəzarəti</option>
			<option value="account_controllers" '.$account_controllers.'>komplayns</option>
			<option value="audit" '.$audit.'>audit</option>
			<option value="problemers" '.$problemers.'>problemli aktivlər</option>
		</select>
	</div>
	<div>
		<select name="role_select" '.$onlyread.'>';
		if($user_row["role"] == "user") $user = "selected";
		if($user_row["role"] == "manager") $manager = "selected";
		if($user_row["role"] == "officer") $officer = "selected";
		if($user_row["role"] == "verifier") $verifier = "selected";
		if($user_row["role"] == "controllers") $controllers = "selected";
		if($user_row["role"] == "profcontroller") $profcontroller = "selected";
		if($user_row["role"] == "auditor") $auditor = "selected";
		if($user_row["role"] == "pachief") $pachief = "selected";
		if($user_row["role"] == "paredirect") $paredirect = "selected";
		if($user_row["role"] == "paspecialist") $paspecialist = "selected";
			echo '
			<option value="user" '.$user.'>satış-agent</option>
			<option value="manager" '.$manager.'>satış-menecer</option>
			<option value="officer" '.$officer.'>inzibat-əməliyyatçı</option>
			<option value="verifier" '.$verifier.'>inzibat-təsdiqləyici</option>
			<option value="controllers" '.$controllers.'>sistem-nəzarətçi</option>
			<option value="profcontroller" '.$profcontroller.'>komplayns-idarəedici</option>
			<option value="auditor" '.$auditor.'>audit-yoxlayıcı</option>
			<option value="pachief" '.$pachief.'>PK-baş hüquqşünas</option>
			<option value="paredirect" '.$paredirect.'>PK-yönləndirici</option>
			<option value="paspecialist" '.$paspecialist.'>PK-əməliyyatçı</option>
		</select>
	</div>
	<div>
		<select name="compliance_select" '.$onlyread.'>';
		if($user_row["compliance"] == "manager") $manager = "selected";
		if($user_row["compliance"] == "verifier") $verifier = "selected";
		if($user_row["compliance"] == "admin") $admin = "selected";
		if($user_row["compliance"] == "pachief") $pachief = "selected";
			echo'
			<option value="manager" '.$manager.'>satış-menecer</option>
			<option value="verifier" '.$verifier.'>inzibat-təsdiqləyici</option>
			<option value="admin" '.$admin.'>sistem-adminstratoru</option>
			<option value="pachief" '.$pachief.'>PK-baş hüquqşünas</option>
		</select>
	</div>
	<br><br>';
	if($user_row["msh"] == "1") $msh = "checked";
	if($user_row["ih"] == "1") $ih = "checked";
	if($user_row["kk"] == "1") $kk = "checked";
	if($user_row["kkk"] == "1") $kkk = "checked";
	if($user_row["view_customer"] == "1") $view_customer = "checked";
	if($user_row["edit_customer"] == "1") $edit_customer = "checked";
	if($user_row["view_order"] == "1") $view_order = "checked";
	if($user_row["edit_order"] == "1") $edit_order = "checked";
	if($user_row["view_credit"] == "1") $view_credit = "checked";
	if($user_row["edit_credit"] == "1") $edit_credit = "checked";
	if($user_row["view_pledge"] == "1") $view_pledge = "checked";
	if($user_row["edit_pledge"] == "1") $edit_pledge = "checked";
	if($user_row["view_concat"] == "1") $view_concat = "checked";
	if($user_row["edit_concat"] == "1") $edit_concat = "checked";
	if($user_row["view_notif"] == "1") $view_notif = "checked";
	if($user_row["edit_notif"] == "1") $edit_notif = "checked";	
	echo'<div>
		<input '.$onlyread.' type="checkbox" name="msh" id="msh" value="1" '.$msh.'>
		<label for="msh">Müşahidə Şurası</label>
	</div>
	<div>
		<input '.$onlyread.' type="checkbox" name="ih" id="ih" value="1" '.$ih.'>
		<label for="ih">İdarə Heyəti</label>
	</div>
	<div>
		<input '.$onlyread.' type="checkbox" name="kk" id="kk" value="1" '.$kk.'>
		<label for="kk">Kredit Komitəsi</label>
	</div>
	<div>
		<input '.$onlyread.' type="checkbox" name="kkk" id="kkk" value="1" '.$kk.'>
		<label for="kk">Kiçik Kredit Komitəsi</label>
	</div>
	<br><br>
	<div>
		<input '.$onlyread.' type="checkbox" name="view_customer" id="view_customer" value="1" '.$view_customer.'>
		<label for="view_customer">Müştərini göstər</label>
	</div>
	<div>
		<input '.$onlyread.' type="checkbox" name="edit_customer" id="edit_customer" value="1" '.$edit_customer.'>
		<label for="edit_customer">Müştərini redaktə et</label>
	</div>
	<div>
		<input '.$onlyread.' type="checkbox" name="view_order" id="view_order" value="1" '.$view_order.'>
		<label for="view_order">Sifarişi göstər</label>
	</div>
	<div>
		<input '.$onlyread.' type="checkbox" name="edit_order" id="edit_order" value="1" '.$edit_order.'>
		<label for="edit_order">Sifarişi redaktə et</label>
	</div>
	<div>
		<input '.$onlyread.' type="checkbox" name="view_credit" id="view_credit" value="1" '.$view_credit.'>
		<label for="view_credit">Krediti göstər</label>
	</div>
	<div>
		<input '.$onlyread.' type="checkbox" name="edit_credit" id="edit_credit" value="1" '.$edit_credit.'>
		<label for="edit_credit">Krediti redaktə et</label>
	</div>
	<br><br>
	<div>
		<input '.$onlyread.' type="checkbox" name="view_pledge" id="view_pledge" value="1" '.$view_pledge.'>
		<label for="view_pledge">Girovu göstər</label>
	</div>
	<div>
		<input '.$onlyread.' type="checkbox" name="edit_pledge" id="edit_pledge" value="1" '.$edit_pledge.'>
		<label for="edit_pledge">Girovu redaktə et</label>
	</div>
	<div>
		<input '.$onlyread.' type="checkbox" name="view_concat" id="view_concat" value="1" '.$view_concat.'>
		<label for="view_concat">Birləşməni göstər</label>
	</div>
	<div>
		<input '.$onlyread.' type="checkbox" name="edit_concat" id="edit_concat" value="1" '.$edit_concat.'>
		<label for="edit_concat">Birləşməni redaktə et</label>
	</div>
	<div>
		<input '.$onlyread.' type="checkbox" name="view_notif" id="view_notif" value="1" '.$view_notif.'>
		<label for="view_notif">Bildirişi göstər</label>
	</div>
	<div>
		<input '.$onlyread.' type="checkbox" name="edit_notif" id="edit_notif" value="1" '.$edit_notif.'>
		<label for="edit_notif">Bildirişi redaktə et</label>
	</div>
	</div>
</form>';}
?>