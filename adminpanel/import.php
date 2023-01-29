<?php

include 'vendor/autoload.php';

$connect = new PDO("mysql:host=localhost;dbname=kns_baza", "kns_admin", "B9HZVzW1PoChYwHr");

if($_FILES["import_excel"]["name"] != '')
{
 $allowed_extension = array('xls', 'csv', 'xlsx');
 $file_array = explode(".", $_FILES["import_excel"]["name"]);
 $file_extension = end($file_array);

 if(in_array($file_extension, $allowed_extension))
 {
  $file_name = time() . '.' . $file_extension;
  move_uploaded_file($_FILES['import_excel']['tmp_name'], $file_name);
  $file_type = \PhpOffice\PhpSpreadsheet\IOFactory::identify($file_name);
  $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($file_type);

  $spreadsheet = $reader->load($file_name);

  unlink($file_name);

  $data = $spreadsheet->getActiveSheet()->toArray();

  foreach($data as $row)
  {
   $insert_data = array(
    ':unical_credid'  => $row[0],
    ':reminder_maindebt'  => $row[1],
    ':reminder_percdebt'  => $row[2],
	':delayed_maindebt'  => $row[3],
	':delayed_percdebt'  => $row[4],
	':delayed_pendebt'  => $row[5],
	':paid_maindebt'  => $row[6],
	':paid_percdebt'  => $row[7],
	':paid_pendebt'  => $row[8],
	':balout_maindebt'  => $row[9],
    ':balout_percdebt'  => $row[10]
   );

   $query = "
   UPDATE cre_data SET reminder_maindebt='$row[1]', reminder_percdebt='$row[2]', delayed_maindebt='$row[3]', delayed_percdebt='$row[4]', delayed_pendebt='$row[5]', paid_maindebt='$row[6]', paid_percdebt='$row[7]', paid_pendebt='$row[8]', balout_maindebt='$row[9]', balout_percdebt='$row[10]' WHERE unical_credid='$row[0]'
   ";

   $statement = $connect->prepare($query);
   $statement->execute($insert_data);
  }
  $message = '<div id="form-success">Baza uğurla yükləndi</div>';

 }
 else
 {
  $message = '<div id="form-error">Yalnız .xls .csv və ya .xlsx fayl tipləri yüklənə bilər</div>';
 }
}
else
{
 $message = '<div id="form-error">Fayl seç</div>';
}

echo $message;

?>
