


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
$nombre = $_POST['nombre'];
$apellido = $_POST['apellido'];
$mail = $_POST['mail'];
$telefono = $_POST['telefono'];
//Fecha
$fecha = json_decode($_POST['fecha'] , true );
$dia = $fecha['dia'];
$mes = $fecha['mes'];
$año = $fecha['año'];
$nombreMes = $fecha['nombreMes'];
// Horario
$horario = json_decode($_POST['horario'] , true );
$desde = $horario['desde'];
$hasta = $horario['hasta'];
$indice_dia = $horario['indice'];
// Reserva
$encuentro = $_POST['encuentro'];
$modalidad = $_POST['modalidad'];
// Datos para crear el checkout
$precio = $_POST['precio'];
$descripcion = '[Especialidad] [Nombre] ' . $encuentro;
$servicio = '[Especialidad]  ' . $encuentro . "  " . $modalidad . " (Nombre)";
$horaCliente =  $nombreMes . " " . $dia . ", " . $año . " - " . $desde;





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


   
   $payment->save();
 
   $response = array(
       'status' => $payment->status,
       'status_detail' => $payment->status_detail,
       'id' => $payment->id
   );

   
 
   if ($response['status'] == "approved" ||  $response['status'] == "in_process" ) {
  
    $mysqli = new mysqli("localhost", "Usuario", "arrozz", "consultoriobd");
    mysqli_set_charset($mysqli, "utf8");
    // id fecha (completar)
    $id_fecha;
    $query = "SELECT * FROM fecha WHERE  date =".$dia." AND mes = ". $mes." AND año = " . $año ."";
    $resultado = $mysqli->query($query);
  
    if (!$resultado->num_rows > 0) {


      $query = "SELECT * from turno 
      join horario on horario.id =  turno.id_horario 
      WHERE indice_dia  = " . $indice_dia;
    
    $resultado = $mysqli->query($query);
    $cant_turnos = $resultado->num_rows - 1;
         $query = "INSERT INTO fecha (date , mes , año , turnos_disponibles) values (".$dia.",".$mes.",". $año . " ,".   $cant_turnos   .  ")";
      if ($mysqli->query($query)) {
      $id_fecha = $mysqli->insert_id;
    } else {
      echo "Falló la creación de la tabla: (" . $mysqli->errno . ") " . $mysqli->error;
    };
    } else {
         $fila = $resultado->fetch_assoc();
         $id_fecha = $fila['ID'];
         if (! $fila['turnos_disponibles'] == 0) {
                $uno_menos = $fila['turnos_disponibles'] - 1;
                 $query = "UPDATE fecha  SET   turnos_disponibles = " . $uno_menos . " WHERE ID  =  " . $id_fecha; 
                
                 $mysqli->query($query);

         } 

    }
 
    // id_paciente
    $id_paciente;
    $query = "SELECT * FROM paciente 
    WHERE nombre = '". $nombre . "' AND apellido = '" . $apellido . "'";
   
    $resultado = $mysqli->query($query);
    if (!$resultado->num_rows > 0) {
        $query = "INSERT INTO paciente (nombre , apellido , mail , telefono) values ('".$nombre. "','" .$apellido   ."' ,'". $mail ."',".  $telefono  .") "; 
    if ($mysqli->query($query)) {
      $id_paciente = $mysqli->insert_id;
    } else {
      echo "Falló la creación de la tabla: (" . $mysqli->errno . ") " . $mysqli->error;
    };
 } else {
     $fila = $resultado->fetch_assoc();
     $id_paciente = $fila['ID'];
 
  
   if (!($fila['mail'] == $mail)) {
     $query = "UPDATE paciente 
     SET mail = '". $mail  . 
     "' WHERE ID =". $id_paciente ;

   
     $mysqli->query($query);
   }


  if (!($fila['telefono'] == $telefono) ) {
   $query = "UPDATE paciente 
   SET telefono = '". $telefono  . 
   "' WHERE ID =". $id_paciente ;
   $mysqli->query($query);
 
  }
 }
 
 
 
 $id_turno;
 $id_horario;
 $query = "SELECT * FROM horario 
 WHERE desde = '" .  $desde . "'";
 
 $resultado = $mysqli->query($query);
 $fila = $resultado->fetch_assoc();
 $id_horario = $fila['ID'];
 $query = "SELECT * FROM turno 
 WHERE indice_dia =  " . $indice_dia . " AND id_horario = " . $id_horario;
 $resultado = $mysqli->query($query);
 $fila = $resultado->fetch_assoc();
 $id_turno = $fila['ID'];
 $query = "INSERT INTO reserva (id_fecha  , id_paciente , modalidad , encuentro , MP_identificador , precio , id_turno) values (". $id_fecha ." ," .   $id_paciente .   ",'". $modalidad . "','".  $encuentro    ."' , " . $payment->id .  " , '".  $precio  . "', ".$id_turno . ")";
 $mysqli->query($query);
  echo '<script type="text/JavaScript"> 
  sessionStorage.setItem("MP_status",'  . "'" .   json_encode($response)  . "'" . ');
  window.location.href = "../Pagoexitoso.html";
  </script>';

   } else {

    echo '
    <form method="POST"  action="../PagoError.php">
      <input type="hidden" name="error" value='."'" .  json_encode($response)  . "'"  .' >
        <input type="hidden" name="nombre" value="' . $nombre. '">
        <input type="hidden" name="apellido" value="'.  $apellido  .'">
        <input type="hidden" name="mail" value="'.$mail.'">
        <input type="hidden" name="telefono" value="'.$telefono.'">
        <input type="hidden" name="fecha" value="'   . str_replace('"' , "'" ,  $_POST['fecha']).'">
        <input type="hidden" name="horario" value="'. str_replace('"' , "'" ,  $_POST['horario']) .'">
        <input type="hidden" name="encuentro" value="'. $encuentro.'">
        <input type="hidden" name="modalidad" value="'. $modalidad.'">
         <input type="hidden" name="precio" value=' .number_format(
          intval('' . explode("." , $precio)[0] . explode("." , $precio)[1]) , 0 , '' , '').'>
    </form>
    <script type="text/JavaScript"> 

    document.querySelector("form").submit();
  </script>';
   }





?>