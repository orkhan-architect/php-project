<?php defined('mcsystem') or die('Cəhdin yaxşı idi, sərf etdiyin vaxtı başqa şeyə sərf et!'); 
echo '<div id="leftmenu">
	<a href="cabinet">Şəxsi kabinetim</a>
	<a href="deactivpro">Deaktiv profillər</a>
	<a href="rejects">İmtina sifarişlər</a>
	<a href="concatenatin">Birləşdirmə</a>
	<a href="notifs">Bildirişlər</a>
	<a href="users">İstifadəçi</a>';
	if($_SESSION['bank_department'] == 'system' || $_SESSION['users_role'] == 'user'){ echo'
	<a href="contracts">Müqavilə</a>';}
	if($_SESSION['users_role'] == 'admin'){ echo'
	<a href="mainbranches">Filiallar</a>';}
echo '</div>';
?>