<?php

include 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;


$connect = new PDO("mysql:host=localhost;dbname=kns_baza", "kns_admin", "B9HZVzW1PoChYwHr");


$query = "SELECT * FROM pledge_data ORDER BY id DESC";

$statement = $connect->prepare($query);

$statement->execute();

$result = $statement->fetchAll();

if(isset($_POST["export"]))
{
  $file = new Spreadsheet();

  $active_sheet = $file->getActiveSheet();

  $active_sheet->setCellValue('A1', 'Girovqoyanın tipi');
  $active_sheet->setCellValue('B1', 'Girovqoyanın inisialı');
  $active_sheet->setCellValue('C1', 'Girovqoyanın vəzifəsi');
  $active_sheet->setCellValue('D1', 'Vəzifəli şəxsin inisialı');
  $active_sheet->setCellValue('E1', 'Vəsiqənin qeydiyyat nömrəsi');
  $active_sheet->setCellValue('F1', 'Vəsiqəni verən orqan');
  $active_sheet->setCellValue('G1', 'Vəsiqənin verilmə tarixi');
  $active_sheet->setCellValue('H1', 'Qeydiyyat ünvanı');
  $active_sheet->setCellValue('I1', 'FİNKOD və ya VÖEN');
  $active_sheet->setCellValue('J1', 'Telefon nömrəsi');
  $active_sheet->setCellValue('K1', 'Mail ünvanı');
  $active_sheet->setCellValue('L1', 'Girovun tipi');
  $active_sheet->setCellValue('M1', 'Girovun təsviri');
  $active_sheet->setCellValue('N1', 'Girovun olduğu ünvan');
  $active_sheet->setCellValue('O1', 'Girov dəyəri');
  $active_sheet->setCellValue('P1', 'Likvid dəyər');
  $active_sheet->setCellValue('Q1', 'Valyutası');
  $active_sheet->setCellValue('R1', 'Ban Şassi Reyestr Hesab');
  $active_sheet->setCellValue('S1', 'Avto marka');
  $active_sheet->setCellValue('T1', 'Avto model');
  $active_sheet->setCellValue('U1', 'Avto tipi');
  $active_sheet->setCellValue('V1', 'Rəngi');
  $active_sheet->setCellValue('W1', 'Buraxılış ili');
  $active_sheet->setCellValue('X1', 'Mülkiyyət tipi');
  $active_sheet->setCellValue('Y1', 'Pay bölgüsü');
  $active_sheet->setCellValue('Z1', 'Təyinat');
  $active_sheet->setCellValue('AA1', 'Qiymətləndirici şirkət');
  $active_sheet->setCellValue('AB1', 'Qiymətqoyma tarixi');
  $active_sheet->setCellValue('AC1', 'Sığortalayıcı şirkət');
  $active_sheet->setCellValue('AD1', 'Sığorta başlama tarixi');
  $active_sheet->setCellValue('AE1', 'Sığorta bitmə tarixi');
  $active_sheet->setCellValue('AF1', 'Sığortalanan dəyər');
  $active_sheet->setCellValue('AG1', 'Menecerin rəyi');
  $active_sheet->setCellValue('AH1', 'Əməkdaşın qeyd tarixi');
  $active_sheet->setCellValue('AI1', 'Menecerin qeyd tarixi');
  $active_sheet->setCellValue('AJ1', 'Əməkdaşın qeydi');
  $active_sheet->setCellValue('AK1', 'Menecerin qeydi');
  $active_sheet->setCellValue('AL1', 'Əməkdaş');
  $active_sheet->setCellValue('AM1', 'Menecer');

  $count = 2;

  foreach($result as $row)
  {
    $active_sheet->setCellValue('A' . $count, $row["person_type"]);
    $active_sheet->setCellValue('B' . $count, $row["mortgagor"]);
    $active_sheet->setCellValue('C' . $count, $row["ceo_post"]);
    $active_sheet->setCellValue('D' . $count, $row["ceo_init"]);
	$active_sheet->setCellValue('E' . $count, $row["doc_sernum"]);
    $active_sheet->setCellValue('F' . $count, $row["doc_govname"]);
    if(isset($row["doc_regdate"])){$active_sheet->setCellValue('G' . $count, date_format(date_create($row["doc_regdate"]),"d-m-Y"));}
    $active_sheet->setCellValue('H' . $count, $row["reg_address"]);
	$active_sheet->setCellValue('I' . $count, $row["fincode_taxes"]);
    $active_sheet->setCellValue('J' . $count, $row["phone_numbers"]);
    $active_sheet->setCellValue('K' . $count, $row["email_addr"]);
    $active_sheet->setCellValue('L' . $count, $row["pledge_name"]);
	$active_sheet->setCellValue('M' . $count, $row["pledge_description"]);
    $active_sheet->setCellValue('N' . $count, $row["pledge_address"]);
    $active_sheet->setCellValue('O' . $count, $row["pledge_cost"]);
    $active_sheet->setCellValue('P' . $count, $row["liquid_cost"]);
	$active_sheet->setCellValue('Q' . $count, $row["pledge_currency"]);
    $active_sheet->setCellValue('R' . $count, $row["register_id"]);
	$active_sheet->setCellValue('S' . $count, $row["brand"]);
    $active_sheet->setCellValue('T' . $count, $row["model"]);
    $active_sheet->setCellValue('U' . $count, $row["vehicle_type"]);
    $active_sheet->setCellValue('V' . $count, $row["vehicle_colour"]);
	$active_sheet->setCellValue('W' . $count, $row["property_year"]);
    $active_sheet->setCellValue('X' . $count, $row["ownership"]);
    $active_sheet->setCellValue('Y' . $count, $row["portion"]);
    $active_sheet->setCellValue('Z' . $count, $row["appointment"]);
	$active_sheet->setCellValue('AA' . $count, $row["appraiser"]);
    if(isset($row["evaluation_date"])){$active_sheet->setCellValue('AB' . $count, date_format(date_create($row["evaluation_date"]),"d-m-Y"));}
    $active_sheet->setCellValue('AC' . $count, $row["insurance_comp"]);
    if(isset($row["ins_begindate"])){$active_sheet->setCellValue('AD' . $count, date_format(date_create($row["ins_begindate"]),"d-m-Y"));}
	if(isset($row["ins_endindate"])){$active_sheet->setCellValue('AE' . $count, date_format(date_create($row["ins_endindate"]),"d-m-Y"));}
	$active_sheet->setCellValue('AF' . $count, $row["ins_cost"]);
	$active_sheet->setCellValue('AG' . $count, $row["manager_decision"]);
	if(isset($row["agent_chdate"])){$active_sheet->setCellValue('AH' . $count, date_format(date_create($row["agent_chdate"]),"d-m-Y H:i:s"));}
	if(isset($row["manager_chdate"])){$active_sheet->setCellValue('AI' . $count, date_format(date_create($row["manager_chdate"]),"d-m-Y H:i:s"));}
	$active_sheet->setCellValue('AJ' . $count, $row["agent_notes"]);
	$active_sheet->setCellValue('AK' . $count, $row["manager_notes"]);
	$active_sheet->setCellValue('AL' . $count, $row["agent"]);
	$active_sheet->setCellValue('AM' . $count, $row["manager"]);

    $count = $count + 1;
  }

  $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($file, $_POST["file_type"]);

  $file_name = time() . '.' . strtolower($_POST["file_type"]);

  $writer->save($file_name);

  header('Content-Type: application/x-www-form-urlencoded');

  header('Content-Transfer-Encoding: Binary');

  header("Content-disposition: attachment; filename=\"".$file_name."\"");

  readfile($file_name);

  unlink($file_name);

  exit;

}

?>