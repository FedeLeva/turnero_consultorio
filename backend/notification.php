<?php
  require_once '../pago/vendor/autoload.php';
 http_response_code(200);
$data = json_decode(file_get_contents('php://input'), true);
$payment;
MercadoPago\SDK::setAccessToken("TEST-5952401225197401-042414-2c01f5121619fe18a5dc28ecae3bd178-284444760");

switch($data["type"]) {
    case "payment":
        $payment = MercadoPago\Payment::find_by_id($data["data"]["id"]);
        // $manuscript = print_r($payment, true);
        // error_log($manuscript);
        if ($payment->status == 'approved') {
           error_log('El pago fue aprobado');
           $metadata = $payment->metadata;
          //    Fecha
           $date = $metadata->date;
           $day = $date->day;
           $month = $date->month;
           $year = $date->year;
           $nameMonth = $date->name_month;
        //    Horario
           $schedule = $metadata->schedule;
           $from = $schedule->from;
           $hasta = $schedule->to;
           $indexDay = $schedule->index_day;
     
        //    Reserva
           $modality = $metadata->modality;
           $meeting = $metadata->meeting;
           $price = $metadata->total_price;
        //    Paciente
           $name = $payment->additional_info->payer->first_name;
           $surname = $payment->additional_info->payer->last_name;
           $phone =  '' .$payment->additional_info->payer->phone->area_code . '-'. $payment->additional_info->payer->phone->number;
           error_log('phone    :    ' .  $phone);
           $mail = $metadata->email;
           $findDate = false;
   $mysqli = new mysqli("localhost", "root", "", "officebd");
   mysqli_set_charset($mysqli, "utf8");
   $id_shift;
   $id_schedule;
   $query = "SELECT * FROM schedule 
   WHERE fromThe = '" .  $from . "'";
 $result = $mysqli->query($query);
 $row = $result->fetch_assoc();
 $id_schedule = $row['ID'];
 $query = "SELECT * FROM turn 
 WHERE dayIndex =  " . $indexDay . " AND id_schedule = " .  $id_schedule;
 $result = $mysqli->query($query);
 $row = $result->fetch_assoc();
 $id_shift = $row['ID'];
 $id_date;
 $rowDate;
 $query = "SELECT * FROM  date WHERE  day =".$day." AND month = ". $month." AND year = " . $year ."";
 $result = $mysqli->query($query);
 if ($result->num_rows > 0) {
  $rowDate = $result->fetch_assoc();
  $id_date = $rowDate['ID'];
  $findDate = true;
 };
 sleep(2);
 if ($findDate )  {
   $query = "SELECT * FROM booking 
  WHERE id_date =  " . $id_date . " AND id_turn = " . $id_shift;
   $result = $mysqli->query($query);
   if ($result->num_rows > 0) {
    error_log('Se realizo el mismo pago , que hacemos?');
    exit(0);
   }
 }
 if (!$findDate) {
    $query = "SELECT * from turn 
    join schedule on schedule.ID =  turn.id_schedule 
    WHERE dayIndex  = " . $indexDay;
  $result = $mysqli->query($query);
   $numberTurns = $result->num_rows - 1;
       $query = "INSERT INTO  date (day , month , year , shifts_available) values (".$day.",".$month.",". $year . " ,".   $numberTurns   .  ")";
     if ($mysqli->query($query)) {
    $id_date = $mysqli->insert_id;
  } else {
    echo "Falló la creación de la tabla: (" . $mysqli->errno . ") " . $mysqli->error;
  };
  } else {
   
       if (!$rowDate['shifts_available'] == 0) {
              $uno_menos = $rowDate['shifts_available'] - 1;
               $query = "UPDATE  date  SET   shifts_available = " . $uno_menos . " WHERE ID  =  " . $id_date; 
               $mysqli->query($query);
       } 
  }

  // id_paciente
  $id_patient;
  $query = "SELECT * FROM patient 
  WHERE name = '". trim($name) . "' AND surname = '" . trim($surname) . "'";
  $result = $mysqli->query($query);
  if (!($result->num_rows > 0)) {
      $query = "INSERT INTO patient (name , surname , mail , phone) values (TRIM('".$name. "'),TRIM('" .$surname   ."') ,'". $mail ."',".  $phone  .") "; 
  if ($mysqli->query($query)) {
    $id_patient = $mysqli->insert_id;
  } else {
    echo "Falló la creación de la tabla: (" . $mysqli->errno . ") " . $mysqli->error;
  };
} else {
 $row = $result->fetch_assoc();
 $id_patient = $row['ID'];


 if (!($row['mail'] == $mail)) {
   $query = "UPDATE patient 
   SET mail = '". $mail  . 
   "' WHERE ID =". $id_patient ;

 
   $mysqli->query($query);
 }


if (!($row['phone'] == $phone) ) {
 $query = "UPDATE patient 
 SET phone = '". $phone  . 
 "' WHERE ID =". $id_patient ;
 $mysqli->query($query);

}
}







$query = "INSERT INTO booking (id_date  , id_patient , modality , meeting , MP_identifier , price , id_turn) values (". $id_date ." ," .   $id_patient .   ",'". $modality . "','".  $meeting    ."' , " . $payment->id .  " , '".  $price  . "', ".$id_shift . ")";
$mysqli->query($query);
error_log('Se crearon las filas en la BD');
}
  
         break;
}

?>
