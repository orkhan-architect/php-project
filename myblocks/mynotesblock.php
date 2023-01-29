<?php defined('mcsystem') or die('Cəhdin yaxşı idi, sərf etdiyin vaxtı başqa şeyə sərf et!'); ?>
<div class="row row-cols-1">
    <div class="col-md-12 text-center">
	<?php 
	if($_SESSION['msg']){
		echo $_SESSION['msg'];
		unset($_SESSION['msg']);
	};
	$num = 10; // Neçə ədəd bildiriş göstərilməli oluduğunu bildirir.
    $page = (int)$_GET['page'];
	$count = mysqli_query($connect_link,"SELECT COUNT(*) FROM notification_data WHERE client='{$_SESSION['auth_login']}' AND verifydate IS NOT NULL");
    $temp = mysqli_fetch_array($count,MYSQLI_NUM);
	if($temp[0] > 0){  
		$tempcount = $temp[0];
		$total = (($tempcount - 1) / $num) + 1;
		$total =  intval($total);
		$page = intval($page);
		if(empty($page) or $page < 0){$page = 1;}       
		if($page > $total){$page = $total;} 
		$start = $page * $num - $num;
		$query_start_num = "LIMIT $start, $num";
	};
		
	$notedata_result = mysqli_query($connect_link,"SELECT * FROM notification_data WHERE client='{$_SESSION['auth_login']}' AND verifydate IS NOT NULL ORDER BY id DESC $query_start_num");
	if(mysqli_num_rows($notedata_result) > 0){
		$notedata_row = mysqli_fetch_assoc($notedata_result);
		do{ echo '
		<div class="border border-dark mt-3">
			<div class="border border-dark m-1 bg-success text-white">'.$notedata_row["note_type"].'</div>
			<div title="bildirişin göndərildiyi tarix">'.date_format(date_create($notedata_row["note_date"]),"d-m-Y H:i:s").'</div>
			<div>'.$notedata_row["note_text"].'</div>
			<div>'.$notedata_row["htmlcoding"].'</div>
		</div>';
		}
		while($notedata_row = mysqli_fetch_assoc($notedata_result));
	}
	echo  "<br>";	
if($page != 1){ $pstr_prev = '<div><a class="pstr-prev" href="notifications?page='.($page - 1).'">&lt;</a></div>';}
if($page != $total) $pstr_next = '<div><a class="pstr-next" href="notifications?page='.($page + 1).'">&gt;</a></div>';

if($page - 5 > 0) $page5left = '<div><a href="notifications?page='.($page - 5).'">'.($page - 5).'</a></div>';
if($page - 4 > 0) $page4left = '<div><a href="notifications?page='.($page - 4).'">'.($page - 4).'</a></div>';
if($page - 3 > 0) $page3left = '<div><a href="notifications?page='.($page - 3).'">'.($page - 3).'</a></div>';
if($page - 2 > 0) $page2left = '<div><a href="notifications?page='.($page - 2).'">'.($page - 2).'</a></div>';
if($page - 1 > 0) $page1left = '<div><a href="notifications?page='.($page - 1).'">'.($page - 1).'</a></div>';

if($page + 5 <= $total) $page5right = '<div><a href="notifications?page='.($page + 5).'">'.($page + 5).'</a></div>';
if($page + 4 <= $total) $page4right = '<div><a href="notifications?page='.($page + 4).'">'.($page + 4).'</a></div>';
if($page + 3 <= $total) $page3right = '<div><a href="notifications?page='.($page + 3).'">'.($page + 3).'</a></div>';
if($page + 2 <= $total) $page2right = '<div><a href="notifications?page='.($page + 2).'">'.($page + 2).'</a></div>';
if($page + 1 <= $total) $page1right = '<div><a href="notifications?page='.($page + 1).'">'.($page + 1).'</a></div>';

if($page+5 < $total){
    $strtotal = '<div><div class="nav-point">...</div></div><div><a href="notifications?page='.$total.'">'.$total.'</a></div>';
}
else{
    $strtotal = ""; 
}
if($total > 1){
    echo '<div class="pstrnav">';
    echo $pstr_prev.$page5left.$page4left.$page3left.$page2left.$page1left."<div><a class='pstr-active' href='notifications?page=".$page."'>".$page."</a></div>".$page1right.$page2right.$page3right.$page4right.$page5right.$strtotal.$pstr_next;
    echo '</div>';
}
	?>
	</div>
</div>