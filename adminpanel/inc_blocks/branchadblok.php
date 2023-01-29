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
	<p>Filialın daxil edilməsi</p>
	<div>
		<input type="submit" name="branch_submit" id="form_submit" value="Daxil et">
	</div>
	<div>
		<input id="brnamestyle" name="form_branchname" type="text" placeholder="Filialın adı">
	</div>
	<div>
		<input id="brcodestyle" name="form_branchcode" type="text" placeholder="Filialın kodu" onkeyup="this.value = this.value.toUpperCase();">
	</div>
	<div>
		<input id="brpost" name="form_bosspost" type="text" placeholder="Rəhbərin vəzifəsi">
	</div>
	<div>
		<input id="pledgerstyle" name="form_branchboss" type="text" placeholder="Rəhbərin ASA">
	</div>
	<br><br>
	<div>
		<input id="brnamestyle" name="form_branchcity" type="text" placeholder="yerləşdiyi şəhər">
	</div>
	<div>
		<textarea rows="1" cols="30" name="form_address" placeholder="filialın ünvanı" style="vertical-align: sub;"></textarea>
	</div>
	<div>
		<textarea rows="1" cols="30" name="form_brdata" placeholder="filialın rekvizitləri" style="vertical-align: sub;"></textarea>
	</div>
</div>
</form>
<?php 
}
else{
	echo 'Hörmətli istifadəçi. Sənə aid olmayan səhifələrə cəhd edib girmə!';
};
?>