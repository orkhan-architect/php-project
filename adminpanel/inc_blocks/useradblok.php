<?php 
defined('mcsystem') or die('Cəhdin yaxşı idi, sərf etdiyin vaxtı başqa şeyə sərf et!');
if($_SESSION['users_role'] == 'admin'){
?>
<form method="post">
<div id="yigilma_sahesi">
	<?php 
	if($_SESSION['msg']){
		echo $_SESSION['msg'];
		unset($_SESSION['msg']);
	}
	?>
	<p>İstifadəçinin əlavə edilməsi</p>
	<div>
		<input type="submit" name="user_submit" id="form_submit" value="Daxil et">
	</div>
	<div>
		<input autocomplete="off" id="usernamest" name="form_login" type="text" placeholder="istifadəçi adı">
	</div>
	<div>
		<input autocomplete="off" id="userpassst" name="form_passv" type="password" placeholder="şifrə">
	</div>
	<div>
		<input autocomplete="off" id="usernspst" name="form_nsp" type="text" placeholder="istifadəçinin ASA">
	</div>
	<div>
		<input autocomplete="off" id="usermailst" name="form_usermail" type="text" placeholder="Email ünvanı">
	</div>
	<div>
		<input autocomplete="off" id="userphonest" name="form_userphone" type="text" placeholder="Telefon nömrələri">
	</div><br><br>
	<div>
		<select name="branchcode_select">
			<option value="" selected disabled>filial kodu seç</option>
<?php 
$brcode_result = mysqli_query($connect_link,"SELECT branch_code, full_name FROM branches");
if(mysqli_num_rows($brcode_result)>0){
	$brcode_row = mysqli_fetch_assoc($brcode_result);
	do{ echo '
		<option value="'.$brcode_row['branch_code'].'">'.$brcode_row['branch_code'].' - '.$brcode_row['full_name'].'</option>';}
	while($brcode_row = mysqli_fetch_assoc($brcode_result));
}
?>
		</select>
	</div>
	<div>
		<select name="branchname_select">
			<option value="" selected disabled>filial adını seç</option>
<?php 
$brname_result = mysqli_query($connect_link,"SELECT branch_code, full_name FROM branches");
if(mysqli_num_rows($brname_result)>0){
	$brname_row = mysqli_fetch_assoc($brname_result);
	do{ echo '
		<option value="'.$brname_row['full_name'].'">'.$brname_row['branch_code'].' - '.$brname_row['full_name'].'</option>';}
	while($brname_row = mysqli_fetch_assoc($brname_result));
}
?>
		</select>
	</div>
	<div>
		<select name="department_select">
			<option value="" selected disabled>departamenti seç</option>
			<option value="sales">satış</option>
			<option value="assembler">inzibat</option>
			<option value="system">sistem nəzarəti</option>
			<option value="account_controllers">komplayns</option>
			<option value="audit">audit</option>
			<option value="problemers">problemli aktivlər</option>
		</select>
	</div>
	<div>
		<select name="role_select">
			<option value="" selected disabled>vəzifə seç</option>
			<option value="user">satış-agent</option>
			<option value="manager">satış-menecer</option>
			<option value="officer">inzibat-əməliyyatçı</option>
			<option value="verifier">inzibat-təsdiqləyici</option>
			<option value="controllers">sistem-nəzarətçi</option>
			<option value="profcontroller">komplayns-idarəedici</option>
			<option value="auditor">audit-yoxlayıcı</option>
			<option value="pachief">PK-baş hüquqşünas</option>
			<option value="paredirect">PK-yönləndirici</option>
			<option value="paspecialist">PK-əməliyyatçı</option>
		</select>
	</div>
	<div>
		<select name="compliance_select">
			<option value="" selected disabled>tabeçiliyi seç</option>
			<option value="manager">satış-menecer</option>
			<option value="verifier">inzibat-təsdiqləyici</option>
			<option value="admin">sistem-adminstratoru</option>
			<option value="pachief">PK-baş hüquqşünas</option>
		</select>
	</div>
	<br><br>
	<div>
		<input type="checkbox" name="msh" id="msh" value="1">
		<label for="msh">Müşahidə Şurası</label>
	</div>
	<div>
		<input type="checkbox" name="ih" id="ih" value="1">
		<label for="ih">İdarə Heyəti</label>
	</div>
	<div>
		<input type="checkbox" name="kk" id="kk" value="1">
		<label for="kk">Kredit Komitəsi</label>
	</div>
	<div>
		<input type="checkbox" name="kkk" id="kkk" value="1">
		<label for="kk">Kiçik Kredit Komitəsi</label>
	</div>
	<br><br>
	<div>
		<input type="checkbox" name="view_customer" id="view_customer" value="1">
		<label for="view_customer">Müştərini göstər</label>
	</div>
	<div>
		<input type="checkbox" name="edit_customer" id="edit_customer" value="1">
		<label for="edit_customer">Müştərini redaktə et</label>
	</div>
	<div>
		<input type="checkbox" name="view_order" id="view_order" value="1">
		<label for="view_order">Sifarişi göstər</label>
	</div>
	<div>
		<input type="checkbox" name="edit_order" id="edit_order" value="1">
		<label for="edit_order">Sifarişi redaktə et</label>
	</div>
	<div>
		<input type="checkbox" name="view_credit" id="view_credit" value="1">
		<label for="view_credit">Krediti göstər</label>
	</div>
	<div>
		<input type="checkbox" name="edit_credit" id="edit_credit" value="1">
		<label for="edit_credit">Krediti redaktə et</label>
	</div>
	<br><br>
	<div>
		<input type="checkbox" name="view_pledge" id="view_pledge" value="1">
		<label for="view_pledge">Girovu göstər</label>
	</div>
	<div>
		<input type="checkbox" name="edit_pledge" id="edit_pledge" value="1">
		<label for="edit_pledge">Girovu redaktə et</label>
	</div>
	<div>
		<input type="checkbox" name="view_concat" id="view_concat" value="1">
		<label for="view_concat">Birləşməni göstər</label>
	</div>
	<div>
		<input type="checkbox" name="edit_concat" id="edit_concat" value="1">
		<label for="edit_concat">Birləşməni redaktə et</label>
	</div>
	<div>
		<input type="checkbox" name="view_notif" id="view_notif" value="1">
		<label for="view_notif">Bildirişi göstər</label>
	</div>
	<div>
		<input type="checkbox" name="edit_notif" id="edit_notif" value="1">
		<label for="edit_notif">Bildirişi redaktə et</label>
	</div>
</div>
</form>
<?php 
}
else{
	echo 'Hörmətli istifadəçi. Sənə aid olmayan səhifələrə cəhd edib girmə!';
};
?>