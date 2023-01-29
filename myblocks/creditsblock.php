<?php defined('mcsystem') or die('Cəhdin yaxşı idi, sərf etdiyin vaxtı başqa şeyə sərf et!'); ?>
<div class="row row-cols-1">
    <div class="col-md-12 text-center">
	<?php
		$res_credits = mysqli_query($connect_link,"SELECT * FROM crdt_category");
		if(mysqli_num_rows($res_credits) > 0){
			$row_credits = mysqli_fetch_assoc($res_credits);
			do{ echo'
		<div class="productsarea">
			<h4>'.$row_credits["product_name"].' ('.$row_credits["product_type"].')</h4>
			<div class="product_headers">
				<div class="c_amount">Məbləğ</div>
				<div class="c_currency">Valyuta</div>
				<div class="c_period">Müddət</div>
				<div class="c_percentage">Faiz</div>
			</div>
			<div class="product_infos">
				<div class="c_amount">'.$row_credits["amount_limit"].'</div>
				<div class="c_currency">'.$row_credits["currency"].'</div>
				<div class="c_period">'.$row_credits["period"].' ay</div>
				<div class="c_percentage">'.$row_credits["percentage"].' %</div>
			</div>
	<button type="button" class="btn btn-secondary w-100" data-toggle="collapse" data-target="#openclose_'.$row_credits["id"].'">Ətraflı məlumatı göstər/gizlət</button>
		<div id="openclose_'.$row_credits["id"].'" class="collapse">
			<div class="product_target">
				<h5>Kreditin hədəfləri</h5>
				<div><span>Kredit məhsullarımız bu şəxslərə təklif edilir - </span>'.$row_credits["target_group"].'</div>
				<div><span>Vətəndaşlıq - </span>Yalnız '.$row_credits["target_citizen"].'</div>
				<div><span>Yaş məhdudiyyəti - </span>'.$row_credits["target_age"].'</div>
				<div><span>Bu regionda yaşayanlar kredit məhsullarımızdan yararlana bilər - </span>'.$row_credits["region"].'</div>
				<div><span>Kreditləri buradan əldə etmək olar - </span>'.$row_credits["branches"].'</div>
			</div>
			<div class="product_target">
				<h5>Kreditdən istifadə və verilmə şərtləri</h5>
				<div><span>Faiz borcunun ödənilmə dövrü - </span>'.$row_credits["payment_period"].' aydan bir</div>
				<div><span>Kredit bu formada təklif edilir - </span>'.$row_credits["produce_form"].'</div>
				<div><span>Kreditin ödəniş forması - </span>'.$row_credits["payment_form"].'</div>
			</div>
			<div class="product_target">
				<h5>Bank komisyon haqları</h5>
				<div><span>Kreditin verilməsinə görə - </span>'.$row_credits["credit_com"].' %</div>
				<div><span>Vəsaitin nəğdləşdirilməsinə görə - </span>'.$row_credits["get_com"].' %</div>
				<div><span>Hesab açılmasına görə - </span>'.$row_credits["account_com"].' (kreditlə eyni valyutada)</div>
			</div>
			<div class="product_target">
				<h5>Əldə edə biləcəyiniz güzəştlər</h5>
				<div><span>Əsas məbləğin ödənilməsində - </span>'.$row_credits["maindebt_discount"].'</div>
				<div><span>Faizlərin ödənilməsində - </span>'.$row_credits["percdebt_discount"].'</div>
			</div>
			<div class="product_target">
				<h5>Təminat (girov) barədə</h5>
				<div><span>Təminatın forması - </span>'.$row_credits["pledge_form"].'</div>
				<div><span>Minimum şərtlər - </span>'.$row_credits["min_clause"].'</div>
				<div><span>Girovun kreditə nisbəti - </span>'.$row_credits["coefficent"].'</div>
			</div>
			<div class="product_target">
				<h5>Tələb olunan sənədlər və əlavə qeydlər</h5>
				<div><span>Tələb olunan ilkin sənədlər - </span>'.$row_credits["documents"].'</div>
				<div><span>Məhsul barədə əlavə qeydlər - </span>'.$row_credits["notes"].'</div>
			</div>
		</div>
		</div>';
			   }
			while($row_credits = mysqli_fetch_assoc($res_credits));
		}
	?>
	</div>
</div>