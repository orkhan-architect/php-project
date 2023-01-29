<?php defined('mcsystem') or die('Cəhdin yaxşı idi, sərf etdiyin vaxtı başqa şeyə sərf et!'); ?>
<div class="row row-cols-1">
    <div class="col-md-12 text-center" id="block-form-registration">
		<form method="post" id="form_reg" action="../reg/handler_reg.php"><br>		
		<div id="leftblock">
			<div>
				<select name="form_persontype" id="typepers" class="myselect">
					<option value="" selected disabled>müştəri tipini seçin</option>
					<option value="Fiziki şəxs / Fərdi sahibkar">Vətəndaş / Sahibkar</option>
					<option value="Hüquqi şəxs">Şirkət</option>
				</select>
			</div>
			<div>
				<input autocomplete="off" class="myselect" name="form_client" type="text" placeholder="İnisial (ASA və ya şirkət)" onkeyup="this.value = this.value.toUpperCase();">
			</div>
			<div>
				<select name="form_lesscap" class="myselect" title="aztəminatlı ailəsinizmi">
					<option value="" selected disabled>aztəminatlı ailəsinizmi</option>
					<option value="bəli">Bəli</option>
					<option value="xeyr">Xeyr</option>
				</select>
			</div>
			<div class="companyhide">
				<input autocomplete="off" class="myselect" name="form_bosstype" type="text" placeholder="İdarəedən şəxsin vəzifəsi" onkeyup="this.value = this.value.toUpperCase();">
			</div>
			<div class="companyhide">
				<input autocomplete="off" class="myselect" name="form_bossinit" type="text" placeholder="Vəzifəli şəxsin ASA" onkeyup="this.value = this.value.toUpperCase();">
			</div>
			<div class="citizenhide">
				<input autocomplete="off" class="myselect" name="form_docserinum" type="text" placeholder="Vəsiqənin seriya və kodu" onkeyup="this.value = this.value.toUpperCase();">
			</div>
			<div class="citizenhide">
				<input autocomplete="off" class="myselect" name="form_docgovername" type="text" placeholder="Vəsiqəni verən orqan" onkeyup="this.value = this.value.toUpperCase();">
			</div>
			<div>
				<textarea name="form_ladres" placeholder="Yaşayış (fəaliyyət) ünvanı"></textarea>
			</div>
			<div>
				<textarea name="form_radres" placeholder="Qeydiyyat ünvanı"></textarea>
			</div>
			<div>
				<input autocomplete="off" class="myselect" name="form_email" type="text" placeholder="Email ünvanı">
			</div>
			<div class="companyhide">
				<input autocomplete="off" class="myselect" name="form_business" type="text" placeholder="Fəaliyyət sahəniz">
			</div>
			<div>
				<input class="myselect" name="form_bodate" type="date" title="Doğum (fəaliyyət) tarixi (ay/gün/il)">
			</div>
			<div id="block-captcha">
				<img src="../reg/reg_captcha.php">
				<input autocomplete="off" class="myselect" type="text" name="captcha_code" id="captcha_code" placeholder="simvolları yaz">
				<p id="reloadcaptcha">Yeniləmək</p>
			</div>
		</div>
		<div id="rightblock">
			<div>
				<select name="form_branch" id="typeuser" class="myselect" title="qeydiyyat üçün filial seçin">
					<option value="" selected disabled>filial şəbəkəmiz</option> 
			<?php 
			$branches_result = mysqli_query($connect_link,"SELECT branch, branch_fullname FROM users WHERE role='verifier'"); 
			if(mysqli_num_rows($branches_result) > 0){
				$branches_row = mysqli_fetch_assoc($branches_result);
				do{
					echo '<option value="'.$branches_row["branch"].'">'.$branches_row["branch_fullname"].'</option>';
				}
				while($branches_row = mysqli_fetch_assoc($branches_result));
			} ?>
				</select>
			</div>
			<div>
				<select name="form_invalid" class="myselect" title="əlilliyiniz varmı">
					<option value="" selected disabled>əlilliyiniz varmı</option>
					<option value="bəli">Bəli</option>
					<option value="xeyr">Xeyr</option>
				</select>
			</div>
			<div>
				<input autocomplete="off" class="myselect" name="form_verificatornum" type="text" placeholder="Təsdiqləyici mob. nömrəm" title="təsdiq kodunuzun gələcəyi əsas mobil nömrəniz">
			</div>
			<div>
				<input autocomplete="off" class="myselect" name="form_phonumb" type="text" placeholder="Telefon nömrələri">
			</div>
			<div class="companyhide">
				<input autocomplete="off" class="myselect" name="form_sharhol" type="text" placeholder="Təsisçilər ASA" onkeyup="this.value = this.value.toUpperCase();">
			</div>
			<div class="companyhide">
				<input autocomplete="off" class="myselect" name="form_sharport" type="text" placeholder="Təsisçilərin payı">
			</div>
			<div class="citizenhide">
				<input class="myselect" name="form_docredate" type="date" title="Vəsiqənin verilmə tarixi (ay/gün/il)">
			</div>
			<div class="citizenhide">
				<input autocomplete="off" class="login_pass" name="form_individ" type="text" placeholder="Sahibkarsınızsa VÖEN">
			</div>
			<div>
				<textarea name="form_clientnotes" placeholder="Xüsusi qeydləriniz"></textarea>
			</div>
			<div>
				<input type="checkbox" id="borrower" name="borrower" value="Borcalan">
				<label for="borrower">Borcalan kimi qeydiyyat</label>
			</div>
			<div>
				<input type="checkbox" id="guarant" name="guarant" value="Zamin">
				<label for="guarant">Zamin kimi qeydiyyat</label>
			</div>
			<div>
				<input type="checkbox" id="coll" name="coll" value="Girovqoyan">
				<label for="coll">Girovqoyan kimi qeydiyyat</label>
			</div>
			<div>
				<input autocomplete="off" class="login_pass" name="form_login" type="text" placeholder="Login (PIN və ya VÖEN)" onkeyup="this.value = this.value.toUpperCase();">
			</div>
			<div>
				<input type="password" name="form_pasvor" class="login_pass" placeholder="Şifrə">
			</div>
			<div><input type="submit" name="reg_submit" id="form_submit" value="Qeydiyyat"></div>
		</div>
		</form>
	</div>
</div>