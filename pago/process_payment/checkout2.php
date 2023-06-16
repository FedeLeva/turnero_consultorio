
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <style>
      body {
  background: #eaecfa;
}

.loader {
  width: 300px;
  height: 50px;
  
  line-height: 50px;
  text-align: center;
  font-family: helvetica, arial, sans-serif;
  text-transform: uppercase;
  font-weight: 900;
  color: #ce4233;
  letter-spacing: 0.2em;
  
  /* Yatayda ve Düşeyde Ortalama   */ 
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);  
}
.loader::before,
.loader::after {
  content: "";
  display: block;
  width: 15px;
  height: 15px;
  background: #ce4233;
  position: absolute;

  animation: load 0.9s infinite alternate ease-in-out;
}
.loader::before {
  top: 0;
}
.loader::after {
  bottom: 0;
}

@keyframes load {
  0% {
    left: 0;
    height: 30px;
    width: 15px;
  }
  50% {
    height: 8px;
    width: 40px;
  }
  100% {
 
    left: 285px;
    height: 30px;
    width: 15px;
  }
}
    </style>
  <div class="loader">Procesando datos...</div>
</body>
</html>

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





   require_once '../vendor/autoload.php';

   MercadoPago\SDK::setAccessToken("TEST-5952401225197401-042414-2c01f5121619fe18a5dc28ecae3bd178-284444760");
  ;

 

   $payment = new MercadoPago\Payment();
   $payment->transaction_amount = (float)$_POST['transactionAmount'];
   $payment->token = $_POST['token'];
   $payment->description = $_POST['description'];
   $payment->installments = (int)$_POST['installments'];
   $payment->payment_method_id = $_POST['paymentMethodId'];
   $payment->issuer_id = (int)$_POST['issuer'];
   $payer = new MercadoPago\Payer();
   $payer->email = $_POST['email'];
   $payer->identification = array(
       "type" => $_POST['identificationType'],
       "number" => $_POST['identificationNumber']
   );
   $payment->payer = $payer;
   sleep(2);
   
   $findDate = false;
   $mysqli = new mysqli("localhost", "Usuario", "arrozz", "officebd");
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
 if (!$findDate ) {
  $payment->save();
 } else {
  $query = "SELECT * FROM booking 
  WHERE id_date =  " . $id_date . " AND id_turn = " . $id_shift;
   $result = $mysqli->query($query);
   if (!($result->num_rows > 0)) {
    $payment->save();
   };
 }

   
 
   $response = array(
       'status' => $payment->status,
       'status_detail' => $payment->status_detail,
       'id' => $payment->id
   );

   
 
   if ($response['status'] == "approved" ||  $response['status'] == "in_process" ) {
  

 
  
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
        $query = "INSERT INTO patient (name , surname , mail , phone) values (TRIM('".$name. "'),TRIM('" .$surname   ."') ,'". $mail ."','".  $phone  ."') "; 
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
  echo '<script type="text/JavaScript"> 
  sessionStorage.setItem("MP_status",'  . "'" .   json_encode($response)  . "'" . ');
  window.location.href = "../Pagoexitoso.html";
  </script>';

   } else {

    echo '
    <form method="POST"  action="../PagoError.php">
      <input type="hidden" name="error" value='."'" .  json_encode($response)  . "'"  .' >
        <input type="hidden" name="name" value="' . $name. '">
        <input type="hidden" name="surname" value="'.  $surname  .'">
        <input type="hidden" name="mail" value="'.$mail.'">
        <input type="hidden" name="phone" value="'.$phone.'">
        <input type="hidden" name="date" value="'   . str_replace('"' , "'" ,  $_POST['date']).'">
        <input type="hidden" name="schedule" value="'. str_replace('"' , "'" ,  $_POST['schedule']) .'">
        <input type="hidden" name="meeting" value="'. $meeting.'">
        <input type="hidden" name="modality" value="'. $modality.'">
         <input type="hidden" name="price" value=' .number_format(
          intval('' . explode("." , $price)[0] . explode("." , $price)[1]) , 0 , '' , '').'>
    </form>
    <script type="text/JavaScript"> 

    document.querySelector("form").submit();
  </script>';
   }
?>