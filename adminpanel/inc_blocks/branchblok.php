<?php 
defined('mcsystem') or die('Cəhdin yaxşı idi, sərf etdiyin vaxtı başqa şeyə sərf et!');

if($_SESSION['users_role'] == 'admin'){
		
$res_branches = mysqli_query($connect_link,"SELECT * FROM branches");
if(mysqli_num_rows($res_branches)>0){
	$row_branches = mysqli_fetch_assoc($res_branches);
	echo '
<div id="midblock">
	<a href="addbranch"><p style="background-color: yellow; ">Filial əlavə et</p></a>
	<p>Filiallar</p>
	<div id="brname" class="basliqxanalar">Filial</div>
	<div id="brabbr" class="basliqxanalar">Kodu</div>
	<div id="clientnsp" class="basliqxanalar">Rəhbər</div>
	<div id="clientid" class="basliqxanalar">Statusu</div>
	<div id="applydate" class="basliqxanalar">Bağlanıb</div>
	<br>
	';
	do{ echo '
	<br>
	<div id="brname" title="filialın tam adı">
		<a href="view_branches?id='.$row_branches["id"].'">'.$row_branches["full_name"].'</a>
	</div>
	<div id="brabbr" title="filialın kodu">'.$row_branches["branch_code"].'</div>
	<div id="clientnsp" title="filial rəhbəri">'.$row_branches["branch_boss"].'</div>
	<div id="clientid" title="filialın işləməsi">'.$row_branches["branch_status"].'</div>';
	if(!isset($row_branches["closed_date"]) || $row_branches["closed_date"] == ''){echo '';}
	else{ echo '
	<div id="clientid" title="filialın bağlandığı tarix">'.$row_branches["closed_date"].'</div>';}
	echo '<br>';
	}
	while($row_branches = mysqli_fetch_assoc($res_branches));
echo '</div>';}
}
?>