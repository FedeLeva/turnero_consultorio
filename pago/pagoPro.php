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
// SDK de Mercado Pago
require __DIR__ .  '/vendor/autoload.php';
// Agrega credenciales
MercadoPago\SDK::setAccessToken('TEST-5952401225197401-042414-2c01f5121619fe18a5dc28ecae3bd178-284444760');

// Crea un objeto de preferencia
$preference = new MercadoPago\Preference();
$preference->back_urls = array(
    "success" => "https://www.google.com/",
    "failure" => "https://www.google.com/",
    "pending" => "https://www.google.com/"
);
// Crea un ítem en la preferencia
$item = new MercadoPago\Item();
$item->title = $description;
$item->quantity = 1;
$item->description = $service;
$item->unit_price = $price;
$preference->items = array($item );
$payer = new MercadoPago\Payer();
$payer->email = $mail;
$payer->name =  $name;
$payer->surname = $surname;
$payer->phone = array(
    "area_code" => explode("-" , $phone)[0],
    "number" => explode("-" , $phone)[1],
);
$preference->payer = $payer;
$preference->metadata = array(
    "email" => $mail ,
    "date" => $date ,
    "schedule" => $schedule ,
    "modality" => $modality ,
     "meeting" => $meeting ,
     "totalPrice" => number_format(
        $price , 2 , '.' , '.')
);
$preference->save();
?>




<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
   <style>
    /* wallet Container */
    #wallet_container {
      margin:auto;
    }
   
    /* responsive */
    @media(max-width:300px) {
    button.svelte-ppjtf9.svelte-ppjtf9 {
        min-width:auto !important;
    }

    span.svelte-ppjtf9.svelte-ppjtf9 {
        margin-left:0 !important;
    }
   @media (max-width:230px) {
    span.svelte-ppjtf9.svelte-ppjtf9 {
       font-size:13px !important;
    }

    #wallet_container > div > div > div > div:nth-child(1) > button > p.text-container-2HElEM.svelte-ppjtf9 > span > div {
        display:none;
    }


    h1 {
        font-size:14px;
    }
   }
   </style>
</head>

<body>
    <h1>Checkout Pro</h1>
    <p>No tiene personalización , lo gestiona todo mercado pago <br>Se debe implementar "Notificacion" para saber que se realizo la compra </p>
    <div id="wallet_container"></div>
    <script src="https://sdk.mercadopago.com/js/v2"></script>
    <script>
        const mp = new MercadoPago('TEST-ee10fc35-6c13-4ede-bf9d-3575251ec436', {
            locale: 'es-AR'
        });
        const bricksBuilder = mp.bricks();
        mp.bricks().create("wallet", "wallet_container", {
            initialization: {
                preferenceId: "<?php echo $preference->id ?>",
            },
            
        });
    </script>
</body>

</html>