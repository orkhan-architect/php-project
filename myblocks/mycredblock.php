<?php defined('mcsystem') or die('Cəhdin yaxşı idi, sərf etdiyin vaxtı başqa şeyə sərf et!'); ?>
<div class="row row-cols-1">
    <div class="col-md-12 text-center">
		<?php 
		$credata_result = mysqli_query($connect_link,"SELECT * FROM cre_data WHERE client='{$_SESSION['auth_login']}' AND unical_credid IS NOT NULL AND credit_status='aktiv'");
			if(mysqli_num_rows($credata_result) > 0){
				$credata_row = mysqli_fetch_assoc($credata_result);
				do{ echo '
		<div class="border border-dark mt-3">
		<p style="margin-top: 5px;">'.$credata_row["unical_credid"].'<p>
		<div id="leftblock">
			<div class="border border-dark m-1 bg-primary text-white">Kredit məhsulu</div>
			<div title="kredit məhsulu">
			'.$credata_row["credit_product"].'
			</div>
			<div class="border border-dark m-1 bg-primary text-white">Kreditin statusu</div>
			<div title="Kreditin statusu">
			'.$credata_row["credit_status"].'
			</div>
			<div class="border border-dark m-1 bg-primary text-white">Valyutası</div>
			<div title="kreditin valyutası">
			'.$credata_row["credit_currency"].'
			</div>
			<div class="border border-dark m-1 bg-primary text-white">Məbləği</div>
			<div title="Kreditin məbləği">
			'.$credata_row["credit_amount"].'
			</div>
			<div class="border border-dark m-1 bg-primary text-white">Müddəti</div>
			<div title="Kreditin müddəti">
			'.$credata_row["credit_period"].' ay
			</div>
			<div class="border border-dark m-1 bg-primary text-white">İllik faizi</div>
			<div title="Kreditin illik faiz dərəcəsi">
			'.$credata_row["credit_percentage"].'%
			</div>
			<div class="border border-dark m-1 bg-primary text-white">Cərimə faizi</div>
			<div title="Kreditin cərimə faizi dərəcəsi">
			'.$credata_row["penalty_percentage"].'%
			</div>
			<div class="border border-dark m-1 bg-primary text-white">Başlama tarixi</div>
			<div title="Kreditin verildiyi tarix">
			'.$credata_row["credit_startdate"].'
			</div>
			<div class="border border-dark m-1 bg-primary text-white">Bitmə tarixi</div>
			<div title="Son ödəniş tarixi">
			'.$credata_row["credit_enddate"].'
			</div>
		</div>
		<div id="rightblock">
			<div class="border border-dark m-1 bg-primary text-white">Aylıq ödəniş</div>
			<div title="Standart aylıq ödəniş">
			'.$credata_row["monthly_payment"].'
			</div>
			<div class="border border-dark m-1 bg-primary text-white">Ssudanın qalığı</div>
			<div title="əsas məbləğin qalıq borcu">
			'.$credata_row["reminder_maindebt"].'
			</div>
			<div class="border border-dark m-1 bg-primary text-white">Normal faizin qalığı</div>
			<div title="normal faizin qalıq borcu">
			'.$credata_row["reminder_percdebt"].'
			</div>
			<div class="border border-dark m-1 bg-danger text-white">Ödənilməmiş ssuda</div>
			<div title="Ödənilməmiş əsas məbləğ">
			'.$credata_row["delayed_maindebt"].'
			</div>
			<div class="border border-dark m-1 bg-danger text-white">Ödənilməmiş faiz</div>
			<div title="Ödənilməmiş faiz məbləği">
			'.$credata_row["delayed_percdebt"].'
			</div>
			<div class="border border-dark m-1 bg-danger text-white">Ödənilməmiş cərimə</div>
			<div title="Ödənilməmiş cərimə məbləği">
			'.$credata_row["delayed_pendebt"].'
			</div>
			<div class="border border-dark m-1 bg-success text-white">Ödənilmiş ssuda</div>
			<div title="bugünə qədər ödənilmiş əsas məbləğ">
			'.$credata_row["paid_maindebt"].'
			</div>
			<div class="border border-dark m-1 bg-success text-white">Ödənilmiş faiz</div>
			<div title="bugünə qədər ödənilmiş faiz məbləği">
			'.$credata_row["paid_percdebt"].'
			</div>
			<div class="border border-dark m-1 bg-success text-white">Ödənilmiş cərimə</div>
			<div title="bugünə qədər ödənilmiş cərimə məbləği">
			'.$credata_row["paid_pendebt"].'
			</div>
		</div>
		</div>';
				}
				while($credata_row = mysqli_fetch_assoc($credata_result));
			}
		?>
	</div>
</div>