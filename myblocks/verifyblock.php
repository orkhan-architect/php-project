<?php defined('mcsystem') or die('Cəhdin yaxşı idi, sərf etdiyin vaxtı başqa şeyə sərf et!'); ?>
<div class="row row-cols-1">
    <div class="col-md-12 text-center" id="block-form-registration">
	<?php 
	if($_SESSION['msg']){
		echo $_SESSION['msg'];
		unset($_SESSION['msg']);
	};
	$result_curorder = mysqli_query($connect_link,"SELECT * FROM cre_orders WHERE id='$id' AND client='{$_SESSION['auth_login']}'");
	if(mysqli_num_rows($result_curorder) > 0){
		$row_curorder = mysqli_fetch_assoc($result_curorder);
		if($_SESSION['auth'] == 'yes_auth' && $row_curorder['client_decision'] == 'təsdiq'){
			$readable = "disabled";
			$subchange = "İmtina et";
			$namechange = "reject_submit";
		}
		else{
			$readable = "";
			$subchange = "Təsdiq et";
			$namechange = "verify_submit";
		}	
	
		echo '<form method="post"><br>		
		<div id="leftblock">';
		
			if($row_curorder["fam_status"] == "evli"){$single = "selected";}
			if($row_curorder["fam_status"] == "subay"){$married = "selected";}
			if($row_curorder["send_findoc"] == "iş yerindən arayış"){$jobdoc = "selected";}
			if($row_curorder["send_findoc"] == "bəyannamə"){$taxdoc = "selected";}
			if($row_curorder["send_findoc"] == "digər"){$othdoc = "selected";}
			if($row_curorder["send_finothdoc"] == "hesabdan çıxarış"){$saldoc = "selected";}
			if($row_curorder["send_finothdoc"] == "mənfəət-zərər və s"){$accdoc = "selected";}
			if($row_curorder["send_finothdoc"] == "digər növ sənədlər"){$othtypdoc = "selected";}
			if($row_curorder["product_name"] == "Mini kredit"){$minicr = "selected";}
			if($row_curorder["product_name"] == "Kart krediti"){$carcdr = "selected";}
			if($row_curorder["product_name"] == "Lombard krediti"){$lombcr = "selected";}
			if($row_curorder["product_name"] == "Avtomobil krediti"){$vehicr = "selected";}
			if($row_curorder["product_name"] == "Təcili kredit"){$urgecr = "selected";}
			if($row_curorder["product_name"] == "Təcili kart"){$urgcarcr = "selected";}
			if($row_curorder["product_name"] == "Əmlak krediti"){$flatcr = "selected";}
			if($row_curorder["product_name"] == "KOB krediti"){$kobcr = "selected";}		
			if($row_curorder["cre_currency"] == "AZN"){$azn = "selected";}
			if($row_curorder["cre_currency"] == "USD"){$usd = "selected";}
			if($row_curorder["cre_currency"] == "EUR"){$eur = "selected";}
			if($row_curorder["ple_currency"] == "AZN"){$plazn = "selected";}
			if($row_curorder["ple_currency"] == "USD"){$plusd = "selected";}
			if($row_curorder["ple_currency"] == "EUR"){$pleur = "selected";}
			if($row_curorder["ple_currency"] == ""){$novalue = "selected";}
			if($row_curorder["ple_type"] == "daşınmaz əmlak"){$house = "selected";}
			if($row_curorder["ple_type"] == "avtomobil"){$car = "selected";}
			if($row_curorder["ple_type"] == "avadanlıq"){$mech = "selected";}
			if($row_curorder["ple_type"] == "depozit"){$depos = "selected";}
			if($row_curorder["ple_type"] == "zinət əşyası"){$golden = "selected";}
			if($row_curorder["ple_type"] == "zaminlik"){$guaranteee = "selected";}
			if($row_curorder["ple_type"] == "dövriyyədəki mal"){$goodies = "selected";}
			if($row_curorder["ple_type"] == ""){$notype = "selected";}
		
			if($_SESSION['auth_ptype'] == 'Fiziki şəxs / Fərdi sahibkar'){
			echo '
			<div>
				<select name="form_famstatus" id="typestat" class="myselect" title="ailə statusunuz" '.$readable.'>
					<option value="evli" '.$single.'>evli</option>
					<option value="subay" '.$married.'>subay</option>
				</select>
			</div>
			<div>
				<input autocomplete="off" class="myselect" name="form_membercount" type="number" placeholder="ailə üzvü sayı" title="siz daxil ailə üzvü sayı" value="'.$row_curorder["fam_members"].'" '.$readable.'>
			</div>
			<div>
				<input autocomplete="off" class="myselect" name="form_collabcount" type="number" placeholder="ailədə işləyənlərin sayı" title="ailədə siz daxil işləyənlər" value="'.$row_curorder["fam_workers"].'" '.$readable.'>
			</div>
			<div>
				<input autocomplete="off" class="myselect" name="form_allprofit" type="number" placeholder="ailənin ümumi gəliri" title="ailənin ümumi orta aylıq qazancı" value="'.$row_curorder["oth_profit"].'" '.$readable.'>
			</div>
			<div>
				<input autocomplete="off" class="myselect" name="form_allexpense" type="number" placeholder="ailənin ümumi xərci" title="ailənin ümumi orta aylıq xərci" value="'.$row_curorder["oth_expense"].'" '.$readable.'>
			</div>
			<div>
				<input autocomplete="off" class="myselect" name="form_cooperation" type="text" placeholder="hazırki iş yeriniz" title="iş yerinizin tam  dolğun adı" onkeyup="this.value = this.value.toUpperCase();" value="'.$row_curorder["last_job"].'" '.$readable.'>
			</div>';}
			echo'
			<div>
				<input autocomplete="off" class="myselect" name="form_experience" type="number" placeholder="iş təcrübəniz(aylarla)" title="iş təcrübəniz(aylarla)" value="'.$row_curorder["j_experience"].'" '.$readable.'>
			</div>
			<div>
				<input autocomplete="off" class="myselect" name="form_myprofit" type="number" placeholder="aylıq gəliriniz" title="orta aylıq gəliriniz" value="'.$row_curorder["aver_profit"].'" '.$readable.'>
			</div>
			<div>
				<input autocomplete="off" class="myselect" name="form_recommend" type="text" placeholder="Bankı məsləhət bildi" onkeyup="this.value = this.value.toUpperCase();" title="bu bankı sizə kim/nə məsləhət bildi" value="'.$row_curorder["recommended"].'" '.$readable.'>
			</div>
			<div>
				<select name="form_finance" id="typefindoc" class="myselect" title="yükləyəcəyiniz əsas maliyyə sənədi" '.$readable.'>
					<option value="iş yerindən arayış" '.$jobdoc.'>iş yerindən arayış</option>
					<option value="bəyannamə" '.$taxdoc.'>bəyannamə</option>
					<option value="digər" '.$othdoc.'>digər</option>
				</select>
			</div>
			<div>
				<select name="form_otherfin" id="typeotherdoc" class="myselect" title="yükləyəcəyiniz yardımçı maliyyə sənədi" '.$readable.'>
					<option value="hesabdan çıxarış" '.$saldoc.'>hesabdan çıxarış</option>
					<option value="mənfəət-zərər və s" '.$accdoc.'>mənfəət-zərər və s</option>
					<option value="digər növ sənədlər" '.$othtypdoc.'>digər növ sənədlər</option>
				</select>
			</div>
			<div>
				<input autocomplete="off" class="myselect" name="form_credaim" type="text" placeholder="kreditin məqsədi" onkeyup="this.value = this.value.toUpperCase();" title="kredit nə məqsədlə götürülür" value="'.$row_curorder["cre_aim"].'" '.$readable.'>
			</div>
		</div>
		<div id="rightblock">
			<div>
				<select name="form_creproduct" id="typecreproduct" class="myselect" title="seçdiyiniz kredit məhsulu" '.$readable.'>
					<option value="Mini kredit" '.$minicr.'>Mini kredit</option>
					<option value="Kart krediti" '.$carcdr.'>Kart krediti</option>
					<option value="Lombard krediti" '.$lombcr.'>Lombard krediti</option>
					<option value="Avtomobil krediti" '.$vehicr.'>Avtomobil krediti</option>
					<option value="Təcili kredit" '.$urgecr.'>Təcili kredit</option>
					<option value="Təcili kart" '.$urgcarcr.'>Təcili kart</option>
					<option value="Əmlak krediti" '.$flatcr.'>Əmlak krediti</option>
					<option value="KOB krediti" '.$kobcr.'>KOB krediti</option>
				</select>
			</div>
			<div>
				<input autocomplete="off" class="myselect" name="form_amount" type="number" placeholder="kreditin məbləği" title="kreditin məbləği" value="'.$row_curorder["cre_amount"].'" '.$readable.'>
			</div>
			<div>
				<select name="form_credcur" id="typecurrency" class="myselect" title="kreditin valyutası" '.$readable.'>
					<option value="AZN" '.$azn.'>manat</option>
					<option value="USD" '.$usd.'>ABŞ dolları</option>
					<option value="EUR" '.$eur.'>avro</option>
				</select>
			</div>
			<div>
				<input autocomplete="off" class="myselect" name="form_period" type="number" placeholder="kreditin müddəti(aylarla)" title="kreditin müddəti(aylarla)" value="'.$row_curorder["cre_period"].'" '.$readable.'>
			</div>
			<div>
				<textarea name="form_discount" placeholder="güzəşt istəyiniz" title="müddət, aylıq ödənişdə güzəşt barədə" '.$readable.'>'.$row_curorder["cre_concession"].'</textarea>
			</div>';
			if(isset($row_curorder["ple_type"])){ echo'
			<div>
				<select name="form_pledgetype" id="typepledge" class="myselect" title="girovun tipi" '.$readable.'>
					<option value="" '.$notype.' disabled>girovun tipini seçin</option>
					<option value="daşınmaz əmlak" '.$house.'>daşınmaz əmlak</option>
					<option value="avtomobil" '.$car.'>avtomobil</option>
					<option value="avadanlıq" '.$mech.'>avadanlıq</option>
					<option value="depozit" '.$depos.'>depozit</option>
					<option value="zinət əşyası" '.$golden.'>depozit</option>
					<option value="dövriyyədəki mal" '.$goodies.'>depozit</option>
					<option value="zaminlik" '.$guaranteee.'>zaminlik</option>
				</select>
			</div>
			<div>
				<input autocomplete="off" class="myselect" name="form_pledvalue" type="number" placeholder="girovun təqribi qiyməti" title="girovun hazırki bazar dəyəri" value="'.$row_curorder["ple_value"].'" '.$readable.'>
			</div>
			<div>
				<select name="form_pledcur" id="typecurrency" class="myselect" title="girovun valyutası" '.$readable.'>
					<option value="" '.$novalue.' disabled>girovun valyutası</option>
					<option value="AZN" '.$plazn.'>manat</option>
					<option value="USD" '.$plusd.'>ABŞ dolları</option>
					<option value="EUR" '.$pleur.'>avro</option>
				</select>
			</div>
			<div>
				<textarea name="form_pledinfo" placeholder="girov barədə" title="girov barədə təfsialtı əlavə məlumatlar" '.$readable.'>'.$row_curorder["ple_information"].'</textarea>
			</div>';}
			if($row_curorder['client_decision'] == 'təsdiq'){
			echo '
			<div>
				<textarea name="form_rejreason" placeholder="imtina etməyinizin səbəbi" title="hansı səbəblə imtina edirsiniz"></textarea>
			</div>';}
			echo '<div><input type="submit" name="'.$namechange.'" id="form_submit" value="'.$subchange.'"></div>
		</div>
		</form>';
		} ?>
	</div>
</div>