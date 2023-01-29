<?php 
define('mcsystem', true);
session_start();
if ($_SESSION['auth'] == 'yes_auth' && $_SESSION['bosverify_status'] == 'yes'){
	include("myblocks/db_connect.php");
	include("myblocks/defend.php");

	$id = mysqli_real_escape_string($connect_link,defend_input($_GET["id"]));
	
	if($_POST["verify_submit"]){
		
		$error = array();
		
		if($_SESSION['auth_ptype'] == 'Fiziki şəxs / Fərdi sahibkar'){
			
		$fstatus = mysqli_real_escape_string($connect_link,defend_input($_POST['form_famstatus']));		
		$fmember = mysqli_real_escape_string($connect_link,defend_input($_POST['form_membercount']));	
		$fcollab = mysqli_real_escape_string($connect_link,defend_input($_POST['form_collabcount']));
		$fprofit = mysqli_real_escape_string($connect_link,defend_input($_POST['form_allprofit']));
		$fexpense = mysqli_real_escape_string($connect_link,defend_input($_POST['form_allexpense']));
		$fcooper = mysqli_real_escape_string($connect_link,defend_input($_POST['form_cooperation']));
		
		if(!$fstatus){$error[] = "Evli və ya subay olmağınızı qeyd edin!";}
		if(!$fmember){$error[] = "Siz daxil ailə üzvlərinizin sayını qeyd edin!";}
		if(!$fcollab){$error[] = "Ailədə siz daxil işləyənlərin sayını qeyd edin!";}
		if(!$fprofit){$error[] = "Ailənizin siz daxil ümumi aylıq gəlirini qeyd edin!";}
		if(!$fexpense){$error[] = "Ailənizin siz daxil ümumi aylıq xərcini qeyd edin!";}
		if(!$fcooper){$error[] = "İş yerinizi tam və dolğun formada qeyd edin!";}
		
		$personality = "fam_status='".$fstatus."', fam_members='".$fmember."', fam_workers='".$fcollab."', oth_profit='".$fprofit."', oth_expense='".$fexpense."', last_job='".$fcooper."',";
		}
		else { $personality = ""; }
		
		if(isset($_POST['form_pledgetype'])){
		
		$pltype = mysqli_real_escape_string($connect_link,defend_input($_POST['form_pledgetype']));		
		$plvalue = mysqli_real_escape_string($connect_link,defend_input($_POST['form_pledvalue']));		
		$plcur = mysqli_real_escape_string($connect_link,defend_input($_POST['form_pledcur']));		
		$plinfo = mysqli_real_escape_string($connect_link,defend_input($_POST['form_pledinfo']));
			
		if(!$pltype){$error[] = "Təklif edəcəyiniz girov tipini seçin!";}
		if(!$plvalue){$error[] = "Girovun hazırki bazar dəyərini qeyd edin!";}
		if(!$plcur){$error[] = "Təklif edəcəyiniz girovun valyutasını qeyd edin!";}
		if(!$plinfo){$error[] = "Girovunuzu ətraflı xarakterizə edin!";}
		
		$pledgemenu = "ple_type='".$pltype."', ple_value='".$plvalue."', ple_currency='".$plcur."', ple_information='".$plinfo."',";
		}
		else{ $pledgemenu =""; }
		
		$exper = mysqli_real_escape_string($connect_link,defend_input($_POST['form_experience']));
		$mypro = mysqli_real_escape_string($connect_link,defend_input($_POST['form_myprofit']));
		$recom = mysqli_real_escape_string($connect_link,defend_input($_POST['form_recommend']));
		$fin = mysqli_real_escape_string($connect_link,defend_input($_POST['form_finance']));
		$othfin = mysqli_real_escape_string($connect_link,defend_input($_POST['form_otherfin']));
		$aim = mysqli_real_escape_string($connect_link,defend_input($_POST['form_credaim']));
		$productn = mysqli_real_escape_string($connect_link,defend_input($_POST['form_creproduct']));
		$cramount = mysqli_real_escape_string($connect_link,defend_input($_POST['form_amount']));
		$crcur = mysqli_real_escape_string($connect_link,defend_input($_POST['form_credcur']));
		$crper = mysqli_real_escape_string($connect_link,defend_input($_POST['form_period']));
		$crdis = mysqli_real_escape_string($connect_link,defend_input($_POST['form_discount']));
		
		if(!$exper){$error[] = "İş (fəaliyyət) təcrübənizi aylarla qeyd edin!";}		
		if(!$mypro){$error[] = "Orta aylıq qazancınızı, mənfəətinizi qeyd edin!";}		
		if(!$recom){$error[] = "Bizim bankı necə tapdınız!";}		
		if(!$fin){$error[] = "Yükləyəcəyiniz əsas maliyyə sənədinizi qeyd edin!";}		
		if(!$othfin){$error[] = "Yükləyəcəyiniz digər maliyyə sənədlərinizi qeyd edin!";}	
		if(!$aim){$error[] = "Kredit almaqda məqsədinizi qeyd edin!";}
		if(!$productn){$error[] = "Seçdiyiniz kredit məhsulunu qeyd edin!";}
		if(!$cramount){$error[] = "Məhsula uyğun kredit məbləğini qeyd edin!";}		
		if(!$crcur){$error[] = "Məhsula uyğun kreditinizin valyutasını qeyd edin!";}		
		if(!$crper){$error[] = "Məhsula uyğun kreditin müddətini təyin edin!";}		
		
		if(count($error)){
			$_SESSION['msg'] = "<p id='form-error'>".implode('<br>',$error)."</p>";
		}
		else{
        	$_SESSION['msg'] = "<p id='form-success'>Təsdiq uğurla həyata keçdi!</p>";
			$dataquery = $personality.$pledgemenu."j_experience='".$exper."', aver_profit='".$mypro."', recommended='".$recom."', send_findoc='".$fin."', send_finothdoc='".$othfin."', cre_aim='".$aim."', product_name='".$productn."', cre_amount='".$cramount."', cre_currency='".$crcur."', cre_period='".$crper."', cre_concession='".$crdis."', client_decision='təsdiq', verify_datetime=NOW()";
			
			$update = mysqli_query($connect_link,"UPDATE cre_orders SET $dataquery WHERE client = '{$_SESSION['auth_login']}' AND id='$id'");        
		}       
	}
	if($_POST["reject_submit"]){
		$error = array();
		$rejres = mysqli_real_escape_string($connect_link,defend_input($_POST['form_rejreason']));
		if(!$rejres){$error[] = "İmtina səbənizi mütləq qeyd edin!";}		
		if(count($error)){
			$_SESSION['msg'] = "<p id='form-error'>".implode('<br>',$error)."</p>";
		}
		else{
			$_SESSION['msg'] = "<p id='form-success'>Çox təəssüf ki, sifarişinizi imtina etdiniz!</p>";
			$dataquery = "reject_reason='".$rejres."', client_decision='imtina', reject_datetime=NOW()";		
			$update = mysqli_query($connect_link,"UPDATE cre_orders SET $dataquery WHERE client = '{$_SESSION['auth_login']}' AND id='$id'");
		}
	}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="css/mystyles.css">
<title>T.O.M. CCS - sifariş üzərində iş</title>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
<script src="jscript/myscripts.js"></script>
</head>

<body>
	<div class="container">
		<?php include("myblocks/navblock.php")?>
		<button type="button" class="btn btn-danger w-100" data-toggle="collapse" data-target="#openclose">PROFİLƏ GİRİŞ görüntüsünü aç/bağla</button>
		<div id="openclose" class="collapse">
			<div class="container">
				<?php include("myblocks/headblock.php")?>
			</div>
		</div>
		<div class="container">
			<?php include("myblocks/verifyblock.php")?>
		</div>
		<button style="font-size: 19px;" type="button" class="btn btn-success w-100 mt-2 font-weight-bold" data-toggle="collapse" data-target="#openclosehm">Sifarişə yardımçı məlumatları göstər/gizlət</button>
		<div id="openclosehm" class="collapse">
			<div class="container">
				<?php include("myblocks/ordernotesblock.php")?>
			</div>
		</div>
		<div class="container">
			<?php include("myblocks/authorblock.php")?>
		</div>
	</div>
</body>
</html>
<?php 
}
else{
	header("Location: index");
} 
?>