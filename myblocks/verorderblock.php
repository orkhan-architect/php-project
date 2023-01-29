<?php defined('mcsystem') or die('Cəhdin yaxşı idi, sərf etdiyin vaxtı başqa şeyə sərf et!'); ?>
<div class="row row-cols-1">
    <div class="col-md-12 text-center">
		<div class="border border-dark mt-3">
			<p id="reg_message"></p>
			<h3>Təsdiqlədiyiniz kredit sifarişlər</h3><br>
			<p><i>- Burada sizin ən son yoxlayıb təsdiqlədiyiniz 3 kredit sifarişi toplanacaq.</i></p>
			<p><i>- Bir kredit sifarişinin baxılma müddəti məhsul növündən və işin gedişatından asılı olaraq 1-10 gün arası ola bilər.</i></p>
			<p><i>- Əgər bu müddət ərzində müəyyən səbəblərdən kredit sifarişindən imtina etsəniz və ya kredit əməkdaşları tərəfindən gələn rəy sizi qane etməsə, aşağıdakı kredit sifarişinin qarşısında İMTİNA ET ssılkasına daxil ola bilərsiniz.</i></p>
			<p><i>- Əgər imtina edəcəksinizsə, imtinanın səbəbini açılacaq səhifədə qeyd etməyi unutmayın.</i></p>

	<?php
	$verorders_result = mysqli_query($connect_link,"SELECT * FROM cre_orders WHERE client='{$_SESSION['auth_login']}' AND order_status='aktiv' AND client_decision='təsdiq' ORDER BY id DESC");
	if(mysqli_num_rows($verorders_result) > 0){
		$verorders_row = mysqli_fetch_assoc($verorders_result);
		do{ echo '
			<div class="border border-dark m-1 bg-success text-white">'.date_format(date_create($verorders_row["app_datetime"]),"d-m-Y H:i:s").' tarixli '.$verorders_row["cre_amount"].' '.$verorders_row["cre_currency"].' -lik kredit sifarişini <a class="verifylink" href="verifying?id='.$verorders_row["id"].'">İMTİNA ET</a></div>';
		}
		while($verorders_row = mysqli_fetch_assoc($verorders_result));
	}
	else{
		echo '<div class="bg-dark text-white">Sizin təsdiqlənmiş kredit sifarişiniz yoxdur</div>';
	}
	?>
		</div>
	</div>
</div>