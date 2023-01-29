<?php defined('mcsystem') or die('Cəhdin yaxşı idi, sərf etdiyin vaxtı başqa şeyə sərf et!'); ?>
<div class="row row-cols-1">
    <div class="col-md-12 text-center">
		<div class="border border-dark mt-3">
			<h3>Aktiv kredit sifarişləriniz</h3><br>
			<p><i>- Burada sizin ən son daxil etdiyiniz 3 kredit sifarişi toplanacaq.</i></p>
			<p><i>- Daxil edəcəyiniz kredit sifarişlərində səhv ola biləcəyini güman edib son dəfə yoxlamağınız üçün şərait yaradılır.</i></p>
			<p><i>- Yoxlamaq üçün aşağıda hər sifarişin qarşısında görünəcək YOXLA ssılkasına girməyiniz vacibdir.</i></p>
			<p><i>- Açılacaq səhifədə sifarişi son dəfə yoxladıqdan sonra Təsdiq et düyməsini sıxıb sifarişi təsdiqləyəcəksiniz.</i></p>
			<p><i>- Unutmayın ki, yükləmələr səhifəsindən maliyyə sənədlərinizi göndərdikdən sonra kredit sifarişinizi təsdiqləməlisiniz.</i></p>
	<?php
	$orders_result = mysqli_query($connect_link,"SELECT * FROM cre_orders WHERE client='{$_SESSION['auth_login']}' AND order_status='aktiv' AND client_decision IS NULL ORDER BY id DESC");
	if(mysqli_num_rows($orders_result) > 0){
		$orders_row = mysqli_fetch_assoc($orders_result);
		do{ echo '
			<div class="border border-dark m-1 bg-success text-white">'.date_format(date_create($orders_row["app_datetime"]),"d-m-Y H:i:s").' tarixli '.$orders_row["cre_amount"].' '.$orders_row["cre_currency"].' -lik kredit sifarişini <a class="verifylink" href="verifying?id='.$orders_row["id"].'">YOXLA</a></div>';
		}
		while($orders_row = mysqli_fetch_assoc($orders_result));
	}
	else{
		echo '<div class="bg-dark text-white">Sizin aktiv kredit sifarişiniz yoxdur</div>';
	}
	?>
		</div>
	</div>
</div>