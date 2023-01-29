<?php 
defined('mcsystem') or die('Cəhdin yaxşı idi, sərf etdiyin vaxtı başqa şeyə sərf et!');
echo '<div id="midblock">
	<p>Sistem üzrə mövcud istifadəçilər</p>';
	
	$appcus_result = mysqli_query($connect_link,"SELECT id FROM cstmr_data WHERE status='aktiv'");
	echo '<div id="indappbox">Yeni müraciətlər - '.mysqli_num_rows($appcus_result).'</div>';
	
	$delcus_result = mysqli_query($connect_link,"SELECT id FROM cstmr_data WHERE status='deaktiv'");
	echo '<div id="indeacbox">Ləğv edilmişlər - '.mysqli_num_rows($delcus_result).'</div>';
	
	$customer_result = mysqli_query($connect_link,"SELECT id FROM cstmr_data WHERE verified='yes'");
	echo '<div id="indcusbox">Müştəri sayı - '.mysqli_num_rows($customer_result).'</div>';

	$legalcus_result = mysqli_query($connect_link,"SELECT id FROM cstmr_data WHERE verified='yes' AND person_type='Hüquqi şəxs'");
	echo '<div id="indlegbox">Firma - '.mysqli_num_rows($legalcus_result).'</div>';
	
	$citizcus_result = mysqli_query($connect_link,"SELECT id FROM cstmr_data WHERE verified='yes' AND person_type!='Hüquqi şəxs'");
	echo '<div id="indothbox">Vətəndaş - '.mysqli_num_rows($citizcus_result).'</div>';
	
	$resicus_result = mysqli_query($connect_link,"SELECT id FROM cstmr_data WHERE verified='yes' AND nationality='rezident'");
	echo '<div id="indresbox">Rezident - '.mysqli_num_rows($resicus_result).'</div><br><br>';
	
	$belcus_result = mysqli_query($connect_link,"SELECT id FROM cstmr_data WHERE verified='yes' AND belong='checked'");
	echo '<div id="indbelbox">Aidiyyatı şəxs - '.mysqli_num_rows($belcus_result).'</div>';
	
	$relcus_result = mysqli_query($connect_link,"SELECT id FROM cstmr_data WHERE verified='yes' AND related='checked'");
	echo '<div id="indrelbox">Əlaqədar şəxs - '.mysqli_num_rows($relcus_result).'</div>';
	
	$govcus_result = mysqli_query($connect_link,"SELECT id FROM cstmr_data WHERE verified='yes' AND gover_entity='checked'");
	echo '<div id="indgovbox">Dövlət müəssisəsi - '.mysqli_num_rows($govcus_result).'</div>';
	
	$admcus_result = mysqli_query($connect_link,"SELECT id FROM cstmr_data WHERE verified='yes' AND administration='checked'");
	echo '<div id="indadmbox">İnzibatçılıq - '.mysqli_num_rows($admcus_result).'</div>';
	
	$depcus_result = mysqli_query($connect_link,"SELECT id FROM cstmr_data WHERE verified='yes' AND depart_boss='checked'");
	echo '<div id="indepabox">Struktur rəhbərliyi - '.mysqli_num_rows($depcus_result).'</div>';
	
	$branches_result = mysqli_query($connect_link,"SELECT * FROM branches");
	if(mysqli_num_rows($branches_result)>0){
		$branch_row = mysqli_fetch_assoc($branches_result);
		do{
			echo '
	<p>'.$branch_row["full_name"].' üzrə mövcud istifadəçilər</p>';
			
	$appcus_result = mysqli_query($connect_link,"SELECT id FROM cstmr_data WHERE status='aktiv' AND branch_code='{$branch_row["branch_code"]}'");
	echo '<div id="indappbox">Yeni müraciətlər - '.mysqli_num_rows($appcus_result).'</div>';
	
	$delcus_result = mysqli_query($connect_link,"SELECT id FROM cstmr_data WHERE status='deaktiv' AND branch_code='{$branch_row["branch_code"]}'");
	echo '<div id="indeacbox">Ləğv edilmişlər - '.mysqli_num_rows($delcus_result).'</div>';
	
	$customer_result = mysqli_query($connect_link,"SELECT id FROM cstmr_data WHERE verified='yes' AND branch_code='{$branch_row["branch_code"]}'");
	echo '<div id="indcusbox">Müştəri sayı - '.mysqli_num_rows($customer_result).'</div>';

	$legalcus_result = mysqli_query($connect_link,"SELECT id FROM cstmr_data WHERE verified='yes' AND person_type='Hüquqi şəxs' AND branch_code='{$branch_row["branch_code"]}'");
	echo '<div id="indlegbox">Firma - '.mysqli_num_rows($legalcus_result).'</div>';
	
	$citizcus_result = mysqli_query($connect_link,"SELECT id FROM cstmr_data WHERE verified='yes' AND person_type!='Hüquqi şəxs' AND branch_code='{$branch_row["branch_code"]}'");
	echo '<div id="indothbox">Vətəndaş - '.mysqli_num_rows($citizcus_result).'</div>';
	
	$resicus_result = mysqli_query($connect_link,"SELECT id FROM cstmr_data WHERE verified='yes' AND nationality='rezident' AND branch_code='{$branch_row["branch_code"]}'");
	echo '<div id="indresbox">Rezident - '.mysqli_num_rows($resicus_result).'</div><br><br>';
	
	$belcus_result = mysqli_query($connect_link,"SELECT id FROM cstmr_data WHERE verified='yes' AND belong='checked' AND branch_code='{$branch_row["branch_code"]}'");
	echo '<div id="indbelbox">Aidiyyatı şəxs - '.mysqli_num_rows($belcus_result).'</div>';
	
	$relcus_result = mysqli_query($connect_link,"SELECT id FROM cstmr_data WHERE verified='yes' AND related='checked' AND branch_code='{$branch_row["branch_code"]}'");
	echo '<div id="indrelbox">Əlaqədar şəxs - '.mysqli_num_rows($relcus_result).'</div>';
	
	$govcus_result = mysqli_query($connect_link,"SELECT id FROM cstmr_data WHERE verified='yes' AND gover_entity='checked' AND branch_code='{$branch_row["branch_code"]}'");
	echo '<div id="indgovbox">Dövlət müəssisəsi - '.mysqli_num_rows($govcus_result).'</div>';
	
	$admcus_result = mysqli_query($connect_link,"SELECT id FROM cstmr_data WHERE verified='yes' AND administration='checked' AND branch_code='{$branch_row["branch_code"]}'");
	echo '<div id="indadmbox">İnzibatçılıq - '.mysqli_num_rows($admcus_result).'</div>';
	
	$depcus_result = mysqli_query($connect_link,"SELECT id FROM cstmr_data WHERE verified='yes' AND depart_boss='checked' AND branch_code='{$branch_row["branch_code"]}'");
	echo '<div id="indepabox">Struktur rəhbərliyi - '.mysqli_num_rows($depcus_result).'</div>';			
		}
		while($branch_row = mysqli_fetch_assoc($branches_result));
	}

	echo '<p>Sistem üzrə mövcud sifarişlər</p>';

	$analizingord_result = mysqli_query($connect_link,"SELECT id FROM cre_orders WHERE order_status='aktiv'");
	echo '<div id="analizbox">Baxılan - '.mysqli_num_rows($analizingord_result).'</div>';

	$verord_result = mysqli_query($connect_link,"SELECT id FROM cre_orders WHERE order_status='təsdiq'");
	echo '<div id="verordbox">Təsdiqlənmiş - '.mysqli_num_rows($verord_result).'</div>';

	$rejord_result = mysqli_query($connect_link,"SELECT id FROM cre_orders WHERE order_status='imtina'");
	echo '<div id="rejordbox">İmtinalar - '.mysqli_num_rows($rejord_result).'</div>';	

	$pledgord_result = mysqli_query($connect_link,"SELECT id FROM cre_orders WHERE ple_type IS NOT NULL");
	echo '<div id="pledgbox">Girovlular - '.mysqli_num_rows($pledgord_result).'</div>';

	$litord_result = mysqli_query($connect_link,"SELECT id FROM cre_orders WHERE man_verifiedamount <= 10000 AND order_status='təsdiq'");
	echo '<div id="litordbox">Kiçik - '.mysqli_num_rows($litord_result).'</div>';

	$medord_result = mysqli_query($connect_link,"SELECT id FROM cre_orders WHERE man_verifiedamount >  10000 AND man_verifiedamount <= 500000 AND order_status='təsdiq'");
	echo '<div id="medordbox">Orta - '.mysqli_num_rows($medord_result).'</div>';

	$bigord_result = mysqli_query($connect_link,"SELECT id FROM cre_orders WHERE man_verifiedamount > 500000 AND order_status='təsdiq'");
	echo '<div id="bigordbox">Böyük - '.mysqli_num_rows($bigord_result).'</div><br><br>';

	$minicrord_result = mysqli_query($connect_link,"SELECT id FROM cre_orders WHERE product_name='Mini kredit' AND order_status='təsdiq'");
	echo '<div id="minicrbox">Mini - '.mysqli_num_rows($minicrord_result).'</div>';

	$cardcrord_result = mysqli_query($connect_link,"SELECT id FROM cre_orders WHERE product_name='Kart krediti' AND order_status='təsdiq'");
	echo '<div id="cardcrbox">Kart - '.mysqli_num_rows($cardcrord_result).'</div>';

	$lombcrord_result = mysqli_query($connect_link,"SELECT id FROM cre_orders WHERE product_name='Lombard krediti' AND order_status='təsdiq'");
	echo '<div id="lombcrbox">Lombard - '.mysqli_num_rows($lombcrord_result).'</div>';

	$vehicrord_result = mysqli_query($connect_link,"SELECT id FROM cre_orders WHERE product_name='Avtomobil krediti' AND order_status='təsdiq'");
	echo '<div id="vehicrbox">Avtomobil - '.mysqli_num_rows($vehicrord_result).'</div>';

	$urgentcrord_result = mysqli_query($connect_link,"SELECT id FROM cre_orders WHERE product_name='Təcili kredit' AND order_status='təsdiq'");
	echo '<div id="urgentcrbox">Təcili - '.mysqli_num_rows($urgentcrord_result).'</div>';

	$urgcardcrord_result = mysqli_query($connect_link,"SELECT id FROM cre_orders WHERE product_name='Təcili kart' AND order_status='təsdiq'");
	echo '<div id="urgcardcrbox">Təcili Kart - '.mysqli_num_rows($urgcardcrord_result).'</div>';

	$mortgcrord_result = mysqli_query($connect_link,"SELECT id FROM cre_orders WHERE product_name='Əmlak krediti' AND order_status='təsdiq'");
	echo '<div id="mortgcrbox">Əmlak - '.mysqli_num_rows($mortgcrord_result).'</div>';

	$kobcrord_result = mysqli_query($connect_link,"SELECT id FROM cre_orders WHERE product_name='KOB krediti' AND order_status='təsdiq'");
	echo '<div id="kobcrbox">KOB - '.mysqli_num_rows($kobcrord_result).'</div>';

	$agents_result = mysqli_query($connect_link,"SELECT * FROM users WHERE role='user'");
	if(mysqli_num_rows($agents_result)>0){
		$agents_row = mysqli_fetch_assoc($agents_result);
		do{
			echo '
	<p>'.$agents_row["nsp"].' üzrə mövcud sifarişlər</p>';
			
	$analizingord_result = mysqli_query($connect_link,"SELECT id FROM cre_orders WHERE order_status='aktiv' AND cho_creditor='{$agents_row["login"]}'");
	echo '<div id="analizbox">Baxılan - '.mysqli_num_rows($analizingord_result).'</div>';

	$verord_result = mysqli_query($connect_link,"SELECT id FROM cre_orders WHERE order_status='təsdiq' AND cho_creditor='{$agents_row["login"]}'");
	echo '<div id="verordbox">Təsdiqlənmiş - '.mysqli_num_rows($verord_result).'</div>';

	$rejord_result = mysqli_query($connect_link,"SELECT id FROM cre_orders WHERE order_status='imtina' AND cho_creditor='{$agents_row["login"]}'");
	echo '<div id="rejordbox">İmtinalar - '.mysqli_num_rows($rejord_result).'</div>';	

	$pledgord_result = mysqli_query($connect_link,"SELECT id FROM cre_orders WHERE ple_type IS NOT NULL AND cho_creditor='{$agents_row["login"]}'");
	echo '<div id="pledgbox">Girovlular - '.mysqli_num_rows($pledgord_result).'</div>';

	$litord_result = mysqli_query($connect_link,"SELECT id FROM cre_orders WHERE man_verifiedamount <= 10000 AND order_status='təsdiq' AND cho_creditor='{$agents_row["login"]}'");
	echo '<div id="litordbox">Kiçik - '.mysqli_num_rows($litord_result).'</div>';

	$medord_result = mysqli_query($connect_link,"SELECT id FROM cre_orders WHERE man_verifiedamount >  10000 AND man_verifiedamount <= 500000 AND order_status='təsdiq' AND cho_creditor='{$agents_row["login"]}'");
	echo '<div id="medordbox">Orta - '.mysqli_num_rows($medord_result).'</div>';

	$bigord_result = mysqli_query($connect_link,"SELECT id FROM cre_orders WHERE man_verifiedamount > 500000 AND order_status='təsdiq' AND cho_creditor='{$agents_row["login"]}'");
	echo '<div id="bigordbox">Böyük - '.mysqli_num_rows($bigord_result).'</div><br><br>';

	$minicrord_result = mysqli_query($connect_link,"SELECT id FROM cre_orders WHERE product_name='Mini kredit' AND order_status='təsdiq' AND cho_creditor='{$agents_row["login"]}'");
	echo '<div id="minicrbox">Mini - '.mysqli_num_rows($minicrord_result).'</div>';

	$cardcrord_result = mysqli_query($connect_link,"SELECT id FROM cre_orders WHERE product_name='Kart krediti' AND order_status='təsdiq' AND cho_creditor='{$agents_row["login"]}'");
	echo '<div id="cardcrbox">Kart - '.mysqli_num_rows($cardcrord_result).'</div>';

	$lombcrord_result = mysqli_query($connect_link,"SELECT id FROM cre_orders WHERE product_name='Lombard krediti' AND order_status='təsdiq' AND cho_creditor='{$agents_row["login"]}'");
	echo '<div id="lombcrbox">Lombard - '.mysqli_num_rows($lombcrord_result).'</div>';

	$vehicrord_result = mysqli_query($connect_link,"SELECT id FROM cre_orders WHERE product_name='Avtomobil krediti' AND order_status='təsdiq' AND cho_creditor='{$agents_row["login"]}'");
	echo '<div id="vehicrbox">Avtomobil - '.mysqli_num_rows($vehicrord_result).'</div>';

	$urgentcrord_result = mysqli_query($connect_link,"SELECT id FROM cre_orders WHERE product_name='Təcili kredit' AND order_status='təsdiq' AND cho_creditor='{$agents_row["login"]}'");
	echo '<div id="urgentcrbox">Təcili - '.mysqli_num_rows($urgentcrord_result).'</div>';

	$urgcardcrord_result = mysqli_query($connect_link,"SELECT id FROM cre_orders WHERE product_name='Təcili kart' AND order_status='təsdiq' AND cho_creditor='{$agents_row["login"]}'");
	echo '<div id="urgcardcrbox">Təcili Kart - '.mysqli_num_rows($urgcardcrord_result).'</div>';

	$mortgcrord_result = mysqli_query($connect_link,"SELECT id FROM cre_orders WHERE product_name='Əmlak krediti' AND order_status='təsdiq' AND cho_creditor='{$agents_row["login"]}'");
	echo '<div id="mortgcrbox">Əmlak - '.mysqli_num_rows($mortgcrord_result).'</div>';

	$kobcrord_result = mysqli_query($connect_link,"SELECT id FROM cre_orders WHERE product_name='KOB krediti' AND order_status='təsdiq' AND cho_creditor='{$agents_row["login"]}'");
	echo '<div id="kobcrbox">KOB - '.mysqli_num_rows($kobcrord_result).'</div>';
		}
		while($agents_row = mysqli_fetch_assoc($agents_result));
	}

echo '</div>';
?>