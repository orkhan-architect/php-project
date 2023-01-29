<?php

include 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;


$connect = new PDO("mysql:host=localhost;dbname=kns_baza", "kns_admin", "B9HZVzW1PoChYwHr");


$query = "SELECT * FROM cre_data ORDER BY id DESC";

$statement = $connect->prepare($query);

$statement->execute();

$result = $statement->fetchAll();

if(isset($_POST["export"]))
{
  $file = new Spreadsheet();

  $active_sheet = $file->getActiveSheet();

  $active_sheet->setCellValue('A1', 'Müştəri');
  $active_sheet->setCellValue('B1', 'Kredit məhsulu');
  $active_sheet->setCellValue('C1', 'Məbləği');
  $active_sheet->setCellValue('D1', 'Valyutası');
  $active_sheet->setCellValue('E1', 'Müddəti');
  $active_sheet->setCellValue('F1', 'İllik faizi');
  $active_sheet->setCellValue('G1', 'Başlama tarixi');
  $active_sheet->setCellValue('H1', 'Bitmə tarixi');
  $active_sheet->setCellValue('I1', 'Qalıq əsas məbləğ');
  $active_sheet->setCellValue('J1', 'Qalıq faiz məbləğ');
  $active_sheet->setCellValue('K1', 'Ödənilməmiş əsas məbləğ');
  $active_sheet->setCellValue('L1', 'Ödənilməmiş faiz məbləğ');
  $active_sheet->setCellValue('M1', 'Ödənilməmiş cərimə məbləğ');
  $active_sheet->setCellValue('N1', 'Ödənilmiş əsas məbləğ');
  $active_sheet->setCellValue('O1', 'Ödənilmiş faiz məbləğ');
  $active_sheet->setCellValue('P1', 'Ödənilmiş cərimə məbləğ');
  $active_sheet->setCellValue('Q1', 'Aylıq ödəniş');
  $active_sheet->setCellValue('R1', 'Kreditin statusu');
  $active_sheet->setCellValue('S1', 'DTI əmsalı');
  $active_sheet->setCellValue('T1', 'Reytinq');
  $active_sheet->setCellValue('U1', 'Satış agenti');
  $active_sheet->setCellValue('V1', 'Satış rəhbəri');
  $active_sheet->setCellValue('W1', 'Kreditin unikal ID-i');
  $active_sheet->setCellValue('X1', 'Kreditin tipi');
  $active_sheet->setCellValue('Y1', 'Bal.kənar əsas borc');
  $active_sheet->setCellValue('Z1', 'Bal.kənar faiz borc');
  $active_sheet->setCellValue('AA1', 'Kreditin prolonqasiya sayı');
  $active_sheet->setCellValue('AB1', 'Kreditin restrukturizasiya tarixi');
  $active_sheet->setCellValue('AC1', 'Ödəniş günü');
  $active_sheet->setCellValue('AD1', 'Maliyyələşmə mənbəyi');

  $count = 2;

  foreach($result as $row)
  {
    $active_sheet->setCellValue('A' . $count, $row["client"]);
    $active_sheet->setCellValue('B' . $count, $row["credit_product"]);
    $active_sheet->setCellValue('C' . $count, $row["credit_amount"]);
    $active_sheet->setCellValue('D' . $count, $row["credit_currency"]);
	$active_sheet->setCellValue('E' . $count, $row["credit_period"]);
    $active_sheet->setCellValue('F' . $count, $row["credit_percentage"]);
    $active_sheet->setCellValue('G' . $count, date_format(date_create($row["credit_startdate"]),"d-m-Y"));
    $active_sheet->setCellValue('H' . $count, date_format(date_create($row["credit_enddate"]),"d-m-Y"));
	$active_sheet->setCellValue('I' . $count, $row["reminder_maindebt"]);
    $active_sheet->setCellValue('J' . $count, $row["reminder_percdebt"]);
    $active_sheet->setCellValue('K' . $count, $row["delayed_maindebt"]);
    $active_sheet->setCellValue('L' . $count, $row["delayed_percdebt"]);
	$active_sheet->setCellValue('M' . $count, $row["delayed_pendebt"]);
    $active_sheet->setCellValue('N' . $count, $row["paid_maindebt"]);
    $active_sheet->setCellValue('O' . $count, $row["paid_percdebt"]);
    $active_sheet->setCellValue('P' . $count, $row["paid_pendebt"]);
	$active_sheet->setCellValue('Q' . $count, $row["monthly_payment"]);
    $active_sheet->setCellValue('R' . $count, $row["credit_status"]);
	$active_sheet->setCellValue('S' . $count, $row["coefficient"]);
    $active_sheet->setCellValue('T' . $count, $row["rate"]);
    $active_sheet->setCellValue('U' . $count, $row["credit_officer"]);
    $active_sheet->setCellValue('V' . $count, $row["credit_verifier"]);
	$active_sheet->setCellValue('W' . $count, $row["unical_credid"]);
    $active_sheet->setCellValue('X' . $count, $row["type_credit"]);
    $active_sheet->setCellValue('Y' . $count, $row["balout_maindebt"]);
    $active_sheet->setCellValue('Z' . $count, $row["balout_percdebt"]);
	$active_sheet->setCellValue('AA' . $count, $row["prolong_number"]);
    $active_sheet->setCellValue('AB' . $count, date_format(date_create($row["restruction_date"]),"d-m-Y"));
    $active_sheet->setCellValue('AC' . $count, $row["payment_day"]);
    $active_sheet->setCellValue('AD' . $count, $row["source_fund"]);

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