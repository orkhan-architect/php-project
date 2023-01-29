<?php defined('mcsystem') or die('Cəhdin yaxşı idi, sərf etdiyin vaxtı başqa şeyə sərf et!'); ?>
<nav class="navbar navbar-expand-md bg-dark navbar-dark">
	<a class="navbar-brand" href="index">T.O.M. CCS</a>
 	<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar"><span class="navbar-toggler-icon"></span></button>
  	<div class="collapse navbar-collapse" id="collapsibleNavbar">
    	<ul class="navbar-nav">
			<li class="nav-item">
				<a class="nav-link" href="index">Anasəhifə</a>
      		</li>
			<li class="nav-item">
        		<a class="nav-link" href="branches">Filiallar</a>
      		</li>
		<?php 
		if($_SESSION['auth'] == 'yes_auth' && $_SESSION['bosverify_status'] == 'yes'){ echo '
			<li class="nav-item">
        		<a class="nav-link" href="myorder">Kredit sifariş</a>
      		</li>';
			$loanexist = mysqli_query($connect_link, "SELECT id FROM cre_data WHERE client = '{$_SESSION['auth_login']}'");
			if(mysqli_num_rows($loanexist) > 0){ echo '
			<li class="nav-item">
        		<a class="nav-link" href="myloans">Kreditlərim</a>
      		</li>';}
		}
		if($_SESSION['auth'] == 'yes_auth' && $_SESSION['auth_status'] == 'baxıldı'){ echo'			
			<li class="nav-item">
        		<a class="nav-link" href="uploadings">Yükləmələr</a>
      		</li>
			<li class="nav-item">
        		<a class="nav-link" href="notifications">Bildirişlər</a>
      		</li>';
		}
		else{ echo '
			<li class="nav-item">
				<a class="nav-link" href="registration">Qeydiyyat</a>
      		</li>';
		}
		?>
    	</ul>
  	</div>
</nav>