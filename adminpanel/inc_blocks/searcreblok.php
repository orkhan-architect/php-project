<?php 
defined('mcsystem') or die('Cəhdin yaxşı idi, sərf etdiyin vaxtı başqa şeyə sərf et!');

if(strlen($search) >= 3 && strlen($search) < 25){
	$num = 10; // Neçə ədəd axtarış nəticəsi göstərilməli oluduğunu bildirir.
    $page = (int)$_GET['page'];
	$count = mysqli_query($connect_link,"SELECT COUNT(*) FROM cre_data WHERE $criteria LIKE '%$search%' AND verified='yes'");
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
	$credres = mysqli_query($connect_link,"SELECT * FROM cre_data WHERE $criteria LIKE '%$search%' AND verified='yes' ORDER BY credit_startdate $query_start_num");
	if(mysqli_num_rows($credres)>0){
		$credit_row = mysqli_fetch_assoc($credres);
		echo '	
<div id="midblock">
	<p>Aktiv kreditlər</p>
	<div class="basliqxanalar" id="clientid">Müştəri ID</div>
	<div class="basliqxanalar" id="applydate">Yığılma</div>
	<div class="basliqxanalar" id="verifydate">Təsdiq</div>
	<div class="basliqxanalar" id="credit_mains">Kredit</div>
	<div class="basliqxanalar" id="credit_percentage">Faiz</div>
	<div class="basliqxanalar" id="credit_period">Müddət</div>
	<div class="basliqxanalar" id="applydate">Başlama</div>
	<div class="basliqxanalar" id="verifydate">Bitmə</div>
	<div class="basliqxanalar" id="credit_production">Kredit məhsulu</div>
	<br>';
		do{echo '
	<br>
	<div id="clientid" title="müştərinin FİN kodu və ya VÖENi"><a href="view_credit?id='.$credit_row["id"].'">'.$credit_row["client"].'</a></div>
	<div id="applydate" title="əməliyyatçının sistemə yığdığı tarix">'.date_format(date_create($credit_row["ofcer_docdate"]),"d-m-Y").'</div>
	<div id="verifydate" title="inzibatçı-rəhbərin təsdiq tarixi">'.date_format(date_create($credit_row["verif_docdate"]),"d-m-Y").'</div>
	<div id="credit_mains" title="rəsmiləşmiş kredit">'.$credit_row["credit_amount"].' '.$credit_row["credit_currency"].'</div>
	<div id="credit_percentage" title="illik faiz dərəcəsi">'.$credit_row["credit_percentage"].' %</div>
	<div id="credit_period" title="ilkin təyin edilmiş müddət">'.$credit_row["credit_period"].' ay</div>
	<div id="applydate" title="kreditin qüvvəyə mindiyi tarix">'.date_format(date_create($credit_row["credit_startdate"]),"d-m-Y").'</div>
	<div id="verifydate" title="kreditin plan üzrə bitmə tarixi">'.date_format(date_create($credit_row["credit_enddate"]),"d-m-Y").'</div>
	<div id="credit_production" title="verilmiş kredit məhsulu">'.$credit_row["credit_product"].'</div>
	<br>';
		}
		while($credit_row = mysqli_fetch_assoc($credres));
	echo '
</div>';}
	
if($page != 1){ $pstr_prev = '<li><a class="pstr-prev" href="searchcre?q='.$search.'&search_place='.$criteria.'&page='.($page - 1).'">&lt;</a></li>';}
if($page != $total) $pstr_next = '<li><a class="pstr-next" href="searchcre?q='.$search.'&search_place='.$criteria.'&page='.($page + 1).'">&gt;</a></li>';

if($page - 5 > 0) $page5left = '<li><a href="searchcre?q='.$search.'&search_place='.$criteria.'&page='.($page - 5).'">'.($page - 5).'</a></li>';
if($page - 4 > 0) $page4left = '<li><a href="searchcre?q='.$search.'&search_place='.$criteria.'&page='.($page - 4).'">'.($page - 4).'</a></li>';
if($page - 3 > 0) $page3left = '<li><a href="searchcre?q='.$search.'&search_place='.$criteria.'&page='.($page - 3).'">'.($page - 3).'</a></li>';
if($page - 2 > 0) $page2left = '<li><a href="searchcre?q='.$search.'&search_place='.$criteria.'&page='.($page - 2).'">'.($page - 2).'</a></li>';
if($page - 1 > 0) $page1left = '<li><a href="searchcre?q='.$search.'&search_place='.$criteria.'&page='.($page - 1).'">'.($page - 1).'</a></li>';

if($page + 5 <= $total) $page5right = '<li><a href="searchcre?q='.$search.'&search_place='.$criteria.'&page='.($page + 5).'">'.($page + 5).'</a></li>';
if($page + 4 <= $total) $page4right = '<li><a href="searchcre?q='.$search.'&search_place='.$criteria.'&page='.($page + 4).'">'.($page + 4).'</a></li>';
if($page + 3 <= $total) $page3right = '<li><a href="searchcre?q='.$search.'&search_place='.$criteria.'&page='.($page + 3).'">'.($page + 3).'</a></li>';
if($page + 2 <= $total) $page2right = '<li><a href="searchcre?q='.$search.'&search_place='.$criteria.'&page='.($page + 2).'">'.($page + 2).'</a></li>';
if($page + 1 <= $total) $page1right = '<li><a href="searchcre?q='.$search.'&search_place='.$criteria.'&page='.($page + 1).'">'.($page + 1).'</a></li>';

if($page+5 < $total){
    $strtotal = '<li><p class="nav-point">...</p></li><li><a href="searchcre?q='.$search.'&search_place='.$criteria.'&page='.$total.'">'.$total.'</a></li>';
}
else{
    $strtotal = ""; 
}
if($total > 1){
    echo '<div class="pstrnav"><ul>';
    echo $pstr_prev.$page5left.$page4left.$page3left.$page2left.$page1left."<li><a class='pstr-active' href='searchcre?q='.$search.'&search_place='.$criteria.'&page=".$page."'>".$page."</a></li>".$page1right.$page2right.$page3right.$page4right.$page5right.$strtotal.$pstr_next;
    echo '</ul></div>';}
}
	
	else{echo "<div id='midblock'><p>Axtarışla bağlı heç bir nəticə tapılmadı!</p>";}
}

else{
	echo "<div id='midblock'><p>Axtarılan hissə 3-25 simvol aralığı ola bilər!</p>";
}
?>