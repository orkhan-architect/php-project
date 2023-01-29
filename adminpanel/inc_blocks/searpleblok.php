<?php 
defined('mcsystem') or die('Cəhdin yaxşı idi, sərf etdiyin vaxtı başqa şeyə sərf et!');

if(strlen($search) >= 3 && strlen($search) < 25){
	$num = 1; // Neçə ədəd axtarış nəticəsi göstərilməli oluduğunu bildirir.
    $page = (int)$_GET['page'];
	$count = mysqli_query($connect_link,"SELECT COUNT(*) FROM pledge_data WHERE $criteria LIKE '%$search%' AND manager_decision='təsdiq'");
    $temp = mysqli_fetch_array($count,MYSQLI_NUM);
	if($temp[0] > 0){  
		$tempcount = $temp[0];
		$total = (($tempcount - 1) / $num) + 1;
		$total =  intval($total);
		$page = intval($page);
		if(empty($page) or $page < 0){$page = 1;}       
		if($page > $total){$page = $total;} 
		$start = $page * $num - $num;
		$query_start_num = " LIMIT $start, $num";
	};
	if($temp[0] > 0){
	$pledres = mysqli_query($connect_link,"SELECT * FROM pledge_data WHERE $criteria LIKE '%$search%' AND manager_decision='təsdiq' ORDER BY manager_chdate $query_start_num");
	if(mysqli_num_rows($pledres)>0){
	$row_pledge = mysqli_fetch_assoc($pledres);
	echo '
<div id="midblock">
	<p>Mövcud girovlar</p>
	<div id="typledge" class="basliqxanalar">Girovun növü</div>
	<div id="applydate" class="basliqxanalar">Yığılma</div>
	<div id="applydate" class="basliqxanalar">Təsdiq</div>
	<div id="personalid" class="basliqxanalar">Girovqoyan ID</div>
	<div id="clientnsp" class="basliqxanalar">Girovqoyan</div>
	<div id="pledamount" class="basliqxanalar">Məbləği</div>
	<div id="pledcurrency" class="basliqxanalar">Val</div>
	<br>
	';
	do{ echo '
	<br>
	<div id="typledge" title="girovun növü"><a href="view_pledge?id='.$row_pledge["id"].'">'.$row_pledge["pledge_name"].'</a></div>
	<div id="applydate" title="yığılma tarixi">'.date_format(date_create($row_pledge["agent_chdate"]),"d-m-Y").'</div>
	<div id="applydate" title="təsdiqlənmə tarixi">'.date_format(date_create($row_pledge["manager_chdate"]),"d-m-Y").'</div>
	<div id="personalid" title="FİNKOD (VÖEN)">'.$row_pledge["fincode_taxes"].'</div>
	<div id="clientnsp" title="Girovqoyan ASA (Şirkətin adı)">'.$row_pledge["mortgagor"].'</div>
	<div id="pledamount" title="giorvun məbləği">'.$row_pledge["pledge_cost"].'</div>
	<div id="pledcurrency" title="girovun valyutası">'.$row_pledge["pledge_currency"].'</div>
	<br>';
	}
	while($row_pledge = mysqli_fetch_assoc($pledres));
	echo '
</div>';}
	
if($page != 1){ $pstr_prev = '<li><a class="pstr-prev" href="searchple?q='.$search.'&search_place='.$criteria.'&page='.($page - 1).'">&lt;</a></li>';}
if($page != $total) $pstr_next = '<li><a class="pstr-next" href="searchple?q='.$search.'&search_place='.$criteria.'&page='.($page + 1).'">&gt;</a></li>';

if($page - 5 > 0) $page5left = '<li><a href="searchple?q='.$search.'&search_place='.$criteria.'&page='.($page - 5).'">'.($page - 5).'</a></li>';
if($page - 4 > 0) $page4left = '<li><a href="searchple?q='.$search.'&search_place='.$criteria.'&page='.($page - 4).'">'.($page - 4).'</a></li>';
if($page - 3 > 0) $page3left = '<li><a href="searchple?q='.$search.'&search_place='.$criteria.'&page='.($page - 3).'">'.($page - 3).'</a></li>';
if($page - 2 > 0) $page2left = '<li><a href="searchple?q='.$search.'&search_place='.$criteria.'&page='.($page - 2).'">'.($page - 2).'</a></li>';
if($page - 1 > 0) $page1left = '<li><a href="searchple?q='.$search.'&search_place='.$criteria.'&page='.($page - 1).'">'.($page - 1).'</a></li>';

if($page + 5 <= $total) $page5right = '<li><a href="searchple?q='.$search.'&search_place='.$criteria.'&page='.($page + 5).'">'.($page + 5).'</a></li>';
if($page + 4 <= $total) $page4right = '<li><a href="searchple?q='.$search.'&search_place='.$criteria.'&page='.($page + 4).'">'.($page + 4).'</a></li>';
if($page + 3 <= $total) $page3right = '<li><a href="searchple?q='.$search.'&search_place='.$criteria.'&page='.($page + 3).'">'.($page + 3).'</a></li>';
if($page + 2 <= $total) $page2right = '<li><a href="searchple?q='.$search.'&search_place='.$criteria.'&page='.($page + 2).'">'.($page + 2).'</a></li>';
if($page + 1 <= $total) $page1right = '<li><a href="searchple?q='.$search.'&search_place='.$criteria.'&page='.($page + 1).'">'.($page + 1).'</a></li>';

if($page+5 < $total){
    $strtotal = '<li><p class="nav-point">...</p></li><li><a href="searchple?q='.$search.'&search_place='.$criteria.'&page='.$total.'">'.$total.'</a></li>';
}
else{
    $strtotal = ""; 
}
if($total > 1){
    echo '<div class="pstrnav"><ul>';
    echo $pstr_prev.$page5left.$page4left.$page3left.$page2left.$page1left."<li><a class='pstr-active' href='searchple?q='.$search.'&search_place='.$criteria.'&page=".$page."'>".$page."</a></li>".$page1right.$page2right.$page3right.$page4right.$page5right.$strtotal.$pstr_next;
    echo '</ul></div>';}
}
	
	else{echo "<div id='midblock'><p>Axtarışla bağlı heç bir nəticə tapılmadı!</p>";}
}

else{
	echo "<div id='midblock'><p>Axtarılan hissə 3-25 simvol aralığı ola bilər!</p>";
}
?>