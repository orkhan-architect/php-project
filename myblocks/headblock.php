<?php defined('mcsystem') or die('Cəhdin yaxşı idi, sərf etdiyin vaxtı başqa şeyə sərf et!'); ?>
<div class="row row-cols-1">
    <div class="col-md-12 text-center">
	<?php 
	if($_SESSION['auth'] == 'yes_auth' && $_SESSION['auth_status'] == 'baxıldı'){ echo '
		<div id="auth-user-info">
			<img src="../imgs/user.png">Salam, '.$_SESSION['auth_client'].'!
		</div>';
		if($_SESSION['bosverify_status'] == 'yes'){ echo '
		<div id="profilog">
			<img src="../imgs/user_info.png"><a href="profile">Profilim</a>
		</div>';
		}
		echo '
		<div id="exitlog">
			<img src="../imgs/logout.png"><a id="logout">Çıxış</a>
		</div>';
	}
	else{ echo '  
		<form method="post">
			<div id="logincol">
				<div id="entr">Giriş</div>
				<div>
					<input type="checkbox" name="rememberme" id="rememberme">
					<label for="rememberme">Məni yadda saxla</label>
				</div>
				<div id="message-auth">Login və(ya) Şifrə səhvdir</div>
				<div>
					<input autocomplete="off" id="auth_login" type="text" class="login_pass" placeholder="Login (PIN və ya VÖEN)" onkeyup="this.value = this.value.toUpperCase();">
				</div>
				<div>
					<input id="auth_pass" type="password" class="login_pass" placeholder="Şifrə">
					<span id="button-pass-show-hide" class="pass-show"></span>
				</div>
				<div id="remindme">
					<div>
						<a id="remindpass" href="#">Şifrəni unutmusunuz?</a>
					</div>
				</div>
				<p id="button-auth"><a>Daxil ol</a></p>
				<p class="auth-loading"><img src="../imgs/loading.gif"></p>
			</div>
		</form>
		<div id="block-remind">
			<div id="entr">Şifrənin bərpası</div>
			<div id="message-remind" class="message-remind-success"></div>
			<div>
				<input autocomplete="off" type="text" id="remind-email" class="login_pass" placeholder="Sizin E-mail">
			</div>				
			<div id="button-remind"><a>Hazırdır</a></div>
			<p class="auth-loading"><img src="../imgs/loading.gif"></p>
			<div id="prev-auth">Geriyə</div>
		</div>';
	}	
	?>
	</div>
</div>