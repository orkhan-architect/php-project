<?php 
defined('mcsystem') or die('Cəhdin yaxşı idi, sərf etdiyin vaxtı başqa şeyə sərf et!');
if($_SESSION['users_role'] == 'user' || $_SESSION['bank_department'] == "system"){
?>
<form method="post">
<div id="yigilma_sahesi">
<?php 
	if($_SESSION['msg']){
		echo $_SESSION['msg'];
		unset($_SESSION['msg']);
}
?>
	<p>Girovqoyan barədə</p>
	<div>
		<select name="persontype_select" id="typepers">
			<option value="" selected disabled>girovqoyan seç</option>
			<option value="Fiziki şəxs">Vətəndaş</option>
			<option value="Hüquqi şəxs">Firma</option>
		</select>
	</div>
	<div>
		<input id="pledgerstyle" autocomplete="off" name="form_pledger" type="text" placeholder="İnisial (ASA və ya şirkət)" onkeyup="this.value = this.value.toUpperCase();">
	</div>
	<div>
		<input id="pledocidstyle" autocomplete="off" name="form_pledocid" type="text" placeholder="FIN - VÖEN" onkeyup="this.value = this.value.toUpperCase();">
	</div>
	<span class="companyhide">
		<input id="dirtypestyle" autocomplete="off" name="form_dirtype" type="text" placeholder="İdarəedən şəxsin vəzifəsi" onkeyup="this.value = this.value.toUpperCase();">
	</span>
	<span class="companyhide">
		<input id="dirinitstyle" autocomplete="off" name="form_dirinit" type="text" placeholder="Vəzifəli şəxsin ASA" onkeyup="this.value = this.value.toUpperCase();">
	</span>
	<span class="citizenhide">
		<input id="docsernumstyle" autocomplete="off" name="form_docsernum" type="text" placeholder="Sənədin seriya-kodu" onkeyup="this.value = this.value.toUpperCase();">
	</span>
	<span class="citizenhide">
		<input id="docgovenamestyle" autocomplete="off" name="form_docgovename" type="text" placeholder="Vəsiqəni verən orqan" onkeyup="this.value = this.value.toUpperCase();">
	</span>
	<span class="citizenhide">
		<input name="form_docregdate" type="date" title="Vəsiqənin verilmə tarixi">
	</span>
	<br><br>
	<div>
		<input id="phonumberstyle" autocomplete="off" name="form_phonumber" type="text" placeholder="Telefon nömrəsi">
	</div>
	<div>
		<input id="mailstyle" autocomplete="off" name="form_mail" type="text" placeholder="Email ünvanı">
	</div>
	<div>
		<input id="regadrestyle" autocomplete="off" name="form_regadres" type="text" placeholder="Qeydiyyat ünvanı">
	</div>
	
	<p>Girov barədə</p>
	<div>
		<select name="pledge_select" id="typepled">
			<option value="" selected disabled>girov növünü seç</option>
<?php 
$pledtype_result = mysqli_query($connect_link,"SELECT * FROM pledge_category");
if(mysqli_num_rows($pledtype_result)>0){
	$pledtype_row = mysqli_fetch_assoc($pledtype_result);
	do{ echo '
		<option value="'.$pledtype_row['pledge_name'].'" title="'.$pledtype_row['pledge_type'].'"> '.$pledtype_row['pledge_name'].'</option>';}
	while($pledtype_row = mysqli_fetch_assoc($pledtype_result));
}
?>
		</select>
	</div>
	<div>
		<input id="markvaluestyle" name="form_markvalue" type="number" placeholder="Bazar dəyəri">
	</div>
	<div>
		<input id="liqvaluestyle" name="form_liqvalue" type="number" placeholder="Likvid dəyəri">
	</div>
	<div>
		<select name="plcurrency_select">
			<option value="" selected disabled>Valyutanı seç</option>
			<option value="AZN">manat</option>
			<option value="USD">dollar</option>
			<option value="EUR">avro</option>
		</select>
	</div>
	<div>
		<textarea rows="1" cols="29" name="form_description" placeholder="Girovun təsviri" style="vertical-align: sub;"></textarea>
	</div>
	<div>
		<textarea rows="1" cols="30" name="form_sitadres" placeholder="Girovun yerləşdiyi ünvan" style="vertical-align: sub;"></textarea>
	</div><br><br>
	<div>
		<input id="regidstyle" autocomplete="off" name="form_regid" type="text" placeholder="Reyestr/Ban/Şassi/Hesab" onkeyup="this.value = this.value.toUpperCase();">
	</div>
	<span class="vehiclehide">
		<input id="brandstyle" name="form_brand" type="text" placeholder="Marka" onkeyup="this.value = this.value.toUpperCase();">
	</span>
	<span class="vehiclehide">
		<input id="modelstyle" name="form_model" type="text" placeholder="Model" onkeyup="this.value = this.value.toUpperCase();">
	</span>
	<span class="vehiclehide">
		<input id="vehtypstyle" name="form_vehtype" type="text" placeholder="Ban tipi" onkeyup="this.value = this.value.toUpperCase();">
	</span>
	<span class="vehiclehide">
		<input id="colourstyle" name="form_colour" type="text" placeholder="Rəngi" onkeyup="this.value = this.value.toUpperCase();">
	</span>
	<span class="vehiclehide">
		<input id="proyearstyle" name="form_proyear" type="number" placeholder="İli">
	</span>
	<span class="flathide">
		<select name="ownship_select">
			<option value="" selected disabled>Mülkiyyət növü seç</option>
			<option value="xüsusi">özəl</option>
			<option value="dövlət">icarə</option>
		</select>
	</span>
	<span class="flathide">
		<select name="part_select">
			<option value="" selected disabled>Paylılığa görə seç</option>
			<option value="bəli">paylı mülk</option>
			<option value="xeyr">tam mülk</option>
		</select>
	</span>
	<span class="flathide">
		<input id="appointstyle" name="form_appoint" type="text" placeholder="Təyinatı">
	</span>
	
	<span class="apraisinsurhide">
	<p>Qiymətləndirmə və sığorta barədə</p>
	<div>
		<input id="apraistyle" name="form_aprais" type="text" placeholder="Qiymətləndirici şirkət">
	</div>
	<div>
		<input name="form_evaldate" type="date" title="Qiymətləndirilmə tarixi">
	</div>
	<div>
		<input id="insurancestyle" name="form_insurance" type="text" placeholder="Sığortalayıcı şirkət">
	</div>
	<div>
		<input id="coststyle" name="form_cost" type="number" placeholder="Sığorta məbləği">
	</div>
	<div>
		<input name="form_insbegdate" type="date" title="Sığortanın başlama tarixi">
	</div>
	<div>
		<input name="form_insendate" type="date" title="Sığortanın bitmə tarixi">
	</div>
	</span>
	
	<p>Qeydlərim və təsdiq</p>
	<div>
		<input id="agentnotestyle" autocomplete="off" name="form_agentnote" type="text" placeholder="Agentin qeydləri">
	</div>
	<div>
		<input type="submit" name="pledge_submit" id="form_submit" value="Girov yığ">
	</div>
</div>
</form>
<?php
}
else{
	echo 'Hörmətli istifadəçi. Sənə aid olmayan səhifələrə cəhd edib girmə!';
};
?>