<?php defined('mcsystem') or die('Cəhdin yaxşı idi, sərf etdiyin vaxtı başqa şeyə sərf et!'); 
echo '<div id="upmenublock">
	<a href="index">ANASƏHİFƏ</a>';
if($_SESSION['customer_view'] == '1' || $_SESSION['bank_department'] == 'assembler'){echo '
	<a href="profiles">PROFİLLƏR</a>';}
if($_SESSION['order_view'] == "1" || $_SESSION['bank_department'] == "sales" || $_SESSION['bank_department'] == "assembler"){echo '
	<a href="orders">SİFARİŞLƏR</a>';}
echo '<a href="credit">KREDİTLƏR</a>
	<a href="collets">GİROVLAR</a>
</div>
<div id="entryblock">
	<a class="daxil" href="?logout">Çıxış</a>
</div>
<div id="logopl">
	T.O.M. Kredit İdarəetmə sistemi
</div>';
?>