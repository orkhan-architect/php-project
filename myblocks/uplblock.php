<?php defined('mcsystem') or die('Cəhdin yaxşı idi, sərf etdiyin vaxtı başqa şeyə sərf et!'); ?>
<div class="row row-cols-1">
    <div class="col-md-12 text-center">
		<form id="frmEnquiry" action="" method="post" enctype='multipart/form-data'><br>
			<div id="mail-status"></div>
			<?php echo $_POST["userName"]; ?>
			<div id="leftblock">
				<div>
					<input style="display: none;" class="myselect" name="userName" id="userName" value="<?php echo $_SESSION['auth_login']; ?>" type="text">
				</div>
				<div>
					<input class="myselect" name="subject" id="subject" placeholder="Başlıq" type="text">
				</div>
				<div>
					<textarea class="myselect" name="content" id="content" cols="60" rows="6" placeholder="Təsdiqləyici kodunuz"></textarea>
				</div>
			</div>
			<div id="rightblock">
				<div>
					<input style="display: none;" class="myselect" name="userEmail" id="userEmail" value="<?php echo $_SESSION['auth_clmails']; ?>" type="text">
				</div>
				<div>
					<input type="file" name="attachment[]" class="myselect" multiple="multiple">
				</div>
				<div>
					<input type="submit" value="Göndər" class="btnAction">
				</div>
			</div>
		</form>
		<div id="loader-icon" style="display: none;">
    		<img src="../imgs/LoaderIcon.gif">
		</div>
	</div>
</div>