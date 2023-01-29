<?php 
defined('mcsystem') or die('Cəhdin yaxşı idi, sərf etdiyin vaxtı başqa şeyə sərf et!');

if($_SESSION['msg']){
		echo $_SESSION['msg'];
		unset($_SESSION['msg']);
}
	
if($_SESSION['users_role'] == 'admin'){
	$branch_res = mysqli_query($connect_link,"SELECT * FROM branches WHERE id='$id'");
	if(mysqli_num_rows($branch_res)>0){
		$branch_row = mysqli_fetch_assoc($branch_res);
		echo '
<form method="post">
	<div id="yigilma_sahesi">
	<p>Filialın daxil edilməsi</p>
	<div>
		<input type="submit" name="branchedit_submit" id="form_submit" value="Redaktə et">
	</div>
	<div>
		<input id="brnamestyle" name="form_branchname" type="text" title="Filialın adı" value="'.$branch_row['full_name'].'">
	</div>
	<div>
		<input id="brcodestyle" name="form_branchcode" type="text" title="Filialın kodu" onkeyup="this.value = this.value.toUpperCase();" value="'.$branch_row['branch_code'].'">
	</div>
	<div>
		<input id="brpost" name="form_bosspost" type="text" title="Rəhbərin vəzifəsi" value="'.$branch_row['boss_post'].'">
	</div>
	<div>
		<input id="pledgerstyle" name="form_branchboss" type="text" title="Rəhbərin ASA" value="'.$branch_row['branch_boss'].'">
	</div>
	<br><br>
	<div>
		<input id="brnamestyle" name="form_branchcity" type="text" title="yerləşdiyi şəhər" value="'.$branch_row['region'].'">
	</div>
	<div>
		<textarea rows="3" cols="30" name="form_address" title="filialın ünvanı" style="vertical-align: sub;">'.$branch_row['address'].'</textarea>
	</div>
	<div>
		<textarea rows="3" cols="30" name="form_brdata" title="filialın rekvizitləri" style="vertical-align: sub;">'.$branch_row['branch_properties'].'</textarea>
	</div>							
	
	</div>
</form>';}
}
?>