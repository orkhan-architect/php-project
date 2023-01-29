<?php defined('mcsystem') or die('Cəhdin yaxşı idi, sərf etdiyin vaxtı başqa şeyə sərf et!'); ?>
<div class="row row-cols-1">
    <div class="col-md-12 text-center" id="block-form-registration">
	<?php 
	if($_SESSION['msg']){
		echo $_SESSION['msg'];
		unset($_SESSION['msg']);
	};
	if($_SESSION['auth'] == 'yes_auth' && $_SESSION['auth_status'] == 'baxıldı'){
		$readable = "disabled";
	}
	else{
		$readable = "";	
	}
	
	$forprofile = mysqli_query($connect_link,"SELECT * FROM cstmr_data WHERE login='{$_SESSION['auth_login']}'");
	if(mysqli_num_rows($forprofile) > 0){
		$rowsforprofile = mysqli_fetch_assoc($forprofile);
	}
	?>
		<form method="post"><br>		
		<div id="leftblock">
			<div>
				<input class="myselect" name="profil_client" type="text" value="<?php echo $_SESSION['auth_client']; ?>" <?php echo $readable; ?>>
			</div>
			<?php 
			if($_SESSION['auth_ptype'] == 'Hüquqi şəxs'){echo '
			<div>
				<input class="myselect" name="profil_bosstype" type="text" value="'.$rowsforprofile['ceo_post'].'" '.$readable.'>
			</div>
			<div>
				<input class="myselect" name="profil_bossinit" type="text" value="'.$rowsforprofile['ceo_init'].'" '.$readable.'>
			</div>';
			}
			if($_SESSION['auth_ptype'] == 'Fiziki şəxs / Fərdi sahibkar'){echo '
			<div>
				<input class="myselect" name="profil_docserinum" type="text" value="'.$rowsforprofile['doc_sernum'].'" '.$readable.'>
			</div>
			<div>
				<input class="myselect" name="profil_docgovername" type="text" value="'.$rowsforprofile['doc_govname'].'" '.$readable.'>
			</div>';
			}
			?>
			<div>
				<textarea name="profil_ladres" placeholder="Yaşayış (fəaliyyət) ünvanı" title="Yaşayış (fəaliyyət) ünvanı"><?php echo $rowsforprofile['liv_address']; ?></textarea>
			</div>
			<div>
				<input autocomplete="off" class="myselect" name="profil_phonumb" type="text" placeholder="Telefon nömrələri" title="Əlavə telefon nömrələri" value="<?php echo $rowsforprofile['phone']; ?>">
			</div>
			<div>
				<input class="myselect" name="profil_verificatornum" type="text" value="<?php echo $rowsforprofile['myphone']; ?>" title="təsdiq kodunuzun gələcəyi əsas mobil nömrəniz" <?php echo $readable; ?>>
			</div>
			<div>
				<input autocomplete="off" class="myselect" name="profil_email" type="text" placeholder="Email ünvanı" title="Email ünvanınız" value="<?php echo $rowsforprofile['email']; ?>">
			</div>
			<div>
				<input type="password" name="profi_pasvor" class="login_pass" placeholder="Köhnə şifrə">
			</div>
			<div>
				<input type="password" name="profi_nepasvor" class="login_pass" placeholder="Yeni şifrə">
			</div>
		</div>
		<div id="rightblock">
			<?php 
			if($_SESSION['auth_ptype'] == 'Hüquqi şəxs'){echo '
			<div>
				<input class="myselect" name="profil_sharhol" type="text" value="'.$rowsforprofile['shareholders'].'" '.$readable.'>
			</div>
			<div>
				<input class="myselect" name="profil_sharport" type="text" value="'.$rowsforprofile['sh_portion'].'" '.$readable.'>
			</div>
			<div>
				<input class="myselect" name="profil_busispher" type="text" value="'.$rowsforprofile['business_sphere'].'" '.$readable.'>
			</div>';
			}
			if($_SESSION['auth_ptype'] == 'Fiziki şəxs / Fərdi sahibkar'){echo '
			<div>
				<input class="myselect" name="profil_docredate" type="date" title="Vəsiqənin verilmə tarixi" value="'.$rowsforprofile['doc_regdate'].'" '.$readable.'>
			</div>
			<div>
				<input class="login_pass" name="profil_individ" type="text" title="Sahibkar VÖENiniz" value="'.$rowsforprofile['ind_taxesid'].'" '.$readable.'>
			</div>';
			}
			?>
			<div>
				<input class="myselect" name="profil_bodate" type="date" title="Doğum (fəaliyyət) tarixi" value="<?php echo $rowsforprofile['born_date']; ?>" <?php echo $readable; ?>>
			</div>
			<div>
				<textarea name="profil_radres" <?php echo $readable; ?>><?php echo $rowsforprofile['reg_address']; ?></textarea>
			</div>
			<?php 
			$therefor = mysqli_query($connect_link,"SELECT customer_notes, debtor, guarantor, mortgagor FROM cstmr_data WHERE login='{$_SESSION['auth_login']}'");
			if(mysqli_num_rows($therefor) > 0){
				$rowstherefor = mysqli_fetch_assoc($therefor);
				if($rowstherefor["debtor"] == 'Borcalan') {$debetorcheck = 'checked';}
				if($rowstherefor["guarantor"] == 'Zamin') {$guarantorcheck = 'checked';}
				if($rowstherefor["mortgagor"] == 'Girovqoyan') {$mortgagorcheck = 'checked';}
			echo '
			<div>
				<select name="profil_lesscap" class="myselect" title="aztəminatlı ailəsinizmi">
					<option value="" selected disabled>aztəminatlı ailəsinizmi</option>
					<option value="bəli">Bəli</option>
					<option value="xeyr">Xeyr</option>
				</select>
			</div>
			<div>
				<select name="profil_invalid" class="myselect" title="əlilliyiniz varmı">
					<option value="" selected disabled>əlilliyiniz varmı</option>
					<option value="bəli">Bəli</option>
					<option value="xeyr">Xeyr</option>
				</select>
			</div>
			<div>
				<textarea name="profil_clientnotes" placeholder="Xüsusi qeydləriniz">'.$rowstherefor["customer_notes"].'</textarea>
			</div>
			<div>
				<input type="checkbox" id="pborrower" name="pborrower" value="Borcalan" '.$debetorcheck.'>
				<label for="pborrower">Borcalan kimi qeydiyyat</label>
			</div>
			<div>
				<input type="checkbox" id="pguarant" name="pguarant" value="Zamin" '.$guarantorcheck.'>
				<label for="pguarant">Zamin kimi qeydiyyat</label>
			</div>
			<div>
				<input type="checkbox" id="pcoll" name="pcoll" value="Girovqoyan" '.$mortgagorcheck.'>
				<label for="pcoll">Girovqoyan kimi qeydiyyat</label>
			</div>';}
				?>
			<div><input type="submit" name="save_submit" id="form_submit" value="Dəyiş"></div>
		</div>
		</form>
	</div>
</div>