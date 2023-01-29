<?php 
defined('mcsystem') or die('Cəhdin yaxşı idi, sərf etdiyin vaxtı başqa şeyə sərf et!');

if($_SESSION['msg']){
		echo $_SESSION['msg'];
		unset($_SESSION['msg']);
}

if($_SESSION['users_role'] == 'manager'){
	$verfier = $_SESSION['auth_admin_login'];
	$forverifier = "AND credit_verifier='$verfier'";
}

if($_SESSION['users_role'] == 'user'){
	$oficer = $_SESSION['auth_admin_login'];
	$forofficer = "AND credit_officer='$oficer'";
	$chosen_client = "AND cho_creditor='{$_SESSION['auth_admin_login']}'";
}

$credit_result = mysqli_query($connect_link,"SELECT * FROM cre_data WHERE id='$id' $forofficer $forverifier");
if(mysqli_num_rows($credit_result)>0){
	$credit_row = mysqli_fetch_assoc($credit_result);
	
	if($_SESSION['credit_edit'] == '1'){echo '
<form method="post">
	<div id="yigilma_sahesi">';
										
	if($_SESSION['users_role'] == 'manager' || $_SESSION['bank_department'] == "system"){
		if(!isset($credit_row['verif_docdate'])){ echo '
		<p>Menecerin təsdiqi</p>
		<div>
			<input type="date" id="datebox" name="startdate" title="kreditin verilmə tarixi" value='.$credit_row['credit_startdate'].'>
		</div>
		<div>
			<input type="date" id="datebox" name="endate" title="kreditin bitmə tarixi" value='.$credit_row['credit_enddate'].'>
		</div>
		<div>
			<input type="text" id="unicality" name="unicalcred" title="kreditin unikal ID-i" value='.$credit_row['unical_credid'].'>
		</div>
		<div>
			<input type="number" id="payday" name="payinday" title="kreditin ödəniş günü" value='.$credit_row['payment_day'].'>
		</div>
		<div>
			<input type="submit" name="verifiercre_submit" id="form_submit" value="Təsdiqlə">
		</div>';}
	}
	
	if($_SESSION['users_role'] == 'user' || $_SESSION['bank_department'] == "system"){		
		if(!isset($credit_row['ofcer_docdate'])){
			if($credit_row["credit_currency"] == "AZN"){$aznsel = "selected";}
			if($credit_row["credit_currency"] == "EUR"){$eursel = "selected";}
			if($credit_row["credit_currency"] == "USD"){$usdsel = "selected";}
		
			if($credit_row["rate"] == "A"){$asel = "selected";}
			if($credit_row["rate"] == "B"){$bsel = "selected";}
			if($credit_row["rate"] == "C"){$csel = "selected";}
			if($credit_row["rate"] == "D"){$dsel = "selected";}
		
			if($credit_row["type_credit"] == "birdəfəlik"){$bksel = "selected";}
			if($credit_row["type_credit"] == "bərpaolunmayan"){$bomsel = "selected";}
			if($credit_row["type_credit"] == "bərpaolunan"){$bolsel = "selected";}
			if($credit_row["type_credit"] == "overdraft"){$ovsel = "selected";}
			if($credit_row["type_credit"] == "plastik"){$pcasel = "selected";}
		
			if($credit_row["source_fund"] == "bank"){$bankfsel = "selected";}
			if($credit_row["source_fund"] == "fond"){$fondfsel = "selected";}
			
		echo '
		<p>Agentin redaktəsi</p>
		<div>
		<select name="customer_select">
			<option value="" selected disabled>müştərini seç</option>';
$customer_result = mysqli_query($connect_link,"SELECT client FROM cre_orders WHERE order_status='təsdiq' $chosen_client");
if(mysqli_num_rows($customer_result)>0){
	$customer_row = mysqli_fetch_assoc($customer_result);
	do{ 
		$cusname_result = mysqli_query($connect_link,"SELECT client FROM cstmr_data WHERE login='{$customer_row['client']}'");
		$cusname_row = mysqli_fetch_assoc($cusname_result);
		echo '<option value="'.$customer_row['client'].'"> '.$cusname_row['client'].'</option>';}
	while($customer_row = mysqli_fetch_assoc($customer_result));
}
			echo '</select>
	</div>
	<div>
		<select name="order_select">
			<option value="" selected disabled>sifarişi seç</option>';
$orders_result = mysqli_query($connect_link,"SELECT id, man_verifiedamount, man_verifiedcurrency, man_verifiedperiod FROM cre_orders WHERE order_status='təsdiq' $chosen_client");
if(mysqli_num_rows($orders_result)>0){
	$orders_row = mysqli_fetch_assoc($orders_result);
	do{ echo '
		<option value="'.$orders_row['id'].'">'.$orders_row['id'].' - '.$orders_row['man_verifiedamount'].' '.$orders_row['man_verifiedcurrency'].' '.$orders_row['man_verifiedperiod'].' aylıq</option>';}
	while($orders_row = mysqli_fetch_assoc($orders_result));
}
		echo '</select>
	</div>
	<div>
		<select name="product_select">
			<option value="" selected disabled>kredit məhsulu seç</option>';
$categories_result = mysqli_query($connect_link,"SELECT product_name FROM crdt_category");
if(mysqli_num_rows($categories_result)>0){
	$categories_row = mysqli_fetch_assoc($categories_result);
	do{ echo '
		<option value="'.$categories_row['product_name'].'">'.$categories_row['product_name'].'</option>';}
	while($categories_row = mysqli_fetch_assoc($categories_result));
}
		echo '</select>
	</div>
	<div>
		<input type="number" id="credamo" name="credit_sum" placeholder="məbləğ" value='.$credit_row['credit_amount'].'>
	</div>
	<div>
		<select name="currency_select">
			<option value="AZN" '.$aznsel.'>Azərb. manatı</option>
			<option value="USD" '.$usdsel.'>ABŞ dolları</option>
			<option value="EUR" '.$eursel.'>Avro</option>
		</select>
	</div>
	<br><br>
	<div>
		<input type="number" id="credper" name="cre_period" placeholder="müddət(ay)" value='.$credit_row['credit_period'].'>
	</div>
	<div>
		<input type="number" id="credperc" name="cre_percentage" placeholder="illik faiz" value='.$credit_row['credit_percentage'].'>
	</div>
	<div>
		<input type="number" id="credfypd" name="cre_fypd" placeholder="FİFD" value='.$credit_row['credit_fypd'].'>
	</div>
	<div>
		<input type="number" id="penalperc" name="penal_percentage" placeholder="cərimə faizi" value='.$credit_row['penalty_percentage'].'>
	</div>
	<div>
		<input type="number" id="monthpay" name="monthlypay" placeholder="aylıq ödəniş" value='.$credit_row['monthly_payment'].'>
	</div>
	<div>
		<input type="number" id="credti" name="dti_coef" placeholder="BGN əmsalı" value='.$credit_row['coefficient'].'>
	</div>
	<div>
		<select name="rating_select">
			<option value="A" '.$asel.'>A</option>
			<option value="B" '.$bsel.'>B</option>
			<option value="C" '.$csel.'>C</option>
			<option value="D" '.$dsel.'>D</option>
		</select>
	</div>
	<div>
		<select name="contract_select">
			<option value="birdəfəlik" '.$bksel.'>birdəfəlik</option>
			<option value="bərpaolunmayan" '.$bomsel.'>bərpaolunmayan xətt</option>
			<option value="bərpaolunan" '.$bolsel.'>bərpaolunan xətt</option>
			<option value="overdraft" '.$ovsel.'>overdraft</option>
			<option value="plastik" '.$pcasel.'>plastik kart</option>
		</select>
	</div>
	<div>
		<select name="source_select">
			<option value="bank" '.$bankfsel.'>Bankın vəsaiti</option>
			<option value="fond" '.$fondfsel.'>Fondun vəsaiti</option>
		</select>
	</div>
	<br><br>
	<div>
		<input type="number" id="credcom" name="comission" placeholder="komisyon" value='.$credit_row['cred_comission'].'>
	</div>
	<div>
		<input type="text" id="credextra" name="discont" placeholder="güzəşt" value='.$credit_row['concession'].'>
	</div>
	<div>
		<input type="submit" name="oficercre_submit" id="form_submit" value="Düzəlt">
	</div>';}
	}
	
	if($_SESSION['bank_department'] == "system"){echo '
	<p>Sistem nəzarətçisinin RESETi</p>		
	<div>
		<input type="submit" name="resetcre_submit" id="form_submit" value="RESET">
	</div>';}
	
echo'
	</div>
</form>';
}

	if($_SESSION['credit_view'] == '1' || $_SESSION['auth_admin_login'] == $credit_row["credit_verifier"] || $_SESSION['auth_admin_login'] == $credit_row["credit_officer"]){
	if(isset($credit_row['ofcer_docdate'])){
		$cusid_result = mysqli_query($connect_link,"SELECT id FROM cstmr_data WHERE login='{$credit_row['client']}'");
		$cusid_row = mysqli_fetch_assoc($cusid_result);
		echo '
<div id="midblock">
	<p>Agentin yığdığı xanalar</p>
	<div id="clientbox" title="müştərinin ID-i">
		<a href="view_customer?id='.$cusid_row["id"].'" target="_blank">Müştəri - '.$credit_row['client'].'</a>
	</div>
	<div id="orderbox" title="müştərinin kredit sifarişi">
		<a href="view_orders?id='.$credit_row["order_id"].'" target="_blank">SİFARİŞ - '.$credit_row['order_id'].'</a>
	</div>
	<div id="productbox" title="verilən kredit məhsulu">'.$credit_row['credit_product'].'</div>
	<div id="amountbox" title="kreditin məbləği">'.$credit_row['credit_amount'].'</div>
	<div id="currencybox" title="kreditin valyutası">'.$credit_row['credit_currency'].'</div>
	<div id="periodbox" title="kreditin qüvvədəolma müddəti">'.$credit_row['credit_period'].' ay</div>
	<div id="percentagebox" title="illik faiz">'.$credit_row['credit_percentage'].' %</div>
	<div id="percentagebox" title="FİFD">'.$credit_row['credit_fypd'].' %</div>
	<div id="ratebox" title="kredit keyfiyyəti">'.$credit_row['rate'].'</div>
	<div id="penaltybox" title="cərimə faizi">'.$credit_row['penalty_percentage'].' %</div>
	<br><br>
	<div id="coeficentbox" title="BGN əmsalı">'.$credit_row['coefficient'].' %</div>
	<div id="paymentbox" title="aylıq ödəniş">'.$credit_row['monthly_payment'].'</div>
	<div id="contractbox" title="müqavilə forması">'.$credit_row['type_credit'].'</div>
	<div id="sourcebox" title="maliyyələşmə mənbəyi">'.$credit_row['source_fund'].'</div>
	<div id="comisionbox" title="kreditin komissiyası">'.$credit_row['cred_comission'].' %</div>';
	if(isset($credit_row['concession'])){ echo '
	<div id="discountbox" title="güzəştlər barədə">'.$credit_row['concession'].'</div>';}
	}
	if(isset($credit_row['verif_docdate'])){ echo '
	<p>Menecerin yığdığı xanalar</p>
	<div id="unicalidbox" title="kreditin unikal ID-i">'.$credit_row['unical_credid'].'</div>
	<div id="stdatebox" title="kreditin qüvvəyə mindiyi tarix">'.date_format(date_create($credit_row["credit_startdate"]),"d-m-Y").'</div>
	<div id="endatebox" title="kreditin qüvvədən düşdüyü tarix">'.date_format(date_create($credit_row["credit_enddate"]),"d-m-Y").'</div>
	<div id="paydaybox" title="ödəniş günü">'.$credit_row['payment_day'].'</div>';
	}
	if(isset($credit_row['reminder_maindebt'])){ echo '
	<p>Kreditin son durumu (1 gün əvvələ olan)</p>
	<div id="paymentbox" title="əsas borcun qalığı">'.$credit_row['reminder_maindebt'].'</div>
	<div id="paymentbox" title="normal faiz borcun qalığı">'.$credit_row['reminder_percdebt'].'</div>
	<div id="paymentbox" title="ödənilməmiş əsas borc">'.$credit_row['delayed_maindebt'].'</div>
	<div id="paymentbox" title="ödənilməmiş faiz borcu">'.$credit_row['delayed_percdebt'].'</div>
	<div id="paymentbox" title="ödənilməmiş cərimə borcu">'.$credit_row['delayed_pendebt'].'</div>
	<div id="paymentbox" title="ödənilmiş əsas borc">'.$credit_row['paid_maindebt'].'</div>
	<div id="paymentbox" title="ödənilmiş faiz borcu">'.$credit_row['paid_percdebt'].'</div>
	<div id="paymentbox" title="ödənilmiş cərimə borcu">'.$credit_row['paid_pendebt'].'</div>
	<div id="paymentbox" title="balansdankənar əsas borc">'.$credit_row['balout_maindebt'].'</div>
	<div id="paymentbox" title="balansdankənar faiz borcu">'.$credit_row['balout_percdebt'].'</div>';
	}
	if(isset($credit_row['prolong_number']) || isset($credit_row['restruction_date'])){echo '
	<p>Kreditə olan son müdaxilə</p>';
	if(isset($credit_row['restruction_date'])){echo '<div id="restructionbox" title="restrukturizasiya olunduğu tarix">'.date_format(date_create($credit_row["restruction_date"]),"d-m-Y").'</div>';}
	if(isset($credit_row['prolong_number'])){ echo '<div id="prolongbox" title="müddətin artırıldığı say">'.$credit_row['prolong_number'].'</div>';}
	}
	if($_SESSION['bank_department'] == 'system' && isset($credit_row['ofcer_docdate'])){echo '
	<p>Sistem nəzarətçilərinə aid xanalar</p>
	<div title="kreditin təsdiqlənməsi">'.$credit_row['verified'].'</div>
	<div id="statusbox" title="kreditin statusu">'.$credit_row['credit_status'].'</div>
	<div id="userbox" title="krediti yığan əməliyyatçı">'.$credit_row['credit_officer'].'</div>
	<div id="userbox" title="krediti təsdiqləyən rəhbər">'.$credit_row['credit_verifier'].'</div>';
	if(isset($credit_row['ofcer_docdate'])){echo '
	<div title="əməliyyatçının krediti yığdığı tarix">'.date_format(date_create($credit_row["ofcer_docdate"]),"d-m-Y H:i:s").'</div>';}
	if(isset($credit_row['verif_docdate'])){echo '
	<div title="inzibatçı-rəhbərin krediti təsdiqlədiyi tarix">'.date_format(date_create($credit_row["verif_docdate"]),"d-m-Y H:i:s").'</div>';}
	}
	
	$plecre_result = mysqli_query($connect_link,"SELECT * FROM pledge_concat WHERE credit_id='$id'");
	if(mysqli_num_rows($plecre_result)>0){
	$plecre_row = mysqli_fetch_assoc($plecre_result);									   
	echo '<p>Əlaqəli girovlar</p>';
	do{echo '
	<div class="myborders" title="kreditə bağlı girova salınma tipi">'.$plecre_row["contract_type"].'</div>
	<div class="myborders" title="girovun kreditlə əlaqələndiyi tarix">'.date_format(date_create($plecre_row["start_date"]),"d-m-Y").'</div>';
	if($plecre_row["end_date"] != ""){echo '
	<div class="myborders" title="girovdan çıxma tarixi">'.date_format(date_create($plecre_row["end_date"]),"d-m-Y").'</div>';}
	echo '<div class="myborders" title="kreditin ID-si"><a target="_blank" href="view_pledge?id='.$plecre_row["pledge_id"].'">Birləşən girov - '.$plecre_row["pledge_id"].'</a></div><br><br>';
	}
	while($plecre_row = mysqli_fetch_assoc($plecre_result));}
echo '</div>';}
}
?>