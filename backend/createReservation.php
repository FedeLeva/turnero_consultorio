<?php
// Paciente
$name = $_POST['name'];
$surname = $_POST['surname'];
$mail = $_POST['mail'];
$phone = $_POST['phone'];
//Fecha
$date = json_decode($_POST['date'] , true );
$day = $date['day'];
$month = $date['month'];
$year = $date['year'];
$nameMonth = $date['nameMonth'];
// Horario
$schedule = json_decode($_POST['schedule'] , true );
$from = $schedule['from'];
$to = $schedule['to'];
$indexDay = $schedule['indexDay'];
// Reserva
$meeting = $_POST['meeting'];
$modality = $_POST['modality'];
// Datos para crear el checkout
$price = $_POST['price'];
$description = '[Especialidad] [Nombre] ' . $meeting;
$service = '[Especialidad]  ' . $meeting . "  " . $modality . " (Nombre)";
$customerTime =  $nameMonth . " " . $day . ", " . $year . " - " . $from;
$MP_identifier = $_POST['MP_identifier'];
$response = array(
    'status' => "approved",
    'id' => $MP_identifier
);



   

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
 if ($findDate ) 
 {
  $query = "SELECT * FROM booking 
  WHERE id_date =  " . $id_date . " AND id_turn = " . $id_shift;
   $result = $mysqli->query($query);
   if (($result->num_rows > 0)) {
    error_log('Se realizo el mismo pago , que hacemos?');
    echo 'Se realizo el mismo pago , que hacemos?';
    exit(0);
   };
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
    echo $query;
    $result = $mysqli->query($query);
    if (!($result->num_rows > 0)) {
        $query = "INSERT INTO patient (name , surname , mail , phone) values ('".$name. "','" .$surname   ."' ,'". $mail ."','".  $phone  ."') "; 
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
 
 
 




 $query = "INSERT INTO booking (id_date  , id_patient , modality , meeting , MP_identifier , price , id_turn) values (". $id_date ." ," .   $id_patient .   ",'". $modality . "','".  $meeting    ."' , " . $MP_identifier .  " , '".  number_format(
  $price , 2 , '.' , '.')  . "', ".$id_shift . ")";



 $mysqli->query($query);
  echo '<script type="text/JavaScript"> 
  sessionStorage.setItem("MP_status",'  . "'" .   json_encode($response)  . "'" . ');
  window.location.href = "../pago/Pagoexitoso.html";
  </script>';
   ?>
