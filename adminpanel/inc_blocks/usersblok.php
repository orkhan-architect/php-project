<?php 
defined('mcsystem') or die('Cəhdin yaxşı idi, sərf etdiyin vaxtı başqa şeyə sərf et!');

if($_SESSION['users_role'] == 'admin'){
		
$res_users = mysqli_query($connect_link,"SELECT * FROM users");
if(mysqli_num_rows($res_users)>0){
	$row_users = mysqli_fetch_assoc($res_users);
	echo '
<div id="midblock">
	<a href="adusers"><p style="background-color: yellow; ">İstifadəçi əlavə et</p></a>
	<p>İstifadəçilər</p>
	<div id="brname" class="basliqxanalar">İstifadəçi</div>
	<div id="brabbr" class="basliqxanalar">Filial</div>
	<div id="clientnsp" class="basliqxanalar">ASA</div>
	<br>
	';
	do{ echo '
	<br>
	<div id="brname" title="sistemdə istifadəçi adı">
		<a href="view_users?id='.$row_users["id"].'">'.$row_users["login"].'</a>
	</div>
	<div id="brabbr" title="işlədiyi filialın kodu">'.$row_users["branch"].'</div>
	<div id="clientnsp" title="istifadəçinin soyadı adı atasının adı">'.$row_users["nsp"].'</div>
	<br>';
	}
	while($row_users = mysqli_fetch_assoc($res_users));
echo '</div>';}
}
else{
	$res_users = mysqli_query($connect_link,"SELECT * FROM users WHERE login='{$_SESSION['auth_admin_login']}'");
	$row_users = mysqli_fetch_assoc($res_users);
	echo '
<div id="midblock">
	<p>İstifadəçi</p>
	<div id="brname" class="basliqxanalar">İstifadəçi</div>
	<div id="brabbr" class="basliqxanalar">Filial</div>
	<div id="clientnsp" class="basliqxanalar">ASA</div>
	<br><br>	
	<div id="brname" title="sistemdə istifadəçi adı">
		<a href="view_users?id='.$row_users["id"].'">'.$row_users["login"].'</a>
	</div>
	<div id="brabbr" title="işlədiyi filialın kodu">'.$row_users["branch"].'</div>
	<div id="clientnsp" title="istifadəçinin soyadı adı atasının adı">'.$row_users["nsp"].'</div>
	<br>
</div>';
}
?>