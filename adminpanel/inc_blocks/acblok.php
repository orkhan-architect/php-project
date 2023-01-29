<?php 
defined('mcsystem') or die('Cəhdin yaxşı idi, sərf etdiyin vaxtı başqa şeyə sərf et!');
if($_SESSION['users_role'] == 'user' || $_SESSION['bank_department'] == "system"){
	
	if($_SESSION['users_role'] == 'user'){	
		$chosen_client = "AND cho_creditor='{$_SESSION['auth_admin_login']}'";	
	}
?>
<form method="post">
<div id="yigilma_sahesi">
	<?php 
	if($_SESSION['msg']){
		echo $_SESSION['msg'];
		unset($_SESSION['msg']);
	}
	?>
	<p>Sifarişə uyğun kredit yığılması</p>
	<div>
		<select name="customer_select">
			<option value="" selected disabled>müştərini seç</option>
<?php 
$customer_result = mysqli_query($connect_link,"SELECT client FROM cre_orders WHERE order_status='təsdiq' $chosen_client");
if(mysqli_num_rows($customer_result)>0){
	$customer_row = mysqli_fetch_assoc($customer_result);
	do{ 
		$cusname_result = mysqli_query($connect_link,"SELECT client FROM cstmr_data WHERE login='{$customer_row['client']}'");
		$cusname_row = mysqli_fetch_assoc($cusname_result);
		echo '<option value="'.$customer_row['client'].'"> '.$cusname_row['client'].'</option>';}
	while($customer_row = mysqli_fetch_assoc($customer_result));
}
?>
		</select>
	</div>
	<div>
		<select name="order_select">
			<option value="" selected disabled>sifarişi seç</option>
<?php 
$orders_result = mysqli_query($connect_link,"SELECT * FROM cre_orders WHERE order_status='təsdiq' $chosen_client");
if(mysqli_num_rows($orders_result)>0){
	$orders_row = mysqli_fetch_assoc($orders_result);
	do{ echo '
		<option value="'.$orders_row['id'].'">'.$orders_row['id'].' - '.$orders_row['man_verifiedamount'].' '.$orders_row['man_verifiedcurrency'].' '.$orders_row['man_verifiedperiod'].' aylıq</option>';}
	while($orders_row = mysqli_fetch_assoc($orders_result));
}
?>
		</select>
	</div>
	<div>
		<select name="product_select">
			<option value="" selected disabled>kredit məhsulu seç</option>
<?php 
$categories_result = mysqli_query($connect_link,"SELECT product_name FROM crdt_category");
if(mysqli_num_rows($categories_result)>0){
	$categories_row = mysqli_fetch_assoc($categories_result);
	do{ echo '
		<option value="'.$categories_row['product_name'].'">'.$categories_row['product_name'].'</option>';}
	while($categories_row = mysqli_fetch_assoc($categories_result));
}
?>
		</select>
	</div>
	<div>
		<input type="number" id="credamo" name="credit_sum" placeholder="məbləğ">
	</div>
	<div>
		<select name="currency_select">
			<option value="" selected disabled>valyutanı seç</option>
			<option value="AZN">Azərb. manatı</option>
			<option value="USD">ABŞ dolları</option>
			<option value="EUR">Avro</option>
		</select>
	</div>
	<br><br>
	<div>
		<input type="number" id="credper" name="cre_period" placeholder="müddət(ay)">
	</div>
	<div>
		<input type="number" id="credperc" name="cre_percentage" placeholder="illik faiz">
	</div>
	<div>
		<input type="number" id="credfypd" name="cre_fypd" placeholder="FİFD">
	</div>
	<div>
		<input type="number" id="penalperc" name="penal_percentage" placeholder="cərimə faizi">
	</div>
	<div>
		<input type="number" id="monthpay" name="monthlypay" placeholder="aylıq ödəniş">
	</div>
	<div>
		<input type="number" id="credti" name="dti_coef" placeholder="BGN əmsalı">
	</div>
	<div>
		<select name="rating_select">
			<option value="" selected disabled>reytinq seç</option>
			<option value="A">A</option>
			<option value="B">B</option>
			<option value="C">C</option>
			<option value="D">D</option>
		</select>
	</div>
	<div>
		<select name="contract_select">
			<option value="" selected disabled>müqavilə tipi seç</option>
			<option value="birdəfəlik">birdəfəlik</option>
			<option value="bərpaolunmayan">bərpaolunmayan xətt</option>
			<option value="bərpaolunan">bərpaolunan xətt</option>
			<option value="overdraft">overdraft</option>
			<option value="plastik">plastik kart</option>
		</select>
	</div>
	<div>
		<select name="source_select">
			<option value="" selected disabled>mənbə seç</option>
			<option value="bank">Bankın vəsaiti</option>
			<option value="fond">Fondun vəsaiti</option>
		</select>
	</div>
	<br><br>
	<div>
		<input type="number" id="credcom" name="comission" placeholder="komisyon">
	</div>
	<div>
		<input type="text" id="credextra" name="discont" placeholder="güzəşt">
	</div>
	<div>
		<input type="submit" name="credit_submit" id="form_submit" value="Kredit ver">
	</div>
</div>
</form>
<?php 
}
else{
	echo 'Hörmətli istifadəçi. Sənə aid olmayan səhifələrə cəhd edib girmə!';
};
?>