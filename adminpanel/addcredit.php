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
	
	if($_SESSION['users_role'] == 'user' || $_SESSION['bank_department'] == "system"){
		if($_POST["credit_submit"]){
			
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
		$credofficer = $_SESSION['auth_admin_login'];
		$ver_res = mysqli_query($connect_link,"SELECT compliance FROM users WHERE login='{$_SESSION['auth_admin_login']}'");
		$ver_row = mysqli_fetch_assoc($ver_res);
		$credverifier = $ver_row['compliance'];
		
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
			$_SESSION['msg'] = "<p id='form-success'>Kredit uğurla yaddaşa verildi!</p>";
			mysqli_query($connect_link,"INSERT INTO cre_data(client, order_id, credit_product, credit_amount, credit_currency, credit_period, credit_percentage, credit_fypd, penalty_percentage, monthly_payment, coefficient, rate, type_credit, source_fund, cred_comission, concession, ofcer_docdate, credit_officer, credit_verifier)
						VALUES(
							'".$customersel."',
							'".$ordersel."',
							'".$productsel."',
							'".$creditmount."',
							'".$currencysel."',
							'".$credperiod."',
                            '".$credpercentage."',
							'".$credfypd."',
                            '".$penpercentage."',
							'".$monthpayment."',
							'".$coeficent."',
							'".$rating."',
                            '".$contract."',
							'".$source."',
                            '".$comision."',
                            '".$crediscont."',
							NOW(),
							'".$credofficer."',
							'".$credverifier."'
						)");
			}
		}
	};
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="author" content="OR-KHAN">
<link href="css/mystyle.css" rel="stylesheet" type="text/css">
<link href="css/reset.css" rel="stylesheet" type="text/css">
<title>Kredit əlavə et</title>
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
		<?php include("inc_blocks/acblok.php")?>
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