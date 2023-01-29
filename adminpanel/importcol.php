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
    ':person_type'  => $row[0],
    ':mortgagor'  => $row[1],
    ':ceo_post'  => $row[2],
	':ceo_init'  => $row[3],
	':doc_sernum'  => $row[4],
	':doc_govname'  => $row[5],
	':doc_regdate'  => $row[6],
	':reg_address'  => $row[7],
	':fincode_taxes'  => $row[8],
	':phone_numbers'  => $row[9],
    ':email_addr'  => $row[10],
	':pledge_name'  => $row[11],
	':pledge_description'  => $row[12],
    ':pledge_address'  => $row[13],
    ':pledge_cost'  => $row[14],
	':liquid_cost'  => $row[15],
	':pledge_currency'  => $row[16],
	':register_id'  => $row[17],
	':brand'  => $row[18],
	':model'  => $row[19],
	':vehicle_type'  => $row[20],
	':vehicle_colour'  => $row[21],
    ':property_year'  => $row[22],
	':ownership'  => $row[23],
	':portion'  => $row[24],
	':appointment'  => $row[25],
	':appraiser'  => $row[26],
    ':evaluation_date'  => $row[27],
	':insurance_comp'  => $row[28],
	':ins_begindate'  => $row[29],
	':ins_endindate'  => $row[30],
	':ins_cost'  => $row[31],
    ':manager_decision'  => $row[32],
	':agent_chdate'  => $row[33],
	':manager_chdate'  => $row[34],
    ':agent_notes'  => $row[35],
	':manager_notes'  => $row[36],
	':agent'  => $row[37],
    ':manager'  => $row[38]
   );

   $query = "
   INSERT INTO pledge_data (person_type, mortgagor, ceo_post, ceo_init, doc_sernum, doc_govname, doc_regdate, reg_address, fincode_taxes, phone_numbers, email_addr,  pledge_name, pledge_description, pledge_address, pledge_cost, liquid_cost, pledge_currency, register_id, brand, model, vehicle_type, vehicle_colour, property_year, ownership, portion, appointment, appraiser, evaluation_date,  insurance_comp, ins_begindate, ins_endindate, ins_cost, manager_decision, agent_chdate, manager_chdate, agent_notes, manager_notes, agent, manager) VALUES (:person_type, :mortgagor, :ceo_post, :ceo_init, :doc_sernum, :doc_govname, :doc_regdate, :reg_address, :fincode_taxes, :phone_numbers, :email_addr, :pledge_name, :pledge_description, :pledge_address, :pledge_cost, :liquid_cost, :pledge_currency, :register_id, :brand, :model, :vehicle_type, :vehicle_colour, :property_year, :ownership, :portion, :appointment, :appraiser, :evaluation_date, :insurance_comp, :ins_begindate, :ins_endindate, :ins_cost, :manager_decision, :agent_chdate, :manager_chdate, :agent_notes, :manager_notes, :agent, :manager)
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
