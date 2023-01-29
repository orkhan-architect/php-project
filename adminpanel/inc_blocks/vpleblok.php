<?php 
defined('mcsystem') or die('Cəhdin yaxşı idi, sərf etdiyin vaxtı başqa şeyə sərf et!');

if($_SESSION['msg']){
		echo $_SESSION['msg'];
		unset($_SESSION['msg']);
}

if($_SESSION['users_role'] == 'manager'){
	$manger = $_SESSION['auth_admin_login'];
	$formanager = "AND manager='$manger'";
}

if($_SESSION['users_role'] == 'user'){
	$uer = $_SESSION['auth_admin_login'];
	$foruser = "AND agent='$uer'";
}

$pledge_result = mysqli_query($connect_link,"SELECT * FROM pledge_data WHERE id='$id' $formanager $foruser");
if(mysqli_num_rows($pledge_result)>0){
	$pledge_row = mysqli_fetch_assoc($pledge_result);
	
	if($_SESSION['pledge_edit'] == '1'){echo '
<form method="post" enctype="multipart/form-data">
	<div id="yigilma_sahesi">';
										
	if($_SESSION['users_role'] == 'admin'){ echo '
	<p>Şəkil əlavə etmə funksiyası</p>
	<input type="file" name="upload[]" id="upload" multiple>
	<input type="submit" name="filesubmit" id="form_submit" value="Yüklə">';}
	
	if($_SESSION['bank_department'] == "system" || $_SESSION['users_role'] == 'manager'){
		if(!isset($pledge_row["manager_chdate"])){ echo '
	<p>Menecerin xüsusi qeydləri</p>
	<div>
		<input id="managnotestyle" autocomplete="off" name="form_managernote" type="text" title="Menecerin qeydləri" value="'.$pledge_row["manager_notes"].'">
	</div>
	<div>
		<input type="submit" name="pledgeconfirm_submit" id="form_submit" value="Təsdiqlə">
	</div>';}
	}	
	
	if($_SESSION['bank_department'] == "system" || $_SESSION['users_role'] == 'user'){
		if(!isset($pledge_row["agent_chdate"])){
			if($pledge_row["pledge_currency"] == "AZN"){$plazn = "selected";}
			if($pledge_row["pledge_currency"] == "USD"){$plusd = "selected";}
			if($pledge_row["pledge_currency"] == "EUR"){$pleur = "selected";}
	
			if($pledge_row["ownership"] == "xüsusi"){$plown = "selected";}
			if($pledge_row["ownership"] == "dövlət"){$plgov = "selected";}
	
			if($pledge_row["portion"] == "bəli"){$plportly = "selected";}
			if($pledge_row["portion"] == "xeyr"){$plfullport = "selected";}
			echo '
	<p>Girovqoyan barədə</p>
	<div>
		<select name="persontype_select" id="typepers">
			<option value="" selected disabled>girovqoyan seç</option>
			<option value="Fiziki şəxs">Vətəndaş</option>
			<option value="Hüquqi şəxs">Firma</option>
		</select>
	</div>
	<div>
		<input id="pledgerstyle" autocomplete="off" name="form_pledger" type="text" title="İnisial (ASA və ya şirkət)" onkeyup="this.value = this.value.toUpperCase();" value="'.$pledge_row["mortgagor"].'">
	</div>
	<div>
		<input id="pledocidstyle" autocomplete="off" name="form_pledocid" type="text" title="FIN - VÖEN" onkeyup="this.value = this.value.toUpperCase();" value="'.$pledge_row["fincode_taxes"].'">
	</div>
	<span class="companyhide">
		<input id="dirtypestyle" autocomplete="off" name="form_dirtype" type="text" title="İdarəedən şəxsin vəzifəsi" onkeyup="this.value = this.value.toUpperCase();" value="'.$pledge_row["ceo_post"].'">
	</span>
	<span class="companyhide">
		<input id="dirinitstyle" autocomplete="off" name="form_dirinit" type="text" title="Vəzifəli şəxsin ASA" onkeyup="this.value = this.value.toUpperCase();" value="'.$pledge_row["ceo_init"].'">
	</span>
	<span class="citizenhide">
		<input id="docsernumstyle" autocomplete="off" name="form_docsernum" type="text" title="Sənədin seriya-kodu" onkeyup="this.value = this.value.toUpperCase();" value="'.$pledge_row["doc_sernum"].'">
	</span>
	<span class="citizenhide">
		<input id="docgovenamestyle" autocomplete="off" name="form_docgovename" type="text" title="Vəsiqəni verən orqan" onkeyup="this.value = this.value.toUpperCase();" value="'.$pledge_row["doc_govname"].'">
	</span>
	<span class="citizenhide">
		<input name="form_docregdate" type="date" title="Vəsiqənin verilmə tarixi (ay/gün/il)" value="'.$pledge_row["doc_regdate"].'">
	</span>
	<br><br>
	<div>
		<input id="phonumberstyle" autocomplete="off" name="form_phonumber" type="text" title="Telefon nömrəsi" value="'.$pledge_row["phone_numbers"].'">
	</div>
	<div>
		<input id="mailstyle" autocomplete="off" name="form_mail" type="text" title="Email ünvanı" value="'.$pledge_row["email_addr"].'">
	</div>
	<div>
		<input id="regadrestyle" autocomplete="off" name="form_regadres" type="text" title="Qeydiyyat ünvanı" value="'.$pledge_row["reg_address"].'">
	</div>
	
	<p>Girov barədə</p>
	<div>
		<select name="pledge_select" id="typepled">
			<option value="" selected disabled>girov növünü seç</option>';
			$pledtype_result = mysqli_query($connect_link,"SELECT * FROM pledge_category");
			if(mysqli_num_rows($pledtype_result)>0){
			$pledtype_row = mysqli_fetch_assoc($pledtype_result);
			do{ echo '
			<option value="'.$pledtype_row['pledge_name'].'" title="'.$pledtype_row['pledge_type'].'"> '.$pledtype_row['pledge_name'].'</option>';}
			while($pledtype_row = mysqli_fetch_assoc($pledtype_result));
			}
	echo '</select>
	</div>
	<div>
		<input id="markvaluestyle" name="form_markvalue" type="number" title="Bazar dəyəri" value="'.$pledge_row["pledge_cost"].'">
	</div>
	<div>
		<input id="liqvaluestyle" name="form_liqvalue" type="number" title="Likvid dəyəri" value="'.$pledge_row["liquid_cost"].'">
	</div>
	<div>
		<select name="plcurrency_select">
			<option value="" selected disabled>Valyutanı seç</option>
			<option value="AZN" '.$plazn.'>manat</option>
			<option value="USD" '.$plusd.'>dollar</option>
			<option value="EUR" '.$pleur.'>avro</option>
		</select>
	</div>
	<div>
		<textarea rows="1" cols="29" name="form_description" title="Girovun təsviri" style="vertical-align: sub;">'.$pledge_row["pledge_description"].'</textarea>
	</div>
	<div>
		<textarea rows="1" cols="30" name="form_sitadres" title="Girovun yerləşdiyi ünvan" style="vertical-align: sub;">'.$pledge_row["pledge_address"].'</textarea>
	</div><br><br>
	<div>
		<input id="regidstyle" autocomplete="off" name="form_regid" type="text" title="Reyestr/Ban/Şassi/Hesab" onkeyup="this.value = this.value.toUpperCase();" value="'.$pledge_row["register_id"].'">
	</div>
	<span class="vehiclehide">
		<input id="brandstyle" name="form_brand" type="text" title="Marka" onkeyup="this.value = this.value.toUpperCase();" value="'.$pledge_row["brand"].'">
	</span>
	<span class="vehiclehide">
		<input id="modelstyle" name="form_model" type="text" title="Model" onkeyup="this.value = this.value.toUpperCase();" value="'.$pledge_row["model"].'">
	</span>
	<span class="vehiclehide">
		<input id="vehtypstyle" name="form_vehtype" type="text" placeholder="Ban tipi" onkeyup="this.value = this.value.toUpperCase();" value="'.$pledge_row["vehicle_type"].'">
	</span>
	<span class="vehiclehide">
		<input id="colourstyle" name="form_colour" type="text" placeholder="Rəngi" onkeyup="this.value = this.value.toUpperCase();" value="'.$pledge_row["vehicle_colour"].'">
	</span>
	<span class="vehiclehide">
		<input id="proyearstyle" name="form_proyear" type="number" title="İli" value="'.$pledge_row["property_year"].'">
	</span>
	<span class="flathide">
		<select name="ownship_select">
			<option value="" selected disabled>Mülkiyyət növü seç</option>
			<option value="xüsusi" '.$plown.'>özəl</option>
			<option value="dövlət" '.$plgov.'>icarə</option>
		</select>
	</span>
	<span class="flathide">
		<select name="part_select">
			<option value="" selected disabled>Paylılığa görə seç</option>
			<option value="bəli" '.$plportly.'>paylı mülk</option>
			<option value="xeyr" '.$plfullport.'>tam mülk</option>
		</select>
	</span>
	<span class="flathide">
		<input id="appointstyle" name="form_appoint" type="text" title="Təyinatı" value="'.$pledge_row["appointment"].'">
	</span>
	
	<span class="apraisinsurhide">
	<p>Qiymətləndirmə və sığorta barədə</p>
	<div>
		<input id="apraistyle" name="form_aprais" type="text" title="Qiymətləndirici şirkət" value="'.$pledge_row["appraiser"].'">
	</div>
	<div>
		<input name="form_evaldate" type="date" title="Qiymətləndirilmə tarixi (ay/gün/il)" value="'.$pledge_row["evaluation_date"].'">
	</div>
	<div>
		<input id="insurancestyle" name="form_insurance" type="text" title="Sığortalayıcı şirkət" value="'.$pledge_row["insurance_comp"].'">
	</div>
	<div>
		<input id="coststyle" name="form_cost" type="number" title="Sığorta məbləği" value="'.$pledge_row["ins_cost"].'">
	</div>
	<div>
		<input name="form_insbegdate" type="date" title="Sığortanın başlama tarixi (ay/gün/il)" value="'.$pledge_row["ins_begindate"].'">
	</div>
	<div>
		<input name="form_insendate" type="date" title="Sığortanın bitmə tarixi (ay/gün/il)" value="'.$pledge_row["ins_endindate"].'">
	</div>
	</span>
	
	<p>Agentin xüsusi qeydləri</p>
	<div>
		<input id="agentnotestyle" autocomplete="off" name="form_agentnote" type="text" title="Agentin qeydləri" value="'.$pledge_row["agent_notes"].'">
	</div>
	<div>
		<input type="submit" name="updpledge_submit" id="form_submit" value="Redaktə et">
	</div>';}
	}
	
	if($_SESSION['bank_department'] == "system"){echo '
	<p>Sistem nəzarətçisinin RESETi</p>
	<div>
		<input type="submit" name="pledgereset_submit" id="form_submit" value="RESET">
	</div>';}
	
echo'
	</div>
</form>';
}

	if($_SESSION['pledge_view'] == '1' || $_SESSION['auth_admin_login'] == $pledge_row["manager"] || $_SESSION['auth_admin_login'] == $pledge_row["agent"]){
		if(isset($pledge_row["agent_chdate"])){ echo '
<div id="midblock">
	<p>Girovqoyan barədə</p>
	<div title="İnisial (ASA və ya şirkət)">'.$pledge_row["mortgagor"].'</div>
	<div title="FIN - VÖEN">'.$pledge_row["fincode_taxes"].'</div>';
	if($pledge_row["person_type"] == 'Fiziki şəxs'){ echo '
	<div title="Sənədin seriya-kodu">'.$pledge_row["doc_sernum"].'</div>
	<div title="Vəsiqəni verən orqan">'.$pledge_row["doc_govname"].'</div>
	<div title="Vəsiqənin verilmə tarixi">'.date_format(date_create($pledge_row["doc_regdate"]),"d-m-Y").'</div>';}
	if($pledge_row["person_type"] == 'Hüquqi şəxs'){ echo '
	<div title="İdarəedən şəxsin vəzifəsi">'.$pledge_row["ceo_post"].'</div>
	<div title="Vəzifəli şəxsin ASA">'.$pledge_row["ceo_init"].'</div>';}
	echo '
	<br><br>
	<div title="Telefon nömrəsi">'.$pledge_row["phone_numbers"].'</div>
	<div title="Email ünvanı">'.$pledge_row["email_addr"].'</div>
	<div title="Qeydiyyat ünvanı">'.$pledge_row["reg_address"].'</div>
	
	<p>Girov barədə</p>
	<div title="Girovun tipi">'.$pledge_row["pledge_name"].'</div>
	<div title="Girovun Reyestr/Ban/Şassi/Hesab nömrəsi">'.$pledge_row["register_id"].'</div>
	<div title="Girovun real dəyəri">'.$pledge_row["pledge_cost"].'</div>
	<div title="Girovun likvid dəyəri">'.$pledge_row["liquid_cost"].'</div>
	<div title="Girovun valyutası">'.$pledge_row["pledge_currency"].'</div>
	<div title="Girovun geniş təsviri">'.$pledge_row["pledge_description"].'</div>
	<br><br>
	<div title="Girovun yerləşdiyi ünvan">'.$pledge_row["pledge_address"].'</div>';
	$pledtype_result = mysqli_query($connect_link,"SELECT * FROM pledge_category WHERE pledge_name='{$pledge_row["pledge_name"]}'");
	if(mysqli_num_rows($pledge_result)>0){
	$pledtype_row = mysqli_fetch_assoc($pledtype_result);
	if($pledtype_row["pledge_type"] == 'nəqliyyat vasitəsi'){ echo '
	<br><br>
	<div title="Markası">'.$pledge_row["brand"].'</div>
	<div title="Modeli">'.$pledge_row["model"].'</div>
	<div title="Ban tipi">'.$pledge_row["vehicle_type"].'</div>
	<div title="Rəngi">'.$pledge_row["vehicle_colour"].'</div>
	<div title="Buraxılış ili">'.$pledge_row["property_year"].'</div>';}
	if($pledtype_row["pledge_type"] == 'daşınmaz əmlak'){ echo '
	<br><br>
	<div title="Özəl və ya dövlət mülki olması">'.$pledge_row["ownership"].'</div>
	<div title="Paylı olub-olmaması">'.$pledge_row["portion"].'</div>
	<div title="Əmlakın təyinatı">'.$pledge_row["appointment"].'</div>';}
	if($pledtype_row["pledge_type"] == 'nəqliyyat vasitəsi' || $pledtype_row["pledge_type"] == 'daşınmaz əmlak'){ echo '
	<p>Qiymətləndirmə və sığorta barədə</p>
	<div title="Qiymətləndirən şirkət">'.$pledge_row["appraiser"].'</div>
	<div title="Qiymətləndirmə tarixi">'.date_format(date_create($pledge_row["evaluation_date"]),"d-m-Y").'</div>';
	if($pledge_row["insurance_comp"] != ''){echo '
	<div title="Əmlakı sığorta edən şirkət">'.$pledge_row["insurance_comp"].'</div>
	<div title="Sığortalanan məbləğ">'.$pledge_row["ins_cost"].'</div>
	<div title="Sığortanın başladığı tarix">'.date_format(date_create($pledge_row["ins_begindate"]),"d-m-Y").'</div>
	<div title="Sığortanın bitdiyi tarix">'.date_format(date_create($pledge_row["ins_endindate"]),"d-m-Y").'</div>';}
	    }
	}
	if($pledge_row["agent_notes"] != '' || $pledge_row["manager_notes"] != ''){ echo '
	<p>Xüsusi qeydlər</p>
	<div title="satış agentinin qeydləri">'.$pledge_row["agent_notes"].'</div>
	<div title="menecerin qeydləri">'.$pledge_row["manager_notes"].'</div>';}
											   
	if($_SESSION['bank_department'] == 'system'){echo '
	<p>Sistem nəzarətçilərinə aid xanalar</p>
	<div title="girovun statusu">'.$pledge_row['manager_decision'].'</div>
	<div id="userbox" title="girovu yığan satış agenti">'.$pledge_row['agent'].'</div>
	<div id="userbox" title="girovu təsdiqləyən rəhbər">'.$pledge_row['manager'].'</div>';
	if(isset($pledge_row['agent_chdate'])){echo '
	<div title="satış agentinin girovu yığdığı tarix">'.date_format(date_create($pledge_row["agent_chdate"]),"d-m-Y H:i:s").'</div>';}
	if(isset($pledge_row['manager_chdate'])){echo '
	<div title="menecerin girovu təsdiqlədiyi tarix">'.date_format(date_create($pledge_row["manager_chdate"]),"d-m-Y H:i:s").'</div>';}
	}
	
	$plecre_result = mysqli_query($connect_link,"SELECT * FROM pledge_concat WHERE pledge_id='$id'");
	if(mysqli_num_rows($plecre_result)>0){
	$plecre_row = mysqli_fetch_assoc($plecre_result);									   
	echo '<p>Əlaqəli kreditlər</p>';
	do{echo '
	<div title="kreditə bağlı girova salınma tipi">'.$plecre_row["contract_type"].'</div>
	<div title="kreditin girovla əlaqələndiyi tarix">'.date_format(date_create($plecre_row["start_date"]),"d-m-Y").'</div>';
	if($plecre_row["end_date"] != ""){echo '
	<div title="girovdan çıxma tarixi">'.date_format(date_create($plecre_row["end_date"]),"d-m-Y").'</div>';}
	echo '<div title="kreditin ID-si"><a target="_blank" href="view_credit?id='.$plecre_row["credit_id"].'">Birləşən kredit - '.$plecre_row["credit_id"].'</a></div><br><br>';
	}
	while($plecre_row = mysqli_fetch_assoc($plecre_result));}
echo '</div>

<div class="slideshow-container">';

$pics = mysqli_query($connect_link,"SELECT pledge_images FROM upload_collimg WHERE pledge_id='$id'"); 
if(mysqli_num_rows($pics) > 0){
	$pics_row = mysqli_fetch_assoc($pics);
	do{ echo '
	<div class="mySlides fade">
		<img src="./upload_pledges/'.$pics_row["pledge_images"].'" style="width:100%">
	</div>';}
	while($pics_row = mysqli_fetch_assoc($pics));}
echo '
<a class="prev" onclick="plusSlides(-1)">&#10094;</a>
<a class="next" onclick="plusSlides(1)">&#10095;</a>

</div>
<br>

<div style="text-align:center">
  <span class="dot" onclick="currentSlide(1)"></span> 
  <span class="dot" onclick="currentSlide(2)"></span> 
  <span class="dot" onclick="currentSlide(3)"></span> 
</div>';}
    }
}
?>