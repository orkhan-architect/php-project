<?php defined('mcsystem') or die('Cəhdin yaxşı idi, sərf etdiyin vaxtı başqa şeyə sərf et!'); ?>
<div class="row row-cols-1">
    <div class="col-md-12 text-center" id="block-form-registration">
		<form method="post" id="form_reg" action="../ord/handler_reg.php"><br>	
		<div id="leftblock">
			<?php if($_SESSION['auth_ptype'] == 'Fiziki şəxs / Fərdi sahibkar'){ echo '
			<div>
				<select name="form_famstatus" id="typestat" class="myselect">
					<option value="" selected disabled>ailə statusunuz</option>
					<option value="evli">evli</option>
					<option value="subay">subay</option>
				</select>
			</div>
			<div>
				<input autocomplete="off" class="myselect" name="form_membercount" type="number" placeholder="ailə üzvü sayı" title="siz daxil ailə üzvü sayı">
			</div>
			<div>
				<input autocomplete="off" class="myselect" name="form_collabcount" type="number" placeholder="ailədə işləyənlərin sayı" title="ailədə siz daxil işləyənlər">
			</div>
			<div>
				<input autocomplete="off" class="myselect" name="form_allprofit" type="number" placeholder="ailənin ümumi gəliri" title="ailənin ümumi orta aylıq qazancı">
			</div>
			<div>
				<input autocomplete="off" class="myselect" name="form_allexpense" type="number" placeholder="ailənin ümumi xərci" title="ailənin ümumi orta aylıq xərci">
			</div>
			<div>
				<input autocomplete="off" class="myselect" name="form_cooperation" type="text" placeholder="hazırki iş yeriniz" title="iş yerinizin tam  dolğun adı" onkeyup="this.value = this.value.toUpperCase();">
			</div>';} 
			?>
			<div>
				<input autocomplete="off" class="myselect" name="form_experience" type="number" placeholder="iş təcrübəniz(aylarla)">
			</div>
			<div>
				<input autocomplete="off" class="myselect" name="form_myprofit" type="number" placeholder="aylıq gəliriniz">
			</div>
			<div>
				<input autocomplete="off" class="myselect" name="form_recommend" type="text" placeholder="Bankı məsləhət bildi" onkeyup="this.value = this.value.toUpperCase();" title="bu bankı sizə kim/nə məsləhət bildi">
			</div>
			<div>
				<select name="form_finance" id="typefindoc" class="myselect">
					<option value="" selected disabled>əsas maliyyə sənədiniz</option>
					<option value="iş yerindən arayış">iş yerindən arayış</option>
					<option value="bəyannamə">bəyannamə</option>
					<option value="digər">digər</option>
				</select>
			</div>
			<div>
				<select name="form_otherfin" id="typeotherdoc" class="myselect">
					<option value="" selected disabled>digər maliyyə sənədiniz</option>
					<option value="hesabdan çıxarış">hesabdan çıxarış</option>
					<option value="mənfəət-zərər və s">mənfəət-zərər və s</option>
					<option value="digər növ sənədlər">digər növ sənədlər</option>
				</select>
			</div>
			<div>
				<input autocomplete="off" class="myselect" name="form_credaim" type="text" placeholder="kreditin məqsədi" onkeyup="this.value = this.value.toUpperCase();" title="kredit nə məqsədlə götürülür">
			</div>
			<div id="block-captcha">
				<img src="../ord/reg_captcha.php">
				<input autocomplete="off" class="myselect" type="text" name="captcha_code" id="captcha_code" placeholder="simvolları yaz">
				<p id="reloadcaptcha">Yeniləmək</p>
			</div>
		</div>
		<div id="rightblock">
			<div>
				<select name="form_creproduct" id="typecreproduct" class="myselect">
					<option value="" selected disabled>kredit məhsulu</option>
					<?php 
	$product_result = mysqli_query($connect_link,"SELECT product_name, product_type FROM crdt_category"); 
	if(mysqli_num_rows($product_result) > 0){
		$product_row = mysqli_fetch_assoc($product_result);
		do{ echo '
			<option value="'.$product_row["product_name"].'">'.$product_row["product_type"].' - '.$product_row["product_name"].'</option>';
		}
		while($product_row = mysqli_fetch_assoc($product_result));} 
					?>
				</select>
			</div>
			<div>
				<input autocomplete="off" class="myselect" name="form_amount" type="number" placeholder="kreditin məbləği">
			</div>
			<div>
				<select name="form_credcur" id="typecurrency" class="myselect">
					<option value="" selected disabled>kreditin valyutası</option>
					<option value="AZN">manat</option>
					<option value="USD">ABŞ dolları</option>
					<option value="EUR">avro</option>
				</select>
			</div>
			<div>
				<input autocomplete="off" class="myselect" name="form_period" type="number" placeholder="kreditin müddəti(aylarla)">
			</div>
			<div>
				<textarea name="form_discount" placeholder="güzəşt istəyiniz" title="müddət, aylıq ödənişdə güzəşt barədə"></textarea>
			</div>
			<div>
				<select name="form_exst" id="pledge_exist" class="myselect">
					<option value="" selected disabled>girov təqdim edilirmi</option>
					<option value="bəli">bəli</option>
					<option value="xeyr">xeyr</option>
				</select>
			</div>
			<div class="show-hide">
				<select name="form_pledgetype" id="typepledge" class="myselect">
					<option value="" selected disabled>girov tipini seç</option>
					<option value="daşınmaz əmlak">daşınmaz əmlak</option>
					<option value="avtomobil">avtomobil</option>
					<option value="avadanlıq">avadanlıq</option>
					<option value="depozit">depozit</option>
					<option value="zinət əşyası">zinət əşyası</option>
					<option value="dövriyyədəki mal">dövriyyədəki mal</option>
					<option value="zaminlik">zaminlik</option>
				</select>
			</div>
			<div class="show-hide">
				<input autocomplete="off" class="myselect" name="form_pledvalue" type="number" placeholder="girovun təqribi qiyməti" title="girovun hazırki bazar dəyəri">
			</div>
			<div class="show-hide">
				<select name="form_pledcur" id="typecurrency" class="myselect">
					<option value="" selected disabled>girovun valyutası</option>
					<option value="AZN">manat</option>
					<option value="USD">ABŞ dolları</option>
					<option value="EUR">avro</option>
				</select>
			</div>
			<div class="show-hide">
				<textarea name="form_pledinfo" placeholder="girov barədə" title="təfsialtı əlavə məlumatlar"></textarea>
			</div>
			<div>
				<select name="form_cruser" id="typeuser" class="myselect">
					<option value="" selected disabled>kredit əməkdaşları</option>
					<?php 
			$branch = $_SESSION['mybranch_status'];
			$users_result = mysqli_query($connect_link,"SELECT login, nsp FROM users WHERE role='user' AND branch='$branch'"); 
			if(mysqli_num_rows($users_result) > 0){
				$users_row = mysqli_fetch_assoc($users_result);
				do{
					echo '<option value="'.$users_row["login"].'">'.$users_row["nsp"].'</option>';
				}
				while($users_row = mysqli_fetch_assoc($users_result));}
					?>
				</select>
			</div>
			<div>
				<input type="checkbox" id="acbagr" name="acbagr" value="razıyam">
				<label for="acbagr">AKB-dən kredit tarixçəm barədə məlumatların alınmasına etiraz etmirəm</label>
			</div>
			<?php if($_SESSION['auth_ptype'] == 'Fiziki şəxs / Fərdi sahibkar'){ echo '
			<div>
				<input type="checkbox" id="jobdoc" name="jobdoc" value="razıyam">
				<label for="jobdoc">Hökumət portalı üzərindən elektron iş arayışımın alınmasına etiraz etmirəm</label>
			</div>';}
			?>
			<div><input type="submit" name="reg_submit" id="form_submit" value="Sifariş et"></div>
		</div>
		</form>
	</div>
</div>