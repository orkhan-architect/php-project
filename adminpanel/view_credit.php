<?php 
define('mcsystem', true);
session_start();
if($_SESSION['auth_admin'] == "yes_auth"){      
	if(isset($_GET["logout"])){
		unset($_SESSION['auth_admin']);
        header("Location: login");
    }
	include("inc_blocks/dbblok.php");
	include("inc_blocks/functions.php");
	
	$id = mysqli_real_escape_string($connect_link,defend_input($_GET["id"]));
	
	if($_SESSION['bank_department'] == "system"){
		if($_POST["resetcre_submit"]){
		$_SESSION['msg'] = "<p id='form-success'>Kredit redaktə üçün geri qaytarıldı!</p>";
		$bosresetquery = "ofcer_docdate=null, verif_docdate=null, verified=null";
		$bosresetupdate = mysqli_query($connect_link, "UPDATE cre_data SET $bosresetquery WHERE id='$id'");
		}
	}
		
	if($_SESSION['users_role'] == 'manager' || $_SESSION['bank_department'] == "system"){
		if($_POST["verifiercre_submit"]){
		$sdate = mysqli_real_escape_string($connect_link,defend_input($_POST['startdate']));
		$edate = mysqli_real_escape_string($connect_link,defend_input($_POST['endate']));
		$credid = mysqli_real_escape_string($connect_link,defend_input($_POST['unicalcred']));
		$pday = mysqli_real_escape_string($connect_link,defend_input($_POST['payinday']));
		$credverifier = $_SESSION['auth_admin_login'];
		
		$error = array();
		
		if(!$sdate){$error[] = "kreditin qüvvəyə mindiyi tarixi qeyd edin!";}
		if(!$edate){$error[] = "kreditin qüvvədən düşdüyü tarixi qeyd edin!";}
		if(!$credid){$error[] = "kreditin unikal İD-ni qeyd edin!";}
		if(!$pday){$error[] = "kreditin ödəniş gününü qeyd edin!";}	
		
		if(count($error)){
			$_SESSION['msg'] = "<p id='form-error'>".implode('<br>',$error)."</p>";
		}
		else{
			$_SESSION['msg'] = "<p id='form-success'>Kredit təsdiqləndi!</p>";			
			$credver = "credit_startdate='".$sdate."', credit_enddate='".$edate."', unical_credid='".$credid."', payment_day='".$pday."', credit_status='aktiv', verified='yes', verif_docdate=NOW(), credit_verifier='".$credverifier."'";
			$credvercupdate = mysqli_query($connect_link, "UPDATE cre_data SET $credver WHERE id='$id'");
		}
	  }
	}
	
	if($_SESSION['users_role'] == 'user' || $_SESSION['bank_department'] == "system"){
		if($_POST["oficercre_submit"]){
			
		$customersel = mysqli_real_escape_string($connect_link,defend_input($_POST['customer_select']));
		$ordersel = mysqli_real_escape_string($connect_link,defend_input($_POST['order_select']));
		$productsel = mysqli_real_escape_string($connect_link,defend_input($_POST['product_select']));
		$creditmount = mysqli_real_escape_string($connect_link,defend_input($_POST['credit_sum']));
		$currencysel = mysqli_real_escape_string($connect_link,defend_input($_POST['currency_select']));
		$credperiod = mysqli_real_escape_string($connect_link,defend_input($_POST['cre_period']));
		$credpercentage = mysqli_real_escape_string($connect_link,defend_input($_POST['cre_percentage']));
		$credfypd = mysqli_real_escape_string($connect_link,defend_input($_POST['cre_fypd']));
		$penpercentage = mysqli_real_escape_string($connect_link,defend_input($_POST['penal_percentage']));
		$monthpayment = mysqli_real_escape_string($connect_link,defend_input($_POST['monthlypay']));
		$coeficent = mysqli_real_escape_string($connect_link,defend_input($_POST['dti_coef']));
		$rating = mysqli_real_escape_string($connect_link,defend_input($_POST['rating_select']));
		$contract = mysqli_real_escape_string($connect_link,defend_input($_POST['contract_select']));
		$source = mysqli_real_escape_string($connect_link,defend_input($_POST['source_select']));
		$comision = mysqli_real_escape_string($connect_link,defend_input($_POST['comission']));
		$crediscont = mysqli_real_escape_string($connect_link,defend_input($_POST['discont']));
		
		$error = array();
		
		if(!$customersel){$error[] = "müştərini mütləq siyahıdan seçin!";}
		if(!$ordersel){$error[] = "kreditə uyğun sifarişi siyahıdan seçin!";}
		if(!$productsel){$error[] = "kredit məhsulunu siyahıdan seçin!";}
		if(!$creditmount){$error[] = "kreditin məbləğini qeyd edin!";}
		if(!$currencysel){$error[] = "kreditin valyutasını siyahıdan seçin!";}
		if(!$credperiod){$error[] = "kreditin müddətini qeyd edin!";}
		if(!$credpercentage){$error[] = "kreditin illik faizini qeyd edin!";}
		if(!$credfypd){$error[] = "kreditin faktiki illik faizini qeyd edin!";}
		if(!$penpercentage){$error[] = "kreditin cərimə faizini qeyd edin!";}
		if(!$rating){$error[] = "müştəriyə verilən reytinqi siyahıdan seçin!";}
		if(!$contract){$error[] = "müştəriylə bağlanılan kredit müqaviləsini siyahıdan seçin!";}
		if(!$source){$error[] = "müştəriyə verilən kreditin mənbəyini siyahıdan seçin!";}
		if(!$comision){$error[] = "kredit verilməsinə görə xidmət haqqını qeyd edin!";}
		
		if(count($error)){
			$_SESSION['msg'] = "<p id='form-error'>".implode('<br>',$error)."</p>";
		}
		else{
			$_SESSION['msg'] = "<p id='form-success'>Kredit uğurla dəyişdirildi!</p>";
			
			$credred = "client='".$customersel."', order_id='".$ordersel."', credit_product='".$productsel."', credit_amount='".$creditmount."', credit_currency='".$currencysel."', credit_period='".$credperiod."', credit_percentage='".$credpercentage."', credit_fypd='".$credfypd."', penalty_percentage='".$penpercentage."', monthly_payment='".$monthpayment."', coefficient='".$coeficent."', rate='".$rating."', type_credit='".$contract."', source_fund='".$source."', cred_comission='".$comision."', concession='".$crediscont."', ofcer_docdate=NOW()";
			
			$credredupdate = mysqli_query($connect_link, "UPDATE cre_data SET $credred WHERE id='$id'");
			
		}
	  }
	}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="author" content="OR-KHAN">
<link href="css/mystyle.css" rel="stylesheet" type="text/css">
<link href="css/reset.css" rel="stylesheet" type="text/css">
<title>Kreditə bax</title>
</head>

<body>
<div id="anablok">
	<div id="basblok">
		<div id="titrblok">
			<?php include("inc_blocks/trblok.php")?>
		</div>
		<div id="ilkblok">
			<?php include("inc_blocks/hmeblok.php")?>
		</div>
	</div>
	<div id="altmenyu">
		<?php include("inc_blocks/dmblok.php")?>
	</div>
	<div id="esasblok">
		<?php include("inc_blocks/vcreblok.php")?>
	</div>
</div>
</body>
</html>
<?php 
}
else{
	header("Location: login");
}
?>