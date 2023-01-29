<?php 
define('mcsystem', true);
session_start();

require_once 'vendor/autoload.php';		
use \PhpOffice\PhpWord\PhpWord;
use \PhpOffice\PhpWord\Style\Font;
use \PhpOffice\PhpWord\IOFactory;

if($_SESSION['auth_admin'] == "yes_auth"){
	if(isset($_GET["logout"])){
		unset($_SESSION['auth_admin']);
        header("Location: login");
    }
	include("inc_blocks/dbblok.php");
	include("inc_blocks/functions.php");
	
if($_SESSION['users_role'] == 'user' || $_SESSION['bank_department'] == "system"){
	if($_POST["contract_submit"]){		
		$contractclient = mysqli_real_escape_string($connect_link,defend_input($_POST['cont_clientid']));
		$contractcredit = mysqli_real_escape_string($connect_link,defend_input($_POST['contrcreditid']));
		$enteruser = $_SESSION['auth_admin_login'];
		
		$error = array();
		
		if(!$contractclient){$error[] = "müştərinin PİN ID-ni və ya VÖENi qeyd edin!";}
		if(!$contractcredit){$error[] = "mövcud krediti siyahıdan seçin!";}
		
		if($_POST['pledge'] == 'girovlu'){
		$contractpledge = mysqli_real_escape_string($connect_link,defend_input($_POST['contrpledgeid']));
		$contractpleform = mysqli_real_escape_string($connect_link,defend_input($_POST['contrpleform']));
		$error = array();
		if(!$contractpledge){$error[] = "mövcud girovu siyahıdan seçin!";}
		if(!$contractpleform){$error[] = "girovqoyma formasını siyahıdan seçin!";}
			
		$pledgedb = "pledge_id, pledge_form, ";
		$pledgeval = "'".$contractpledge."', '".$contractpleform."', ";
		}
		
		if(count($error)){
			$_SESSION['msg'] = "<p id='form-error'>".implode('<br>',$error)."</p>";
		}
		else{
			$_SESSION['msg'] = "<p id='form-success'>Müqavilə uğurla bazaya əlavə edildi!</p>";
			mysqli_query($connect_link,"INSERT INTO contract_data($pledgedb client_id, credit_id, printed_user, print_date)
						VALUES(
							$pledgeval
							'".$contractclient."',
							'".$contractcredit."',
							'".$enteruser."',
							NOW()
						)");
		}
		$res_cstmr = mysqli_query($connect_link,"SELECT * FROM cstmr_data WHERE login='$contractclient'");
		if(mysqli_num_rows($res_cstmr)>0){$row_customer = mysqli_fetch_assoc($res_cstmr);}
		
		$res_credit = mysqli_query($connect_link,"SELECT * FROM cre_data WHERE id='$contractcredit'");
		if(mysqli_num_rows($res_credit)>0){$row_credit = mysqli_fetch_assoc($res_credit);}
		
		$res_pledge = mysqli_query($connect_link,"SELECT * FROM pledge_data WHERE id='$contractpledge'");
		if(mysqli_num_rows($res_pledge)>0){$row_pledge = mysqli_fetch_assoc($res_pledge);}
		
		$res_branch = mysqli_query($connect_link,"SELECT * FROM branches WHERE branch_code='{$row_customer["branch_code"]}'");
		if(mysqli_num_rows($res_branch)>0){$row_branch = mysqli_fetch_assoc($res_branch);}
		
		$amountwords = number2string($row_credit['credit_amount']);
		
$phpWord = new \PhpOffice\PhpWord\PhpWord();
$phpWord->setDefaultFontName('Times New Roman');
$phpWord->setDefaultFontSize(12);

$section = $phpWord->createSection();
$sectionStyle = $section -> getStyle();
$sectionStyle -> setMarginLeft(\PhpOffice\PhpWord\Shared\Converter::cmToTwip(1.5));
$sectionStyle -> setMarginRight(\PhpOffice\PhpWord\Shared\Converter::cmToTwip(1.5));
		
$section->addText('KREDİT MÜQAVİLƏSİ ('.$row_credit['type_credit'].') - '.$row_credit['unical_credid'], array('bold' => true), array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER));

$fancyTableStyleName = 'Baş cədvəl';
$fancyTableStyle = array('borderSize' => 0, 'borderColor' => 'FFFFFF', 'cellMargin' => 0, 'alignment' => \PhpOffice\PhpWord\SimpleType\JcTable::CENTER, 'cellSpacing' => 0);
$fancyTableCellStyle = array('valign' => 'center');
$phpWord->addTableStyle($fancyTableStyleName, $fancyTableStyle);
$table = $section->addTable($fancyTableStyleName);
$table->addRow();
$table->addCell(5000, $fancyTableCellStyle)->addText($row_branch['region'], array('bold' => true));
$table->addCell(5000, $fancyTableCellStyle)->addText(date("d/m/Y"), array('bold' => true), array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::END));
		
$section->addText('Ümumi müddəalar', array('bold' => true), array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER));
		
$section->addText('Biz aşağıda imza edənlər: bir tərəfdən bundan sonra "Bank" adlandırılacaq öz Nizamnaməsi əsasında fəaliyyət göstərən', array('bold' => false), array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::BOTH));
		
$file = 'HelloWorld.docx';
header("Content-Description: File Transfer");
header('Content-Disposition: attachment; filename="' . $file . '"');
header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document');
header('Content-Transfer-Encoding: binary');
header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
header('Expires: 0');
$xmlWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
$xmlWriter->save("php://output");
exit;
		
/*
require('fpdf/tfpdf.php');

$pdf = new tFPDF();
$pdf->AddPage();

		
$pdf->AddFont('DejaVuSansCondensed-Bold','','DejaVuSansCondensed-Bold.ttf',true);
$pdf->SetFont('DejaVuSansCondensed-Bold','',16);
		$pdf->SetFillColor(250,180,200);

$pdf->Cell(0,4,'Kredit Müqaviləsi № '.$row_credit['unical_credid'],0,1,'C');
$pdf->Ln();

$pdf->SetFont('DejaVuSansCondensed-Bold','',12);
		
$y = $pdf->GetY();
$pdf->MultiCell(90,8,$row_branch['region'],0,'L');
$pdf->SetXY(110,$y);
$pdf->MultiCell(90,8,date("d/m/Y"),0,'R');

$pdf->Cell(0,4,'Ümumi müddəalar',0,1,'C');
$pdf->Ln();

$pdf->AddFont('DejaVuSans','','DejaVuSans.ttf',true);
$pdf->SetFont('DejaVuSans','',12);

$pdf->MultiCell(190,6,'Biz aşağıda imza edənlər birlikdə bundan sonra “Tərəflər” adlandırılaraq bu',0,'FJ');
$pdf->MultiCell(190,6,'müqaviləni aşağıdakı şərtlərlə bağladıq:',0,'L');
$pdf->MultiCell(190,5,'-bir tərəfdən bundan sonra "Bank" adlandırılacaq, öz Nizamnaməsi əsasında fəaliyyət göstərən "Filan Bank" ASC-ni təmsil edən '.$row_branch['boss_post'],0,'FJ');
$pdf->MultiCell(190,5,$row_branch['branch_boss'].' şəxsində',0,'L');
if($row_customer['person_type'] == 'Hüquqi şəxs'){
$pdf->MultiCell(190,5,'-digər tərəfdən bundan sonra "Borcalan" adlandırılacaq, öz Nizamnaməsi əsasında fəaliyyət göstərən '.$row_customer['client'].'-ni təmsil edən '.$row_customer['ceo_post'],0,'FJ');
$pdf->MultiCell(190,5,$row_customer['ceo_init'].' şəxsində',0,'L');}
else{
$pdf->MultiCell(190,5,'-digər tərəfdən bundan sonra "Borcalan" adlandırılacaq, '.$row_customer['client'],0,'FJ');
$pdf->MultiCell(190,5,'['.$row_customer['doc_sernum'].', '.$row_customer['doc_govname'].' '.date_format(date_create($row_customer['doc_regdate']),"d-m-Y").']' ,0,'L');
}

$pdf->Output();
*/
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
<title>Müqavilə çap et</title>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="javascripts/scriptlerim.js"></script>
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
		<?php include("inc_blocks/contradblok.php")?>
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